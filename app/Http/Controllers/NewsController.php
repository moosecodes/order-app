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

    // News Data API

}
