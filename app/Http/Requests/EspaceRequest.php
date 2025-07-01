<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EspaceRequest extends GenericRequest
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

           'nom_famille' => ['required', 'string', 'max:255'],
        ];
    }


    public function messages(): array
    {
         return [

          'nom_famille.required' => 'Le nom de la famille est obligatoire.',
            'nom_famille.string' => 'Le nom de la famille doit être une chaîne de caractères.',
            'nom_famille.max' => 'Le nom de la famille ne peut pas dépasser 255 caractères.',
        ];


    }
}
