<?php

namespace App\Http\Controllers\user_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagement extends Controller
{
    public function index()
    {
        return view('content.user-management.index');
    }
}
