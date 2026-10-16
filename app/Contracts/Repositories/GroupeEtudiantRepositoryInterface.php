<?php

namespace App\Contracts\Repositories;

use App\Models\GroupeEtudiant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GroupeEtudiantRepositoryInterface
{
    public function creer(array $donnees): GroupeEtudiant;

    public function obtenirTous(): Collection;

    public function obtenirTousAvecEtudiants(): Collection;

    public function supprimerTous(): void;

    public function obtenirTousPagine(int $parPage = 5): LengthAwarePaginator;
}
