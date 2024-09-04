<?php

namespace App\Http\Controllers\plan_subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanSubscriptions extends Controller
{
  public function index()
  {
    return view('content.plan-subscriptions.index');
  }

  public function store(Request $request)
  {
    // dd($request);
    $subscription_id = $request->input('subscriptionId');
    $icon = $request->input('iconEncode');
    $name = $request->input('planName');
    $desc = $request->input('descPlan');
    $post_job = $request->input('postJob');
    $interview = $request->input('interview');
    $team_member = $request->input('teamMember');
    $hire = $request->input('Hire');
    $boostJob = $request->input('boostJob');
    $price = str_replace('$', '', $request->input('price'));
    $status = $request->input('checkStatus');
    $most_popular = $request->input('checkMostPopular');
    $applicationManagement = $request->input('checkApplicationManagement');
    $cp = $request->input('checkCompanyProfile');
    $is = $request->input('checkInterviewScheduling');
    $ci = $request->input('checkCalendarIntegration');
    $hjp = $request->input('checkHiringJobPost');
    $as = $request->input('checkAccountSupport');

    if ($subscription_id) {
      $message = 'Update Subscription Success';
      $payload['subscription_id'] = $subscription_id;
    } else {
      $message = 'New Subscription Added';
    }

    $payload['name'] = $name;
    $payload['icon'] = $icon;
    $payload['description'] = $desc;
    $payload['post_job'] = $post_job;
    $payload['interview'] = $interview;
    $payload['team_member'] = $team_member;
    $payload['hire'] = $hire;
    $payload['boost_job'] = $boostJob;
    $payload['price'] = $price;
    $payload['status'] = $status ? true : false;
    $payload['most_popular'] = $most_popular ? true : false;
    $payload['allow_application_management'] = $applicationManagement ? true : false;
    $payload['allow_company_profile'] = $cp ? true : false;
    $payload['allow_interview_scheduling'] = $is ? true : false;
    $payload['allow_calendar_integration'] = $ci ? true : false;
    $payload['allow_hiring_job_post'] = $hjp ? true : false;
    $payload['allow_account_support'] = $as ? true : false;

    // dd($payload);

    $data = RequestURI('POST', env('API_URL') . '/subscriptions/store', $payload);

    // dd($data);

    if ($data->success) {
      return redirect('/plan-subscriptions')->with('success', $message);
    } else {
      return redirect('/plan-subscriptions')->with('error', $data->errors);
    }
  }

  public function delete()
  {
    return redirect('/plan-subscriptions')->with('success', 'Delete Subscription Success');
  }
}
