<?php

namespace App\Http\Controllers;

use App\Models\TopHeadlines;
use App\Models\WeatherReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchNews()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'country' => 'us',
            'apiKey' => '685d98b8c13e4d2a87f7ede9a30c454a'
        ]);

        $articles = $response->json()['articles'];

        for($x = 0; $x < count($articles); $x++) {
            if (!TopHeadlines::where('title', $articles[$x]['title'])->exists()) {
                $top = new TopHeadlines;
                $top->source = $articles[$x]['source']['name'];
                $top->author = $articles[$x]['author'];
                $top->title = $articles[$x]['title'];
                $top->description = $articles[$x]['description'];
                $top->url = $articles[$x]['url'];
                $top->urlToImage = $articles[$x]['urlToImage'];
                $top->publishedAt = $articles[$x]['publishedAt'];
                $top->content = $articles[$x]['content'];
                $top->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopHeadlines  $topHeadlines
     * @return \Illuminate\Http\Response
     */
    public function show(TopHeadlines $topHeadlines)
    {
        $this->fetchNews();

        return Inertia::render('TopHeadlines', [
            'news' => TopHeadlines::orderBy('id', 'DESC')->get()
        ]);
    }
}
