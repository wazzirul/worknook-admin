<?php

namespace App\Http\Controllers\transaction_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionManagement extends Controller
{
  public function index()
  {
    return view('content.transaction-management.index');
  }

  public function store(Request $request)
  {
    $user_transaction_id = $request->input('id');
    $status = $request->input('status');
    $note = $request->input('note');

    $payload['user_transaction_id'] = $user_transaction_id;
    $payload['status'] = $status;
    $payload['note'] = $note;
    $message = $status == 3 ? 'Approve Success' : 'Decline Success';

    $data = RequestURI('POST', env('API_URL') . '/subscriptions/change-status', $payload);

    // dd($data);

    if ($data->success) {
      return redirect('/transaction-management')->with('success', $message);
    } else {
      return redirect('/transaction-management')->with('error', $data->errors);
    }
  }
}
