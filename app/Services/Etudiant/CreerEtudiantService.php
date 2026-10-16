<?php
namespace App\Services\Etudiant;

use App\Contracts\Repositories\EtudiantRepositoryInterface;
use App\DTOs\Etudiant\CreateEtudiantData;
use App\Models\Etudiant;

class CreerEtudiantService
{
    public function __construct(
        private readonly EtudiantRepositoryInterface $etudiantRepository,
    ) {}

    public function executer(CreateEtudiantData $donnees): Etudiant
    {
        return $this->etudiantRepository->creer([
            'nom_complet' => $donnees->nomComplet,
            'sexe' => $donnees->sexe,
            'niveau' => $donnees->niveau,
        ]);
    }
}
