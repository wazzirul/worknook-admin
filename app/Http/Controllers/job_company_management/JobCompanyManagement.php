<?php

namespace App\Http\Controllers\job_company_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobCompanyManagement extends Controller
{
    public function index($slug)
    {
        $payload['company_id'] = $slug;

        // dd($payload);

        $data = RequestURI('POST', env('API_URL') . '/company-jobs/job-list', $payload);

        // dd($data);

        if ($data->success) {
            return view('content.job-company-management.index');
        } else {
            return redirect('/company-management')->with("error", $data->errors);
        }
    }
}
