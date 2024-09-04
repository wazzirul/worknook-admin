<?php

namespace App\Http\Controllers\plan_alacarte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanAlacarte extends Controller
{
  public function index()
  {
    return view('content.plan-alacarte.index');
  }

  public function store(Request $request)
  {
    $post_job = $request->input('postJob');
    $interview = $request->input('interview');
    $team_member = $request->input('teamMember');
    $hire = $request->input('hire');
    $post_boost = $request->input('postBoost');
    $apj = $request->input('checkPostJob');
    $apb = $request->input('checkPostBoost');
    $ait = $request->input('checkInterview');
    $atm = $request->input('checkTeamMember');
    $ahi = $request->input('checkHire');

    $payload['price_per_post_job'] = $post_job;
    $payload['price_per_post_boost'] = $post_boost;
    $payload['price_per_interview'] = $interview;
    $payload['price_per_team_member'] = $team_member;
    $payload['price_per_hire'] = $hire;

    $payload['allow_add_post_job'] = $apj ? true : false;
    $payload['allow_add_post_boost'] = $apb ? true : false;
    $payload['allow_add_interview'] = $ait ? true : false;
    $payload['allow_add_team_member'] = $atm ? true : false;
    $payload['allow_add_hire'] = $ahi ? true : false;

    $data = RequestURI('POST', env('API_URL') . '/subscriptions/alacarte/store', $payload);

    // dd($data);

    if ($data->success) {
      return redirect('/plan-alacarte')->with('success', 'Update Success');
    } else {
      return redirect('/plan-alacarte')->with('error', $data->errors);
    }
  }
}
