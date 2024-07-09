<?php

namespace App\Http\Controllers\master\industries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Industries extends Controller
{
    public function index(){
        return view('content.master.industries.index');
    }
    public function store(Request $request){
        $industryName = $request->input('industryName');
        $industry_id = $request->input('industryId');

        $message = null;
        $payload = null;
        if($industry_id ==null){ // add
            $payload = [
            'industry_name' => $industryName,
            'soft_delete' => 0
        ];
            $message = "New Type Added";
        }else{           //update

            $payload = [
                'industry_id' => $industry_id,
                'industry_name' => $industryName,
                'soft_delete' => 0
            ];
            $message = "Edit Type Success";

        }

        $data = RequestURI('POST', env('API_URL') . '/industries/store', $payload);

        if ($data->success) {
            return redirect('/master-industries')->with("success", $message);
        } else {
            return redirect('/master-industries')->with("error", $data->errors);
        }
    }
    public function delete(){
        return redirect('/master-industries')->with("success", "Delete Type Success");
    }
}
