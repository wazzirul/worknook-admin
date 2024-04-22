<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index(Request $request)
  {
    if ($request->session()->has('authenticated')) {
      return redirect('/dashboard');
    } else {
      return view('content.authentications.auth-login-basic');
    }
  }
  public function logout(Request $request)
  {
    $request->session()->flush();
    return redirect('/');
  }
}
