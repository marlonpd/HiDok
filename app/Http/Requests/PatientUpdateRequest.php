<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::check())
        {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $password = Auth::user()->password;

        return [
            'name' => 'required|max:255',
            'email'    => 'required|email', 
            'old_password' => 'required|password_hash_check:'. $password,
            'password' => 'alphaNum|min:6|confirmed|different:old_password',
            'password_confirmation' => 'alphaNum|min:6|different:old_password|same:password',
            'photo' => 'mimes:jpq,jpeg,png,bmp',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.password_hash_check' => 'Wrong password',
        ];
    }

    public function forbiddenResponse()
    {
        return Response::make('Permission denied foo!', 403);
    }


    public function after($validator)
    {
        $validator->errors()->add('field', 'Something is wrong with this field!');
    }

}
