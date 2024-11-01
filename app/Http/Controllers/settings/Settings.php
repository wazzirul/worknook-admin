<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Settings extends Controller
{
  public function index()
  {
    return view('content.settings.index');
  }

  public function reset_password(Request $request)
  {
    $current_password = $request->input('current_password');
    $new_password = $request->input('new_password');
    $email = $request->input('email');

    $payload = [
      'email' => $email,
      'current_password' => $current_password,
      'new_password' => $new_password,
    ];

    $data = RequestURI('POST', env('API_URL') . '/admins/reset-password', $payload);

    if ($data->success) {
      return redirect('/settings')->with('success', 'Reset Password Success');
    } else {
      return redirect('/settings')->with('error', $data->errors);
    }
  }
}
