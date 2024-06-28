<?php

namespace App\Http\Controllers\blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Blogs extends Controller
{
    public function index()
    {
        $data = RequestURI('POST', env('API_URL') . '/blog-categories/show');
        if ($data->success) {
            return view('content.blogs.index', compact('data'));
        } else {
            return redirect('/blogs')->with("error", $data->errors);
        }
    }
    public function details($slug)
    {
        $payloadJob['company_id'] = $slug;
        $payloadComp['user_id'] = $slug;

        $dataJob = RequestURI('POST', env('API_URL') . '/company-jobs/job-list', $payloadJob);
        $dataComp = RequestURI('POST', env('API_URL') . '/company/show', $payloadComp);

        // dd($dataComp);

        if ($dataJob->success && $dataComp->success) {
            return view('content.blogs.details', compact('dataComp')); //also send dataComp response to blade file
        } else {
            return redirect('/company-management')->with("error", $dataJob->errors);
        }
    }
}
