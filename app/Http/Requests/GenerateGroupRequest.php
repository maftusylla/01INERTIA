<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenerateGroupRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer la requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation de la taille des groupes.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'taille_groupe' => ['required', 'integer', 'min:2', 'max:100'],
        ];
    }

    /**
     * Messages personnalisés en français.
     */
    public function messages(): array
    {
        return [
            'taille_groupe.required' => 'Veuillez indiquer le nombre d’étudiants par groupe.',
            'taille_groupe.integer' => 'Le nombre d’étudiants par groupe doit être un nombre entier.',
            'taille_groupe.min' => 'Un groupe doit contenir au moins 2 étudiants.',
            'taille_groupe.max' => 'Un groupe ne peut pas dépasser 100 étudiants.',
        ];
    }

    /**
     * Nom lisible du champ dans les erreurs.
     */
    public function attributes(): array
    {
        return [
            'taille_groupe' => 'nombre d’étudiants par groupe',
        ];
    }
}
