<?php

namespace App\Http\Controllers\master\tech_stacks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TechStacks extends Controller
{
    public function index(){
        return view('content.master.tech-stacks.index');
    }
    public function store(Request $request){
        $stackName = $request->input('stackName');
        $tech_stack_id = $request->input('techStackId');
        $stack_icon = $request->input('thumbnailEncode');

        $message = null;
        $payload = null;
        if($tech_stack_id ==null){ // add
            $payload = [
            'stack_name' => $stackName,
            'stack_icon' => $stack_icon,
            'soft_delete' => 0
        ];
            $message = "New Tech Stack Added";
        }else{           //update

            $payload = [
                'tech_stack_id' => $tech_stack_id,
                'stack_name' => $stackName,
                'stack_icon' => $stack_icon,
                'soft_delete' => 0
            ];
            $message = "Edit Tech Stack Success";

        }

        $data = RequestURI('POST', env('API_URL') . '/tech-stacks/store', $payload);

        if ($data->success) {
            return redirect('/master-tech-stacks')->with("success", $message);
        } else {
            return redirect('/master-tech-stacks')->with("error", $data->errors);
        }
    }
    public function delete(){
        return redirect('/master-tech-stacks')->with("success", "Delete Tech Stack Success");
    }
}
