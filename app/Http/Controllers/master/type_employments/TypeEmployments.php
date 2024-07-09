<?php

namespace App\Http\Controllers\master\type_employments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeEmployments extends Controller
{
    public function index(){
        return view('content.master.type-employments.index');
    }
    public function store(Request $request){
        $type_name = $request->input('typeName');
        $type_employment_id = $request->input('typeId');

        $message = null;
        $payload = null;
        if($type_employment_id ==null){ // add
            $payload = [
            'type_name' => $type_name,
            'soft_delete' => 0
        ];
            $message = "New Type Added";
        }else{           //update

            $payload = [
                'type_employment_id' => $type_employment_id,
                'type_name' => $type_name,
                'soft_delete' => 0
            ];
            $message = "Edit Type Success";

        }

        $data = RequestURI('POST', env('API_URL') . '/type-employments/store', $payload);

        if ($data->success) {
            return redirect('/master-type-employments')->with("success", $message);
        } else {
            return redirect('/master-type-employments')->with("error", $data->errors);
        }
    }
    public function delete(){
        return redirect('/master-type-employments')->with("success", "Delete Type Success");
    }
}
