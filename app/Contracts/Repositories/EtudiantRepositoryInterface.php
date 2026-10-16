<?php

namespace App\Contracts\Repositories;

use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EtudiantRepositoryInterface
{
    public function creer(array $donnees): Etudiant;

    public function trouverParId(int $id): ?Etudiant;

    public function obtenirSansGroupe(): Collection;

    public function affecterAuGroupe(array $etudiantIds, int $groupeId): void;

    public function detacherTousDesGroupes(): void;

    public function obtenirTousPagine(int $parPage = 10): LengthAwarePaginator;
}
