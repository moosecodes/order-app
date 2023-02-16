<?php

namespace App\Http\Controllers;

use App\Models\NewsCatcherArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsCatcherAPIController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->fetch();
    }

    public function fetch() {
        $latestHeadline = NewsCatcherArticle::latest('created_at')->first();
        if(isset($latestHeadline)) {
            $latestTimestamp = $latestHeadline->created_at;
            if (Carbon::parse($latestTimestamp)->lte(Carbon::now()->subHour())) {
                try {
                    $this->getLatest();
                } catch(\Exception $e) {
//                dd($e);
                }
            }
        } else {
            try {
                $this->getLatest();
            } catch(\Exception $e) {
//                dd($e);
            }
        }
    }
    public function getLatest()
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
                $newsCatcherArticle = new NewsCatcherArticle;
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
    public function search()
    {
        // https://docs.newscatcherapi.com/api-docs/endpoints/search-news
        return Http::withHeaders(
            ['x-api-key' => env('NEWSCATCHER_API_KEY')])->get(
            env('NEWSCATCHER_API_SEARCH_URL'), [
            'q' => 'tesla',
//                'from' => '2021/12/15',
//                'countries' => 'CA',
//                'page_size' => 1
        ]);
    }
}
