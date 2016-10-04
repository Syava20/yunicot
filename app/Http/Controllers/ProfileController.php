<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Requests\ProfileRequest;
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

    public function edit(){
        return view('profile.edit');
    }

    public function store(ProfileRequest $request){
        $currentUser = User::find(Auth::id());

        $currentUser->firstName = $request->firstName;
        $currentUser->lastName = $request->lastName;
        $currentUser->email = $request->email;
        $currentUser->sex = $request->sex;
        if(strlen($request->password)){
            $currentUser->password = bcrypt($request->password);
        }
        $currentUser->save();

        return redirect('/'.Auth::id());
    }
}
