<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegisterAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $allowedUserTypes = ['Admin_Université']; 
        $userType = Auth::User()->type; 

      return in_array($userType, $allowedUserTypes);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=> ['required','string','unique:users','max:200','email'],
            'password' => ['required','string','min:8','max:10'],
            'type' => ['required','in:Admin_Etablissement,Directeur,President'],
            'PPR' => ['required','string','max:20','unique:administrateurs'],
            'nom' => ['required','string','max:20'],
            'prenom' => ['required','string','max:20'],
            'date_naissance' => ['required','date'],
             'code' => ['required','string','unique:etablissements']
        ];
    }
}
