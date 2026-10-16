<?php

namespace App\Models;

use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupeEtudiant extends Model
{
    /** @use HasFactory<\Database\Factories\GroupeEtudiantFactory> */
    use HasFactory;
    protected $table = 'groupe_etudiants';

    protected $fillable = [
        'nom',
    ];

    public function etudiants(): HasMany
    {
        return $this->hasMany(
            Etudiant::class,
            'groupe_etudiant_id'
        );
    }
}


