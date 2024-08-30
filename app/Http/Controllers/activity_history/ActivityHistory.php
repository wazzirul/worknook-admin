<?php

namespace App\Http\Controllers\activity_history;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityHistory extends Controller
{
  public function index()
  {
    // $page = $request->query('page', null);

    // $payload['paginate'] = 10;

    // if ($page == null) {
    //   $data = RequestURI('POST', env('API_URL') . '/users-history/show', $payload);
    // } else {
    //   $data = RequestURI('POST', env('API_URL') . '/users-history/show?page=' . $page, $payload);
    // }

    // if ($data->success) {
    // return view('content.activity-history.index', compact('data'));
    return view('content.activity-history.index');
    // } else {
    //   return redirect('/blogs')->with('error', $data->errors);
    // }
  }
}
