<?php

namespace App\Http\Controllers\master\skills;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Skills extends Controller
{
    public function index(){
        return view('content.master.skills.index');
    }
    public function store(Request $request){
        $skillName = $request->input('skillName');
        $skill_id = $request->input('skillId');

        $message = null;
        $payload = null;
        if($skill_id ==null){ // add
            $payload = [
            'skill_name' => $skillName,
            'soft_delete' => 0
        ];
            $message = "New Skill Added";
        }else{           //update

            $payload = [
                'skill_id' => $skill_id,
                'skill_name' => $skillName,
                'soft_delete' => 0
            ];
            $message = "Edit Skill Success";

        }

        $data = RequestURI('POST', env('API_URL') . '/skills/store', $payload);

        if ($data->success) {
            return redirect('/master-skills')->with("success", $message);
        } else {
            return redirect('/master-skills')->with("error", $data->errors);
        }
    }
    public function delete(){
        return redirect('/master-skills')->with("success", "Delete Skill Success");
    }
}
