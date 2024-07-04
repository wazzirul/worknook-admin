<?php

namespace App\Http\Controllers\blog_categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogCategories extends Controller
{
    public function index()
    {
        return view('content.blog-category.index');
    }
}
