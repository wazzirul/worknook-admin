<?php

namespace App\Http\Controllers\blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Blogs extends Controller
{
    public function index()
    {
        return view('content.blogs.index');
    }
    public function details($slug)
    {
        return view('content.blogs.details');
    }
}
