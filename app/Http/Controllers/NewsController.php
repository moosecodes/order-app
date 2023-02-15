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
    public function __construct()
    {
    }

    public function show(TopHeadline $topHeadlines)
    {
        return Inertia::render('NewsReader', [
            'news' => $topHeadlines::orderBy('id', 'DESC')->limit(10)->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function search(Request $request) {
        return TopHeadline::where('title', 'LIKE', "%{$request->searchQuery}%")->get();
    }

    public function like(Request $request) {
        $article = TopHeadline::find($request->article_id);
        $article?->update(['favs' => $article->favs + 1]);

        Http::withHeaders(['Content-type' => 'application/json'])->post(
            env('SLACK_WEBHOOK_JETSTORM'),
            [
                'text' =>
                    "👍 Article {$article->id} liked! - {$article->favs} total likes\n" .
                    substr($article->title, 0, 140) . "\n\n"
            ]
        );

        return $article;
    }

    public function articleViewed(Request $request) {
        $article = TopHeadline::find($request->article_id);
        $article?->update(['views' => $article->views + 1]);

        Http::withHeaders(['Content-type' => 'application/json'])->post(
            env('SLACK_WEBHOOK_JETSTORM'),
            [
                'text' =>
                    "🤓 Article (id: {$article->id}) viewed! - {$article->views} total views\n" .
                    substr($article->title, 0, 140) . "\n\n"
            ]
        );

        return $article;
    }
}
