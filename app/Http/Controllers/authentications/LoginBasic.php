<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index(Request $request)
  {
    if ($request->session()->has('authenticated')) {
      return redirect('/');
    } else {
      return view('content.authentications.auth-login');
    }
  }

  public function authenticate(Request $request)
  {
    $email = $request->input('email');
    $password = $request->input('password');
    $remember = $request->has('remember');

    $payload['email'] = $email;
    $payload['password'] = $password;

    $data = RequestURI('POST', env('API_URL') . '/admins/login', $payload);

    // dd($data);
    if ($data !== null && isset($data->success) && $data->success) {
      $request->session()->put('authenticated', true);
      $request->session()->put('id', $data->data->id);
      $request->session()->put('fullname', $data->data->fullname);
      $request->session()->put('email', $data->data->email);
      $request->session()->put('profile_photo', $data->data->profile_photo);
      $request->session()->put('role', $data->data->role);
      $request->session()->put('token', $data->data->token);
      $menu = [];
      if ($data->data->role != 1) {
        $payloadMenu['admin_id'] = $data->data->id;
        $dataMenu = RequestURI('POST', env('API_URL') . '/admin-permission/show', $payloadMenu);

        if ($dataMenu != null) {
          foreach ($dataMenu->data->permission as $item) {
            $menu[] = $item->name;
          }
        } else {
          $request->session()->flush();
          return redirect('/auth/login')->with(
            'error',
            'Your access rights are still empty, please contact your superadmin!'
          );
        }
      }
      $request->session()->put('menu', $menu);

      // Check if "Remember Me" is checked
      if ($remember) {
        $minutes = 60; // You can adjust this value as needed
        return redirect('/')->withCookie(cookie('email', $email, $minutes));
      }

      return redirect('/')->with('success', 'Login successful.');
    } elseif ($data !== null && isset($data->errors)) {
      // API returned errors
      return redirect('/auth/login')->with('error', $data->errors);
    } else {
      // Unexpected API response or null
      return redirect('/auth/login')->with('error', 'An unexpected error occurred. Please try again later.');
    }
  }

  public function logout(Request $request)
  {
    $request->session()->flush();
    return redirect('/auth/login')->with('success', 'You have been logged out!');
  }
}
