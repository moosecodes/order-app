<?php

namespace App\Http\Controllers;

use App\Models\NewsDataArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsDataAPIController extends Controller
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
        $latestHeadline = NewsDataArticle::latest('created_at')->first();
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
                ! NewsDataArticle::where('title', $articles[$x]['title'])->exists()
            ) {
                $newsDataArticle = new NewsDataArticle;
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
}
