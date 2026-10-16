<?php
namespace App\Services;

use App\Models\Etudiant;

class ClasseDatabaseService
{
 public function lire():array{

 return ['apprenants'=>$this->etudiants()];
 }

 public function etudiants(){

      return Etudiant::query()
            ->orderBy('id')
            ->get()
            ->map(fn (Etudiant $etudiant) => $this->toArray($etudiant))
            ->all();

}

public function toArray(Etudiant $etudiant):array{

        return [
            'id' => $etudiant->id,
            'nomComplet' => $etudiant->nom_complet,
            'sexe' => $etudiant->sexe,
            'niveau' => $etudiant->niveau,
        ];


}
}


