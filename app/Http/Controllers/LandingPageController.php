<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Events\LandingPageVisitEvent;
use App\Models\LandingPageVisit;
use App\Models\NewsCatcherArticle;
use App\Models\NewsDataArticle;
use App\Models\TopHeadline;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class LandingPageController extends Controller
{
    public function __construct()
    {

    }

    public function showNews(
        TopHeadline $topHeadlines,
        NewsCatcherArticle $newsCatcherArticle,
        NewsDataArticle $newsDataArticle
    ) {
            $this->saveVisitCount();

            $latestHeadline = $topHeadlines::latest('created_at')->first();
            if(isset($latestHeadline)) {
                $latestTimestamp = $latestHeadline->created_at;
                // $latestTimestamp is at least one hour ago
                if (Carbon::parse($latestTimestamp)->lte(Carbon::now()->subHour())) {
                    $this->fetchNewsFromNewsAPI($topHeadlines);
                }
            } else {
                try {
                    // no articles, $latestHeadline is null
                    $this->fetchNewsFromNewsAPI($topHeadlines);
                } catch(\Exception $e) {

                }
            }

            $latestHeadline = $newsCatcherArticle::latest('created_at')->first();
            if(isset($latestHeadline)) {
                $latestTimestamp = $latestHeadline->created_at;
                // $latestTimestamp is at least one hour ago
                if (Carbon::parse($latestTimestamp)->lte(Carbon::now()->subHour())) {
                    $this->fetchFromNewsCatcherAPI($newsCatcherArticle);
                }
            } else {
                try {
                    // no articles, $latestHeadline is null
                    $this->fetchFromNewsCatcherAPI($newsCatcherArticle);
                } catch(\Exception $e) {

                }
            }

            $latestHeadline = $newsDataArticle::latest('created_at')->first();
            if(isset($latestHeadline)) {
                $latestTimestamp = $latestHeadline->created_at;
                // $latestTimestamp is at least one hour ago
                if (Carbon::parse($latestTimestamp)->lte(Carbon::now()->subHour())) {
                    $this->fetchFromNewsDataAPI($newsDataArticle);
                }
            } else {
                try {
                    // no articles, $latestHeadline is null
                    $this->fetchFromNewsDataAPI($newsDataArticle);
                } catch(\Exception $e) {

                }
            }

        // Slack notification
        LandingPageVisitEvent::dispatch([ 'message' => $_SERVER['REMOTE_ADDR']]);

        return Inertia::render('NewsReaderZeroAuth', [
            'newsapi_api'       => $topHeadlines::orderBy('id', 'DESC')->limit(12)->get(),
            'newscatcher_api'   => $newsCatcherArticle::orderBy('id', 'DESC')->limit(12)->get(),
            'newsdata_api'      => $newsDataArticle::orderBy('id', 'DESC')->limit(12)->get(),
            'canLogin'          => Route::has('login'),
            'canRegister'       => Route::has('register')
        ]);
    }

    public function saveVisitCount()
    {
        $revisit = LandingPageVisit::where('source', '=', $_SERVER['REMOTE_ADDR'])->first();

        if(isset($revisit->count) && $revisit->count > 0) {
            $revisit->count += 1;
            $revisit->save();
        } else {
            $visit = new LandingPageVisit;
            $visit->source = $_SERVER['REMOTE_ADDR'];
            $visit->count = 1;
            $visit->save();
        }
    }

    public function fetchFromNewsDataAPI(NewsDataArticle $newsDataArticle)
    {
        // https://newsdata.io/documentation
        $response = Http::get(env('NEWSDATA_API_URL'), [
            'apikey' => env('NEWSDATA_API_KEY'),
            'country' => 'us',
//            'category' => 'sports,health',
            'language' => 'en',
        ]);

        $articles = $response['results'];

        for($x = 0; $x < count($articles); $x++) {
            if (
                isset($articles[$x]['title']) &&
                isset($articles[$x]['link']) &&
                ! $newsDataArticle::where('title', $articles[$x]['title'])->exists()
            ) {
                $newsDataArticle->api_source = 'newsdata.io';

                $newsDataArticle->title = $articles[$x]['title'];
                $newsDataArticle->link = $articles[$x]['link'];
                $newsDataArticle->video_url = $articles[$x]['video_url'];
                $newsDataArticle->pubDate = $articles[$x]['pubDate'];
                $newsDataArticle->image_url = $articles[$x]['image_url'];
                $newsDataArticle->source_id = $articles[$x]['source_id'];
                $newsDataArticle->language = $articles[$x]['language'];
                $newsDataArticle->description = $articles[$x]['description'];
                $newsDataArticle->content = $articles[$x]['content'];

//                $newsDataArticle->keywords = implode(', ', $articles[$x]['keywords']);
//                $newsDataArticle->creator = implode(', ', $articles[$x]['creator']);
//                $newsDataArticle->category = implode(', ', $articles[$x]['category']);
//                $newsDataArticle->country = implode(', ', $articles[$x]['country']);

                $newsDataArticle->save();
            }
        }
    }

    // News Catcher API
    public function fetchFromNewsCatcherAPI(NewsCatcherArticle $newsCatcherArticle)
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
                ! $newsCatcherArticle::where('title', $articles[$x]['title'])->exists()
            ) {
                $newsCatcherArticle->api_source = 'newscatcherapi.com';

                $newsCatcherArticle->is_opinion = $articles[$x]['is_opinion'];
                $newsCatcherArticle->rank = $articles[$x]['rank'];
                $newsCatcherArticle->_score = $articles[$x]['_score'];
                $newsCatcherArticle->title = $articles[$x]['title'];
                $newsCatcherArticle->author = $articles[$x]['author'];
                $newsCatcherArticle->published_date = $articles[$x]['published_date'];
                $newsCatcherArticle->published_date_precision = $articles[$x]['published_date_precision'];
                $newsCatcherArticle->link = $articles[$x]['link'];
                $newsCatcherArticle->clean_url = $articles[$x]['clean_url'];
                $newsCatcherArticle->topic = $articles[$x]['topic'];
                $newsCatcherArticle->country = $articles[$x]['country'];
                $newsCatcherArticle->language = $articles[$x]['language'];
                $newsCatcherArticle->authors = $articles[$x]['authors'];
                $newsCatcherArticle->media = $articles[$x]['media'];
                $newsCatcherArticle->twitter_account = $articles[$x]['twitter_account'];
                $newsCatcherArticle->_id = $articles[$x]['_id'];
                $newsCatcherArticle->excerpt = $articles[$x]['excerpt'];
                $newsCatcherArticle->summary = $articles[$x]['summary'];

                $newsCatcherArticle->save();
            }
        }
    }

    // News Catcher Search
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

    // News API
    public function fetchNewsFromNewsAPI(TopHeadline $topHeadline)
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
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
                ! $topHeadline::where('title', $allArticles[$x]['title'])->exists()
            ) {
                $topHeadline->api_source = 'newsapi.org';

                $topHeadline->source = $allArticles[$x]['source']['name'];
                $topHeadline->author = $allArticles[$x]['author'];
                $topHeadline->title = $allArticles[$x]['title'];
                $topHeadline->description = $allArticles[$x]['description'];
                $topHeadline->url = $allArticles[$x]['url'];
                $topHeadline->urlToImage = $allArticles[$x]['urlToImage'];
                $topHeadline->publishedAt = $allArticles[$x]['publishedAt'];
                $topHeadline->content = $allArticles[$x]['content'];
                $topHeadline->save();
            }
        }
    }

}
