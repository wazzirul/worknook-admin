<?php

namespace App\Http\Controllers\messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HTMLPurifier;
use HTMLPurifier_Config;

class Messages extends Controller
{
    public function index()
    {
        return view('content.messages.index');
    }
    public function store(Request $request)
    {
        $id = $request->input('idMail');
        $subject = $request->input('subject');
        $content = $request->input('content');

        // Configure HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($content);

        // dd($id, $content);
        $payload['contact_email_id'] = $id;
        $payload['subject'] = $subject;
        $payload['message'] = $sanitizedContent;

        $data = RequestURI('POST', env('API_URL') . '/customer-support/reply', $payload);

        if ($data->success) {
            return redirect('/customer-support')->with("success", "Reply Message Sent");
        } else {
            return redirect('/customer-support')->with("error", $data->errors);
        }
    }
    public function reply(Request $request)
    {
        $id = $request->input('idMail');
        $subject = $request->input('subject');
        $content = $request->input('content');

        // Configure HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($content);

        // dd($id, $content);
        $payload['contact_email_id'] = $id;
        $payload['subject'] = $subject;
        $payload['message'] = $sanitizedContent;

        $data = RequestURI('POST', env('API_URL') . '/customer-support/reply', $payload);

        if ($data->success) {
            return redirect('/customer-support')->with("success", "Reply Message Sent");
        } else {
            return redirect('/customer-support')->with("error", $data->errors);
        }
    }
}
