<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChequeRequest extends GenericRequest
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

            'banque_id' => ['required', 'exists:banques,id'],
            'emetteur' => ['required', 'string', 'max:255'],
            'date_emission' => ['required', 'date'],


        ];
    }


    public function messages(): array
    {
         return [
            
           'banque_id.required' => 'La banque est obligatoire.',
            'banque_id.exists' => 'La banque sélectionnée est invalide.',
            'emetteur.required' => "L'émetteur est obligatoire.",
            'date_emission.required' => 'La date d\'émission est obligatoire.',
            'date_emission.date' => 'La date d\'émission doit être une date valide.',
        ];


    }
}
