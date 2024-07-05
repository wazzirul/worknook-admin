<?php

namespace App\Http\Controllers\job_company_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobCompanyManagement extends Controller
{
    public function index($slug)
    {
        $payloadJob['company_id'] = $slug;
        $payloadComp['user_id'] = $slug;

        $dataJob = RequestURI('POST', env('API_URL') . '/company-jobs/job-list', $payloadJob);
        $dataComp = RequestURI('POST', env('API_URL') . '/company/show', $payloadComp);

        // dd($dataComp);

        if ($dataJob->success && $dataComp->success) {
            return view('content.job-company-management.index', compact('dataComp')); //also send dataComp response to blade file
        } else {
            return redirect('/company-management')->with("error", $dataJob->errors);
        }
    }
    public function delete($slug){
        return redirect('/company-details/'.$slug)->with("success", "Close Job Success");
    }
}
