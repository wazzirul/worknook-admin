<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Session;

function RequestURI($method, $url, $data = null)
{
    $method = Str::lower($method);

    try {
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            "Authorization" => session()->get('auth_token'),
            // "Authorization" => Session::get('auth_token'),
        ])->$method($url, $data);

        // $response->ok() ? $data = json_decode($response->body()) : $data = null;
        if ($response->ok()) {
            $data = json_decode($response->body());
        } else {
            $data = json_decode($response->body());
        }
    } catch (\Throwable $th) {
        // throw $th;
        $data = "ERROR";
    }

    return $data;
}
