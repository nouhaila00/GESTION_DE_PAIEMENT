<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEns extends FormRequest
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
            'email'=> ['string','unique:users','max:200','email'],
            'password' => ['string','min:8','max:10'],
            'nom' => ['string','max:20'],
            'prenom' => ['string','max:20'],
            'date_naissance' => ['date'],
            'designation' => ['string','in:PA,PH,PES']
        ];
    }
}
