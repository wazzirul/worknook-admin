<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
  {
    $dataSummary = RequestURI('GET', env('API_URL') . '/admin-dashboard/summary');
    if ($dataSummary->success) {
      return view('content.dashboard.dashboards-analytics', ['summary' => $dataSummary->data]);
    } else {
      return redirect('/')->with('error', $dataSummary->errors);
    }
  }
}
