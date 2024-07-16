<?php

namespace App\Http\Controllers\job_list;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobList extends Controller
{
    public function index()
    {
        $data = RequestURI('GET', env('API_URL') . '/jobs/show-all');
        if ($data->success) {
            return view('content.job-list.index', compact('data'));
        } else {
            return redirect('/')->with("error", $data->errors);
        }
    }

    public function details($slug)
    {
        return view('content.job-list.details');
    }

    public function delete()
    {
        return redirect('/job-list')->with("success", "Job Delete Success");
    }
}
