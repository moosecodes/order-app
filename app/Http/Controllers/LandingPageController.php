<?php

namespace App\Http\Controllers;

use App\Events\LandingPageVisitEvent;
use App\Models\TopHeadline;
use App\Models\LandingPageVisit;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LandingPageController extends Controller
{
    private string $query;

    public function __construct($query = '')
    {
        $this->query = $query;
    }

    public function show(TopHeadline $topHeadlines)
    {
        $this->fetchNews();
//        LandingPageVisitEvent::dispatch(LandingPageVisit::orderBy('id', 'DESC')->first());
        LandingPageVisitEvent::dispatch(['message' => $_SERVER['REMOTE_ADDR']]);

        return Inertia::render('NewsReaderZeroAuth', [
            'news' => $topHeadlines::orderBy('id', 'DESC')->limit(50)->get(),
            'query' => $this->query,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function fetchNews()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'apiKey' => env('NEWSAPI_ORG_KEY')
        ]);

        $articles = $response->json()['articles'];

        $allArticles = $articles;

        if(isset($this->query) && $this->query != '') {
            $search = Http::get('https://newsapi.org/v2/everything', [
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
