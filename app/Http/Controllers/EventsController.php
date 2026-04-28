<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\News;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    //
    public function index() {
    $events = Events::all();
    $news=News::all();
    // هنا نبعثوا الأحداث لصفحة الأخبار
    return view('news', compact('events','news'));
}

}
