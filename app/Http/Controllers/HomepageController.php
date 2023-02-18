<?php

namespace App\Http\Controllers;

use App\Events\HomepageEvent;
use App\Models\LandingPageVisit;
use App\Models\NewsCatcherArticle;
use App\Models\NewsDataArticle;
use App\Models\NewsAPIArticle;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class HomepageController extends Controller
{
    public function __construct()
    {

    }

    public function show(NewsAPIArticle $newsAPIArticle, NewsCatcherArticle $newsCatcherArticle, NewsDataArticle $newsDataArticle
    ): \Inertia\Response
    {
        $this->saveVisitCount();

        // Slack notification
//        HomepageEvent::dispatch([ 'message' => $_SERVER['REMOTE_ADDR']]);

        // render homepage
        return Inertia::render('Homepage', [
            'articles' => [
                'newsapi' => $newsAPIArticle::orderBy('id', 'DESC')->limit(12)->get(),
                'newscatcherapi' => $newsCatcherArticle::orderBy('id', 'DESC')->limit(12)->get(),
                'newsdataapi' => $newsDataArticle::orderBy('id', 'DESC')->limit(12)->get(),
            ],
            'trending' => [
                'newsapi' => NewsAPIArticle::orderBy('favs', 'DESC')->where('favs', '>', 0)->limit(2)->get(),
                'newsdataapi' => NewsDataArticle::orderBy('favs', 'DESC')->where('favs', '>', 0)->limit(2)->get(),
                'newscatcherapi' => NewsCatcherArticle::orderBy('favs', 'DESC')->where('favs', '>', 0)->limit(2)->get(),
            ],
            'canLogin'          => Route::has('login'),
            'canRegister'       => Route::has('register')
        ]);
    }

    public function saveVisitCount()
    {
        $revisit = LandingPageVisit::where('remote_addr', '=', $_SERVER['REMOTE_ADDR'])->first();

        if(isset($revisit->count) && $revisit->count > 0) {
            $revisit->count += 1;
            $revisit->save();
        } else {
            $visit = new LandingPageVisit;
            $visit->remote_addr = $_SERVER['REMOTE_ADDR'];
            $visit->server_name = $_SERVER['HTTP_USER_AGENT'];
            $visit->count = 1;
            $visit->save();
        }
    }
}
