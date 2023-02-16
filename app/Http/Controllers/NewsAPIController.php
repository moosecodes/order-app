<?php

namespace App\Http\Controllers;

use App\Models\NewsAPIArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                $this->getLatest();
            }
        } else {
            $this->getLatest();
        }
    }
    #[NoReturn] public function getLatest()
    {
        try {
            $response = Http::get('https://newsapi.org/v2/top-headlines', [
                'country' => 'us',
                'apiKey' => env('NEWSAPI_ORG_KEY')
            ]);

            $articles = $response->json()['articles'];

//            if(isset($request->searchQuery)) {
//                $search = Http::get(env('NEWSAPI_ORG_URL'), [
//                    'q' => $request->searchQuery,
//                    'apiKey' => env('NEWSAPI_ORG_KEY')
//                ]);
//                $searchJson = $search->json()['articles'];
//                $allArticles = array_merge($articles, $searchJson);
//            }

            for($x = 0; $x < count($articles); $x++) {
                if (
                    isset($articles[$x]['author']) &&
                    isset($articles[$x]['content']) &&
                    ! NewsAPIArticle::where('title', $articles[$x]['title'])->exists()
                ) {
                    $topHeadline = new NewsAPIArticle;
                    $topHeadline->api_source = 'newsapi.org';

                    $topHeadline->source = $articles[$x]['source']['name'];
                    $topHeadline->author = $articles[$x]['author'];
                    $topHeadline->title = $articles[$x]['title'];
                    $topHeadline->description = $articles[$x]['description'];
                    $topHeadline->url = $articles[$x]['url'];
                    $topHeadline->urlToImage = $articles[$x]['urlToImage'];
                    $topHeadline->publishedAt = $articles[$x]['publishedAt'];
                    $topHeadline->content = $articles[$x]['content'];
                    $topHeadline->save();
                }
            }

        } catch(\Exception $e) {
            dd($e);
        }
    }

//    public function show(NewsAPIArticle $topHeadlines)
//    {
//        return Inertia::render('NewsReader', [
//            'news' => $topHeadlines::orderBy('id', 'DESC')->limit(10)->get(),
//            'canLogin' => Route::has('login'),
//            'canRegister' => Route::has('register')
//        ]);
//    }
}
