<?php

namespace App\Http\Controllers;

use App\Models\NewsAPIArticle;
use App\Models\NewsCatcherArticle;
use App\Models\NewsDataArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsBaseController extends Controller
{
    public function like(Request $request) {
        $source = $request->source;
        $id = $request->article_id;

        if($source === 'newsapi') {
            $article = NewsAPIArticle::find($id);
        } else if($source === 'newsdataapi') {
            $article = NewsDataArticle::find($id);
        } else if($source === 'newscatcherapi') {
            $article = NewsCatcherArticle::find($id);
        }

        if(isset($article)) {
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
        } else {
            return 'erroor';
        }
    }

    public function save(Request $request)
    {
        $source = $request->source;
        $id = $request->article_id;

        if($source === 'newsapi') {
            $article = NewsAPIArticle::find($id);
        } else if($source === 'newsdataapi') {
            $article = NewsDataArticle::find($id);
        } else if($source === 'newscatcherapi') {
            $article = NewsCatcherArticle::find($id);
        }

        if(isset($article)) {
            $article?->update(['saves' => $article->saves + 1]);

            Http::withHeaders(['Content-type' => 'application/json'])->post(
                env('SLACK_WEBHOOK_JETSTORM'),
                [
                    'text' =>
                        "👍 Article {$article->id} saved! - {$article->saves} total saves\n" .
                        substr($article->title, 0, 140) . "\n\n"
                ]
            );

            return $article;
        } else {
            return 'erroor';
        }
    }

    public function viewed(Request $request) {
        $source = $request->source;
        $id = $request->article_id;

        if(!isset($source)) {
            return 'No source provided to add to view count';
        }
        if($source === 'newsapi') {
            $article = NewsAPIArticle::find($id);
        } else if($source === 'newsdataapi') {
            $article = NewsDataArticle::find($id);
        } else if($source === 'newscatcherapi') {
            $article = NewsCatcherArticle::find($id);
        }

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
            'newsapi' => NewsAPIArticle::where('title', 'LIKE', "%{$request->searchQuery}%")->get(),
            'newsdataapi' => NewsDataArticle::where('title', 'LIKE', "%{$request->searchQuery}%")->get(),
            'newscatcherapi' => NewsCatcherArticle::where('title', 'LIKE', "%{$request->searchQuery}%")->get(),
        ], function($item) { if(count($item) > 0) { return true; } return false; });
    }
}
