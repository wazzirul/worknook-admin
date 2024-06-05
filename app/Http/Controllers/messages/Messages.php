<?php

namespace App\Http\Controllers\messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Messages extends Controller
{
    public function index()
    {
        return view('content.messages.index');
    }
}
