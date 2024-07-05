<?php

namespace App\Http\Controllers\job_list;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobList extends Controller
{
    public function index()
    {
        return view('content.job-list.index');
    }

    public function delete(){
        return redirect('/job-list')->with("success", "Job Delete Success");
    }
}
