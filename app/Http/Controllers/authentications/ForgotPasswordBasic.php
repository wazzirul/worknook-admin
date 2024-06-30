<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-forgot-password');
  }

  public function passwordRequest(Request $request)
  {
    $email = $request->input('email');

    $payload['email'] = $email;
    $data = RequestURI('POST', env('API_URL') . '/admins/forgot-password/request', $payload);

    if ($data !== null && isset($data->success) && $data->success) {
      return redirect('/auth/new-password')->with([
        'success' => 'Request sent!',
        'email' => $email,
      ]);
    } elseif ($data !== null && isset($data->errors)) {
      // API returned errors
      return redirect('/auth/forgot-password')->with("error", $data->errors);
    } else {
      // Unexpected API response or null
      return redirect('/auth/forgot-password')->with("error", "An unexpected error occurred. Please try again later.");
    }
  }

  public function passwordSubmit(Request $request)
  {
    $email = $request->input('email');
    $otc = $request->input('otc');
    $newPassword = $request->input('new-password');

    $payload['email'] = $email;
    $payload['code'] = $otc;
    $payload['new_password'] = $newPassword;
    $data = RequestURI('POST', env('API_URL') . '/admins/forgot-password/submit', $payload);

    if ($data !== null && isset($data->success) && $data->success) {
      return redirect('/auth/login')->with('success', 'Password reset successfully');
    } elseif ($data !== null && isset($data->errors)) {
      // API returned errors
      return redirect('/auth/new-password')->with("error", $data->errors);
    } else {
      // Unexpected API response or null
      return redirect('/auth/new-password')->with("error", "An unexpected error occurred. Please try again later.");
    }
  }
}
