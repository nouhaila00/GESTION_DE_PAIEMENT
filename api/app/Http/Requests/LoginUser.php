<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required','string','email'],
            'password' => ['required','string','min:6','max:8'],
             'type' => ['required','string','in:Enseignant,Admin_Etablissement,Admin_Université,President,Directeur']
        ];
    }
}
