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
    public function saveVisitCount()
    {
        $revisit = LandingPageVisit::where('remote_addr', '=', $_SERVER['REMOTE_ADDR'])->first();

        if(isset($revisit->count) && $revisit->count > 0) {
            $revisit->count += 1;
            $revisit->save();
        } else {
            $visit = new LandingPageVisit;
            $visit->remote_addr = $_SERVER['REMOTE_ADDR'];
            $visit->server_name = $_SERVER['SERVER_NAME'];
            $visit->count = 1;
            $visit->save();
        }
    }

    public function showHomepage(
        NewsAPIArticle     $topHeadlines,
        NewsCatcherArticle $newsCatcherArticle,
        NewsDataArticle    $newsDataArticle
    ): \Inertia\Response
    {
        $this->saveVisitCount();

        // Slack notification
        HomepageEvent::dispatch([ 'message' => $_SERVER['REMOTE_ADDR']]);

        // render homepage
        return Inertia::render('NewsReaderZeroAuth', [
            'newsapi_api'       => $topHeadlines::orderBy('id', 'DESC')->limit(12)->get(),
            'newscatcher_api'   => $newsCatcherArticle::orderBy('id', 'DESC')->limit(12)->get(),
            'newsdata_api'      => $newsDataArticle::orderBy('id', 'DESC')->limit(12)->get(),
            'canLogin'          => Route::has('login'),
            'canRegister'       => Route::has('register')
        ]);
    }
}
