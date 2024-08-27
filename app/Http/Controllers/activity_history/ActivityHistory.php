<?php

namespace App\Http\Controllers\activity_history;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityHistory extends Controller
{
  public function index(Request $request)
  {
    $payload['paginate'] = 1;
    $data = RequestURI('POST', env('API_URL') . '/users-history/show', $payload);
    if ($data->success) {
      return view('content.activity-history.index', compact('data'));
    } else {
      return redirect('/blogs')->with('error', $data->errors);
    }
  }
}
