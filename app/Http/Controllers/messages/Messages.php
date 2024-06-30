<?php

namespace App\Http\Controllers\messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Messages extends Controller
{
    public function index()
    {
        return view('content.messages.index');
    }
    public function reply(Request $request)
    {
        $id = $request->input('idMail');
        $subject = $request->input('subject');
        $content = $request->input('content');

        // dd($id, $content);
        $payload['contact_email_id'] = $id;
        $payload['subject'] = $subject;
        $payload['message'] = $content;

        $data = RequestURI('POST', env('API_URL') . '/contact/reply', $payload);

        if ($data->success) {
            return redirect('/messages')->with("success", "Reply Message Sent");
        } else {
            return redirect('/messages')->with("error", $data->errors);
        }
    }
}
