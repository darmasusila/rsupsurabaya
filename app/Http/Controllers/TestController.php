<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SdmEmail;

class TestController extends Controller
{
    public static function kirimemail()
    {
        // $user = Auth::user();
        // if ($user) {
        try {
            Mail::to("testing@malasngoding.com")->send(new SdmEmail());
            return "Email telah dikirim";
        } catch (\Throwable $th) {
            throw $th;
        }

        // }
        // return redirect()->back()->with('error', 'User not authenticated.');
    }
}
