<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Etudiant extends Model
{
    /** @use HasFactory<\Database\Factories\EtudiantFactory> */
    use HasFactory;
    protected $table ='etudiants';
    protected $fillable = [
            'nom_complet',
            'sexe',
            'niveau',
            'groupe_etudiant_id'
    ];

    public function groupeEtudiant(): BelongsTo
     {
     return $this->belongsTo(
     GroupeEtudiant::class,
     'groupe_etudiant_id'
     );
     }

     public function forView():array{

     return [
     'id'=>$this->id,
     'nomComplet'=>$this->nom_complet,
     'sexe'=>$this->sexe,
     'niveau'=>$this->niveau,




     ];

}
}
