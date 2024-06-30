<?php

namespace App\Http\Controllers\candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Candidate extends Controller
{
    public function index()
    {
        return view('content.candidate.index');
    }
    public function details()
    {
        return view('content.candidate.details');
    }
}
