<?php

namespace App\Http\Controllers;

use App\Models\NewsAPIArticle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;

class NewsAPIController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        $this->fetch();
    }

    public function fetch() {
        $latestHeadline = NewsAPIArticle::latest('created_at')->first();
        if(isset($latestHeadline)) {
            $latestTimestamp = $latestHeadline->created_at;
            if (Carbon::parse($latestTimestamp)->lte(Carbon::now()->subHour())) {
                $this->get_top_headlines();
            }
        } else {
            $this->get_top_headlines();
        }
    }
    #[NoReturn] public function get_top_headlines()
    {
        try {
            $response = Http::get('https://newsapi.org/v2/top-headlines', [
                'country' => 'us',
                'apiKey' => env('NEWSAPI_ORG_KEY')
            ]);

            $articles = $response->json()['articles'];

            for($x = 0; $x < count($articles); $x++) {
                if (
                    isset($articles[$x]['author']) &&
                    isset($articles[$x]['content']) &&
                    ! NewsAPIArticle::where('title', $articles[$x]['title'])->exists()
                ) {
                    $newsApiArticle = new NewsAPIArticle;
                    $newsApiArticle->api_source = 'newsapi.org';

                    $newsApiArticle->source = $articles[$x]['source']['name'];
                    $newsApiArticle->author = $articles[$x]['author'];
                    $newsApiArticle->title = $articles[$x]['title'];
                    $newsApiArticle->description = $articles[$x]['description'];
                    $newsApiArticle->url = $articles[$x]['url'];
                    $newsApiArticle->urlToImage = $articles[$x]['urlToImage'];
                    $newsApiArticle->publishedAt = $articles[$x]['publishedAt'];
                    $newsApiArticle->content = $articles[$x]['content'];
                    $newsApiArticle->save();
                }
            }

        } catch(\Exception $e) {
            dd($e);
        }
    }
}
