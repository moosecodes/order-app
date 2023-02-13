<?php

namespace App\Http\Controllers;

use App\Models\TopHeadline;
use App\Models\NewsDataArticle;
use App\Models\NewsCatcherArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class NewsController extends Controller
{
    private string $query;

    public function __construct($query = '')
    {
        $this->query = $query;
    }

    public function show(TopHeadline $topHeadlines)
    {
        $this->fetchNewsFromNewsAPI();

        return Inertia::render('NewsReader', [
            'news' => $topHeadlines::orderBy('id', 'DESC')->limit(10)->get(),
            'query' => $this->query,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function search(Request $request) {
        return TopHeadline::where('title', 'LIKE', "%{$request->searchQuery}%")->get();
    }

    public function like(Request $request) {
        $headline = TopHeadline::find($request->id);
        $headline?->update(['favs' => $headline->favs + 1]);

        Http::withHeaders(['Content-type' => 'application/json'])->post(
            env('SLACK_WEBHOOK_JETSTORM'),
            ['text' => 'article liked!']
        );

        return $headline;
    }

    public function articleViewed(Request $request) {
        $article = TopHeadline::find($request->id);
        $article?->update(['views' => $article->views + 1]);

        Http::withHeaders(['Content-type' => 'application/json'])->post(
            env('SLACK_WEBHOOK_JETSTORM'),
            ['text' => 'article read!']
        );

        return $article;
    }

    public function fetchFromNewsDataAPI()
    {
        // https://newsdata.io/documentation
        $response = Http::get(env('NEWSDATA_API_URL'), [
            'apikey' => env('NEWSDATA_API_KEY'),
            'country' => 'us',
//            'category' => 'sports,health',
//            'language' => 'en',
        ]);

        $articles = $response['results'];

        for($x = 0; $x < count($articles); $x++) {
            if (
                isset($articles[$x]['title']) &&
                isset($articles[$x]['link']) &&
                ! NewsDataArticle::where('title', $articles[$x]['title'])->exists()
            ) {
                $newsdata = new NewsDataArticle;

                $newsdata->api_source = env('NEWSDATA_API_URL');

                $newsdata->title = $articles[$x]['title'];
                $newsdata->link = $articles[$x]['link'];
                $newsdata->video_url = $articles[$x]['video_url'];
                $newsdata->pubDate = $articles[$x]['pubDate'];
                $newsdata->image_url = $articles[$x]['image_url'];
                $newsdata->source_id = $articles[$x]['source_id'];
                $newsdata->language = $articles[$x]['language'];
                $newsdata->description = $articles[$x]['description'];
                $newsdata->content = $articles[$x]['content'];

                $newsdata->keywords = implode(', ', $articles[$x]['keywords']);
                $newsdata->creator = implode(', ', $articles[$x]['creator']);
                $newsdata->category = implode(', ', $articles[$x]['category']);
                $newsdata->country = implode(', ', $articles[$x]['country']);

                $newsdata->save();
            }
        }
    }

    public function fetchFromNewsCatcherAPI()
    {
        // https://docs.newscatcherapi.com/api-docs/endpoints/latest-headlines
        $response = Http::withHeaders(
            ['x-api-key' => env('NEWSCATCHER_API_KEY')])->get(
            env('NEWSCATCHER_API_LATEST_URL'), [
            'countries' => 'US',
//            'topic' => 'business'
        ]);

        $articles = $response->json()['articles'];

        for($x = 0; $x < count($articles); $x++) {
            if(
                isset($articles[$x]['title']) &&
                isset($articles[$x]['link']) &&
                ! NewsCatcherArticle::where('title', $articles[$x]['title'])->exists()
            ) {
                $newscatcher = new NewsCatcherArticle;

                $newscatcher->api_source = env('NEWSCATCHER_API_LATEST_URL');
                $newscatcher->is_opinion = $articles[$x]['is_opinion'];
                $newscatcher->rank = $articles[$x]['rank'];
                $newscatcher->_score = $articles[$x]['_score'];
                $newscatcher->title = $articles[$x]['title'];
                $newscatcher->author = $articles[$x]['author'];
                $newscatcher->published_date = $articles[$x]['published_date'];
                $newscatcher->published_date_precision = $articles[$x]['published_date_precision'];
                $newscatcher->link = $articles[$x]['link'];
                $newscatcher->clean_url = $articles[$x]['clean_url'];
                $newscatcher->topic = $articles[$x]['topic'];
                $newscatcher->country = $articles[$x]['country'];
                $newscatcher->language = $articles[$x]['language'];
                $newscatcher->authors = $articles[$x]['authors'];
                $newscatcher->media = $articles[$x]['media'];
                $newscatcher->twitter_account = $articles[$x]['twitter_account'];
                $newscatcher->_id = $articles[$x]['_id'];
                $newscatcher->excerpt = $articles[$x]['excerpt'];
                $newscatcher->summary = $articles[$x]['summary'];

                $newscatcher->save();
            }
        }
    }

    public function searchNewsCatcherAPI()
    {
        // https://docs.newscatcherapi.com/api-docs/endpoints/search-news
        $response = Http::withHeaders(
            ['x-api-key' => env('NEWSCATCHER_API_KEY')])->get(
            env('NEWSCATCHER_API_SEARCH_URL'), [
                'q' => 'tesla',
//                'from' => '2021/12/15',
//                'countries' => 'CA',
//                'page_size' => 1
        ]);

        return $response;
    }

    public function fetchNewsFromNewsAPI($country = 'us')
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => $country,
            'apiKey' => env('NEWSAPI_ORG_KEY')
        ]);

        $articles = $response->json()['articles'];

        $allArticles = $articles;

        if(isset($this->query) && $this->query != '') {
            $search = Http::get(env('NEWSAPI_ORG_URL'), [
                'q' => $this->query,
                'apiKey' => env('NEWSAPI_ORG_KEY')
            ]);
            $searchJson = $search->json()['articles'];
            $allArticles = array_merge($articles, $searchJson);
        }

        for($x = 0; $x < count($allArticles); $x++) {
            if (
                isset($allArticles[$x]['author']) &&
                isset($allArticles[$x]['content']) &&
                ! TopHeadline::where('title', $allArticles[$x]['title'])->exists()
            ) {
                $top = new TopHeadline;
                $top->api_source = env('NEWSAPI_ORG_URL');
                $top->source = $allArticles[$x]['source']['name'];
                $top->author = $allArticles[$x]['author'];
                $top->title = $allArticles[$x]['title'];
                $top->description = $allArticles[$x]['description'];
                $top->url = $allArticles[$x]['url'];
                $top->urlToImage = $allArticles[$x]['urlToImage'];
                $top->publishedAt = $allArticles[$x]['publishedAt'];
                $top->content = $allArticles[$x]['content'];
                $top->save();
            }
        }
    }

}
