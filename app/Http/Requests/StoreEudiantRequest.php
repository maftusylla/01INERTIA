<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEudiantRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
        'nom_complet' => [
            'required',
            'string',
            'max:255',
            'regex:/^\p{L}+(?:\s+\p{L}+)*$/u',
        ],
        'sexe' => ['required', 'in:Masculin,Feminin'],
        'niveau' => ['required', 'in:niveau 1,niveau 2,niveau 3'],
    ];
}





    public function messages(): array
    {
        return [
            'nom_complet.required' => 'Veuillez saisir le nom complet de l’étudiant.',
            'nom_complet.string' => 'Le nom complet doit être du texte.',
            'nom_complet.max' => 'Le nom complet ne doit pas dépasser 255 caractères.',
            'nom_complet.regex' => 'Le nom doit contenir uniquement des lettres .',

            'sexe.required' => 'Veuillez sélectionner le sexe de l’étudiant.',
            'sexe.in' => 'Veuillez sélectionner un sexe valide.',

            'niveau.required' => 'Veuillez sélectionner le niveau d’études.',
            'niveau.in' => 'Veuillez sélectionner un niveau valide.',
        ];
    }


    /**
     * Noms lisibles des attributs utilisés dans les erreurs.
     */
    public function attributes(): array
    {
        return [
            'nom_complet' => 'nom complet',
            'sexe' => 'sexe',
            'niveau' => 'niveau',
        ];
    }
}
