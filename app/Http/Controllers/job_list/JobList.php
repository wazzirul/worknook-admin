<?php

namespace App\Http\Controllers\job_list;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobList extends Controller
{
  public function index()
  {
    $data = RequestURI('GET', env('API_URL') . '/jobs/show-all');
    if ($data->success) {
      return view('content.job-list.index', compact('data'));
    } else {
      return redirect('/')->with('error', $data->errors);
    }
  }

  public function details($slug)
  {
    $payload = [
      'job_id' => $slug,
    ];
    $data = RequestURI('POST', env('API_URL') . '/jobs/show', $payload);
    if ($data->success) {
      return view('content.job-list.details', compact('data'));
    } else {
      return redirect('/')->with('error', $data->errors);
    }
  }
  public function store(Request $request)
  {
    $job_id = $request->input('jobID');
    $job_title = $request->input('jobTitle');
    $job_level = $request->input('jobLevel');
    $job_type = $request->input('jobType');
    $job_category = $request->input('jobCategories');
    $job_desc = $request->input('description');
    $location = $request->input('location');
    $start_salary = $request->input('startSalary');
    $top_salary = $request->input('topSalary');
    $responsibilities = $request->input('responsibilities');
    $job_skill = $request->input('jobSkill');

    $message = null;
    $payload = null;
    if ($job_id == null) {
      // add
      $payload = [
        'soft_delete' => 0,
      ];
      $message = 'New Job Added';
    } else {
      //update

      $payload = [
        'job_id' => $job_id,
        'job_title' => $job_title,
        'job_level_id' => $job_level,
        'type_employment_id' => $job_type,
        'category_id' => $job_category,
        'job_description' => $job_desc,
        'location' => $location,
        'start_salary' => $start_salary,
        'top_salary' => $top_salary,
        'responsibilities' => $responsibilities,
        'skill_id' => $job_skill,
      ];
      $message = 'Edit Job Success';
    }
    dd($payload);
    $data = RequestURI('POST', env('API_URL') . '/jobs/store', $payload);

    if ($data->success) {
      return redirect('/job-list/details/' . $job_id)->with('success', $message);
    } else {
      return redirect('/job-list')->with('error', $data->errors);
    }
  }
  public function delete()
  {
    return redirect('/job-list')->with('success', 'Job Delete Success');
  }
}
