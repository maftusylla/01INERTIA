<?php
namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\EtudiantRepositoryInterface;
use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentEtudiantRepository implements EtudiantRepositoryInterface
{
    public function creer(array $donnees): Etudiant
    {
        return Etudiant::create($donnees);
    }

    public function trouverParId(int $id): ?Etudiant
    {
        return Etudiant::find($id);
    }

    public function obtenirSansGroupe(): Collection
    {
        return Etudiant::whereNull('groupe_etudiant_id')->get();
    }
    public function affecterAuGroupe( array $etudiantIds, int $groupeId): void {
         Etudiant::whereIn('id', $etudiantIds)
        ->whereNull('groupe_etudiant_id')
        ->update(['groupe_etudiant_id' => $groupeId]);
}
   public function obtenirTousPagine(int $parPage = 10): LengthAwarePaginator
{
    return Etudiant::query()
        ->orderBy('id')
        ->paginate($parPage);
}

    public function detacherTousDesGroupes(): void
    {
        Etudiant::query()->update([
            'groupe_etudiant_id' => null,
        ]);
    }

}
