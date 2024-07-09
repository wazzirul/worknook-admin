<?php

namespace App\Http\Controllers\master\job_levels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobLevels extends Controller
{
    public function index(){
        return view('content.master.job-levels.index');
    }
    public function store(Request $request){
        $levelName = $request->input('levelName');
        $job_level_id = $request->input('jobLevelId');

        $message = null;
        $payload = null;
        if($job_level_id ==null){ // add
            $payload = [
            'level_name' => $levelName,
            'soft_delete' => 0
        ];
            $message = "New Level Added";
        }else{           //update

            $payload = [
                'job_level_id' => $job_level_id,
                'level_name' => $levelName,
                'soft_delete' => 0
            ];
            $message = "Edit Level Success";

        }

        $data = RequestURI('POST', env('API_URL') . '/job-levels/store', $payload);

        if ($data->success) {
            return redirect('/master-job-levels')->with("success", $message);
        } else {
            return redirect('/master-job-levels')->with("error", $data->errors);
        }
    }
    public function delete(){
        return redirect('/master-job-levels')->with("success", "Delete Level Success");
    }
}
