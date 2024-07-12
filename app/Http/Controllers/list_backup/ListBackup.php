<?php

namespace App\Http\Controllers\list_backup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListBackup extends Controller
{
    public function index(){
        return view('content.list-backup.index');
    }   
}
