<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\BinaryOp\Concat;

class NewsController extends Controller
{
    //
    public function index()
    {
        $news = News::all();
        return view('news',compact('news'));
    }
}
