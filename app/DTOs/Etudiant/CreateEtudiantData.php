<?php
namespace App\DTOs\Etudiant;

final readonly class CreateEtudiantData
{
    public function __construct(
        public string $nomComplet,
        public string $sexe,
        public string $niveau,
    ) {}
}

