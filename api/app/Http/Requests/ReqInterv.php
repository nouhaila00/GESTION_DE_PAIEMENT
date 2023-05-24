<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReqInterv extends FormRequest
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
                    'PPR'=> ['required','string'],
                    'code'=> ['required','string'],
                    'intitule_intervention'=>['required','string'],
                    'Annee_univ'=>['required','date'],
                    'Semestre'=>['required','string'],
                    'Date_debut'=>['required','date'],
                    'Date_fin'=>['required','date','after_or_equal:Date_debut'],
                    'Nbr_heures' => ['required','integer','min:0']
        ];
    }
}
