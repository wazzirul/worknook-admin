<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class QueryController extends Controller
{
    function query(Request $request)
    {
        $url = $request->url;
        $method = $request->method ?? 'POST';
        $payload = $request->payload;

        $url = env('API_URL') . $url;
        $method = Str::lower($method);

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                "Authorization" => session()->get('token'),
            ])->$method($url, $payload);
            $data = json_decode($response->body());
            // $response->ok() ? $data = json_decode($response->body()) : $data = null;
        } catch (\Throwable $th) {
            // throw $th;
            $data = "ERROR";
        }

        return $data;
    }

    function queryWithAttachment(Request $request)
    {
        $url = $request->url;
        $method = $request->method ?? 'POST';
        $payload_file = $request->payload_file;
        $file_name = $request->file_name;
        $file = $request->file('file');

        $url = env('API_URL') . $url;
        $method = Str::lower($method);

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                "Authorization" => $request->session()->get('token'),
            ])->attach($payload_file, file_get_contents($file), $file_name)
                ->$method($url);

            $response->ok() ? $data = json_decode($response->body()) : $data = null;
        } catch (\Throwable $th) {
            // throw $th;
            $data = "ERROR";
            // dd($th);
        }

        return $data;
    }
}
