<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\GroupeEtudiantRepositoryInterface;
use App\Models\GroupeEtudiant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentGroupeEtudiantRepository implements GroupeEtudiantRepositoryInterface
{
    public function creer(array $donnees): GroupeEtudiant
    {
        return GroupeEtudiant::create($donnees);
    }

    public function obtenirTous(): Collection
    {
        return GroupeEtudiant::all();
    }
    public function obtenirTousPagine(int $parPage = 5): LengthAwarePaginator
    {
    return GroupeEtudiant::query()
        ->with('etudiants')
        ->orderBy('id')
        ->paginate($parPage, ['*'], 'page_groupes')
        ->withQueryString();
}

public function obtenirTousAvecEtudiants(): Collection
{
    return GroupeEtudiant::query()
        ->with('etudiants')
        ->orderBy('id')
        ->get();
}

public function supprimerTous(): void
{
    GroupeEtudiant::query()->delete();
}

}
