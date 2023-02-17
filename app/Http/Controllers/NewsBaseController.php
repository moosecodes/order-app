<?php

namespace App\Http\Controllers;

use App\Models\NewsAPIArticle;
use App\Models\NewsCatcherArticle;
use App\Models\NewsDataArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsBaseController extends Controller
{
    public function all()
    {

    }

    public function like(Request $request) {
        $article = NewsAPIArticle::find($request->article_id);
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

    public function save()
    {
        return NewsBaseController::where()->update(['saved' => true]);
    }

    public function viewed(Request $request) {
        $article = NewsAPIArticle::find($request->article_id);
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

    public function search(Request $request) {
        return array_filter([
            NewsAPIArticle::where('title', 'LIKE', "%{$request->searchQuery}%")->get(),
            NewsDataArticle::where('title', 'LIKE', "%{$request->searchQuery}%")->get(),
            NewsCatcherArticle::where('title', 'LIKE', "%{$request->searchQuery}%")->get(),
        ], function($item) {
            if(count($item) > 0) {
                return true;
            }
            return false;
        });
    }
}
