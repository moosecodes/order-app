<?php

namespace App\Http\Controllers;

use App\Events\LandingPageVisitEvent;
use App\Models\LandingPageVisit;
use App\Models\TopHeadline;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class LandingPageController extends Controller
{
    private string $query;

    public function __construct($query = '')
    {
        $this->query = $query;
    }

    public function show(TopHeadline $topHeadlines, LandingPageVisit $visit)
    {
        $this->save();

        $message = [ 'message' => $_SERVER['REMOTE_ADDR']];

        LandingPageVisitEvent::dispatch($message);

        return Inertia::render('NewsReaderZeroAuth', [
            'news' => $topHeadlines::orderBy('id', 'DESC')->limit(50)->get(),
            'query' => $this->query,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    public function save()
    {
        $visit = new LandingPageVisit;
        $visit->source = $_SERVER['REMOTE_ADDR'];
        $visit->save();
    }
}
