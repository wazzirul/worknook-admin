<?php

namespace App\Http\Controllers\team_company_management;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamCompanyManagement extends Controller
{
  public function index($slug)
  {
    $payloadJob['user_id'] = $slug;
    $payloadComp['user_id'] = $slug;

    $dataJob = RequestURI('POST', env('API_URL') . '/company-team/show', $payloadJob);
    $dataComp = RequestURI('POST', env('API_URL') . '/company/show', $payloadComp);

    // dd($dataComp);

    if ($dataJob->success && $dataComp->success) {
      return view('content.team-company-management.index', compact('dataComp')); //also send dataComp response to blade file
    } else {
      return redirect('/company-management')->with('error', $dataJob->errors);
    }
  }
}
