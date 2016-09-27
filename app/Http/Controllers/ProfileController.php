<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\User;

class ProfileController extends Controller
{
    public function show(Request $request, $id){
        if(Auth::user()->id == $id){
            return view('profile.my');
        }
        else{
            return 'Ooops';
        }
    }

    public function edit($id){
        return view('profile.edit');
    }
}
