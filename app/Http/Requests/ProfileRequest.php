<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('id') == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|alpha|max:50',
            'lastName' => 'required|alpha|max:50',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'sex' => 'required|in:0,1',
            'password' => 'alpha_dash|min:6|max:100|confirmed'
        ];
    }
}
