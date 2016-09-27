<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Config;
use App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function change(Request $request, $locale){
        if(in_array($locale, Config::get('app.locales'))){
            $request->session()->put('locale', $locale);
        }
        return redirect()->back();
    }
}
