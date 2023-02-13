<?php

namespace App\Http\Controllers;

use App\Events\LandingPageVisitEvent;
use App\Models\LandingPageVisit;
use App\Models\NewsCatcherArticle;
use App\Models\NewsDataArticle;
use App\Models\TopHeadline;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class LandingPageController extends Controller
{
    private string $query;

    public function __construct($query = '')
    {

    }

    public function show(
        TopHeadline $topHeadlines,
        NewsCatcherArticle $newsCatcherArticle,
        NewsDataArticle $newsDataArticle)
    {
        $this->saveVisitorIpAddress();

        $message = [ 'message' => $_SERVER['REMOTE_ADDR']];

        LandingPageVisitEvent::dispatch($message);

        return Inertia::render('NewsReaderZeroAuth', [
            'news' => $topHeadlines::orderBy('id', 'DESC')->limit(10)->get(),
            'newscatcher_api' => $newsCatcherArticle::orderBy('id', 'DESC')->limit(10)->get(),
            'newsdata_api' => $newsDataArticle::orderBy('id', 'DESC')->limit(10)->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function saveVisitorIpAddress()
    {
        $returnVisit = LandingPageVisit::where('source', '=', $_SERVER['REMOTE_ADDR'])->first();

        if(isset($returnVisit->count) && $returnVisit->count > 0) {
            $returnVisit->count += 1;
            $returnVisit->save();
        } else {
            $newVisit = new LandingPageVisit;
            $newVisit->source = $_SERVER['REMOTE_ADDR'];
            $newVisit->count = 1;
            $newVisit->save();
        }
    }
}
