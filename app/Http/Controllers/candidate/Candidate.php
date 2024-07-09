<?php

namespace App\Http\Controllers\candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Candidate extends Controller
{
    public function index()
    {
        $dataSummary = RequestURI('GET', env('API_URL') . '/admin-applicant/summary');
        if ($dataSummary->success) {
            return view('content.candidate.index', ['summary' => $dataSummary->data]);
        } else {
            return redirect('/candidate')->with("error", $dataSummary->errors);
        }
        // return view('content.candidate.index');
    }
    public function details()
    {
        return view('content.candidate.details');
    }
}
