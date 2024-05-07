<?php

namespace App\Http\Controllers\company_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyManagement extends Controller
{
    public function index()
    {
        return view('content.company-management.index');
    }
    public function store(Request $request)
    {
        $fullname = $request->input('basicFullname');
        $profilePicture = $request->input('profileEncode');
        $email = $request->input('basicEmail');
        $role = $request->input('role');
        $password = $request->input('password');

        $payload['admin_id'] = null;
        $payload['fullname'] = $fullname;
        $payload['profile_photo'] = $profilePicture;
        $payload['email'] = $email;
        $payload['password'] = $password;
        $payload['role'] = $role;

        // dd($payload);

        $data = RequestURI('POST', env('API_URL') . '/admins/store', $payload);

        // dd($data);

        if ($data->success) {
            return redirect('/user-management')->with("success", "New User Added");
        } else {
            return redirect('/user-management')->with("error", $data->errors);
        }
    }

    public function update(Request $request)
    {
        $adminId = $request->input('id');
        $fullname = $request->input('basicFullname');
        $profilePicture = $request->input('profileEncode') ?? null;
        $email = $request->input('basicEmail');
        $role = $request->input('role');

        $payload['admin_id'] = $adminId;
        $payload['fullname'] = $fullname;
        $payload['profile_photo'] = $profilePicture;
        $payload['email'] = $email;
        $payload['role'] = $role;

        // dd($payload);

        $data = RequestURI('POST', env('API_URL') . '/admins/store', $payload);

        // dd($data);

        if ($data->success) {
            return redirect('/user-management')->with("success", "User Updated");
        } else {
            return redirect('/user-management')->with("error", $data->errors);
        }
    }
}
