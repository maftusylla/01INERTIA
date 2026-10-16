<?php

namespace App\Services\Groupe;

use App\Contracts\Repositories\EtudiantRepositoryInterface;
use App\Contracts\Repositories\GroupeEtudiantRepositoryInterface;
use App\DTOs\Groupe\GenerateGroupData;
use App\Models\Etudiant;
use App\Models\GroupeEtudiant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GenererGroupesService
{
    public function __construct(
        private readonly EtudiantRepositoryInterface $etudiantRepository,
        private readonly GroupeEtudiantRepositoryInterface $groupeRepository,
    ) {}

    public function executer(GenerateGroupData $donnees): array
    {

        return DB::transaction(function () use ($donnees) {
            $taille = $donnees->tailleGroupe;

            $effectifTotal = Etudiant::query()->count();

            if ($taille > $effectifTotal) {
                throw ValidationException::withMessages([
                    'taille_groupe' => "Vous avez {$effectifTotal} étudiants au total. "
                        . "Vous ne pouvez pas demander des groupes de {$taille} étudiants.",
                ]);
            }


            $parametres = DB::table('parametres_groupes')->first();
            $ancienneTaille = $parametres?->taille_cible;

            $groupes = $this->groupeRepository
                ->obtenirTousAvecEtudiants();

            $reinitialiser = $ancienneTaille === null
                || (int) $ancienneTaille !== $taille;

            if ($reinitialiser && $groupes->isNotEmpty()) {
                $this->etudiantRepository->detacherTousDesGroupes();
                $this->groupeRepository->supprimerTous();
                $groupes = collect();
            }

            DB::table('parametres_groupes')->updateOrInsert(
                ['id' => 1],
                [
                    'taille_cible' => $taille,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $restants = $this->etudiantRepository
                ->obtenirSansGroupe()
                ->shuffle()
                ->values()
                ->all();

            if (empty($restants)) {
                return [];
            }

            if ($groupes->isEmpty()) {
                return $this->genererGroupesInitiaux($restants, $taille);

            }

            foreach ($restants as $etudiant) {
                $effectifsMinimaux = $groupes->map(
                    fn ($groupe) => $groupe->etudiants->count()
                )->min();

                $candidats = $groupes->filter(
                    fn ($groupe) => $groupe->etudiants->count()
                        === $effectifsMinimaux
                );

                $meilleurScore = PHP_INT_MAX;
                $meilleursGroupes = [];

                foreach ($candidats as $groupe) {
                    $score = $this->scoreMixite(
                        $etudiant,
                        $groupe->etudiants
                    );

                    if ($score < $meilleurScore) {
                        $meilleurScore = $score;
                        $meilleursGroupes = [$groupe];
                    } elseif ($score === $meilleurScore) {
                        $meilleursGroupes[] = $groupe;
                    }
                }

                $groupeChoisi = $meilleursGroupes[
                    array_rand($meilleursGroupes)
                ];

                $this->etudiantRepository->affecterAuGroupe(
                    [$etudiant->id],
                    $groupeChoisi->id
                );

                $groupeChoisi->etudiants->push($etudiant);

                $groupeChoisi->nom = $this->genererNomGroupe(
                    $groupeChoisi->etudiants->all()
                );

                $groupeChoisi->save();
            }

            return $groupes->all();
        });
    }

    private function genererGroupesInitiaux(
        array $restants,
        int $taille
    ): array {
        $groupesCrees = [];
        $restants = collect($restants)->keyBy('id')->all();
        $profils = [];

        foreach ($restants as $etudiant) {
            $profil = $etudiant->sexe . '|' . $etudiant->niveau;
            $profils[$profil][] = $etudiant;
        }

        while (! empty($restants)) {
            $membres = [];
            $profilsUtilises = [];

            while (count($membres) < $taille && ! empty($restants)) {
                $profilsDisponibles = [];

                foreach ($profils as $profil => $etudiants) {
                    $disponibles = array_filter(
                        $etudiants,
                        fn ($etudiant) => isset(
                            $restants[$etudiant->id]
                        )
                    );

                    if (! empty($disponibles)) {
                        $profilsDisponibles[$profil] = array_values(
                            $disponibles
                        );
                    }
                }

                if (empty($profilsDisponibles)) {
                    break;
                }


                $profilsCandidats = array_filter(
                    $profilsDisponibles,
                    fn ($etudiants, $profil) => ! in_array(
                        $profil,
                        $profilsUtilises,
                        true
                    ),
                    ARRAY_FILTER_USE_BOTH
                );

                if (empty($profilsCandidats)) {
                    $profilsCandidats = $profilsDisponibles;
                }

                $maximum = max(array_map(
                    'count',
                    $profilsCandidats
                ));

                $profilsCandidats = array_filter(
                    $profilsCandidats,
                    fn ($etudiants) => count($etudiants) === $maximum
                );

                $profilChoisi = array_rand($profilsCandidats);
                $etudiantsProfil = $profilsCandidats[$profilChoisi];

                $etudiant = $etudiantsProfil[array_rand($etudiantsProfil)];

                $membres[] = $etudiant;
                $profilsUtilises[] = $profilChoisi;
                unset($restants[$etudiant->id]);
            }

            $groupe = $this->groupeRepository->creer([
                'nom' => $this->genererNomGroupe($membres),
            ]);

            $this->etudiantRepository->affecterAuGroupe(
                array_map(
                    fn ($etudiant) => $etudiant->id,
                    $membres
                ),
                $groupe->id
            );

            $groupesCrees[] = $groupe;
        }

        return $groupesCrees;
    }

    private function scoreMixite(
        Etudiant $etudiant,
        iterable $membres
    ): int {
        $score = 0;

        foreach ($membres as $membre) {
            if ($etudiant->niveau === $membre->niveau) {
                $score += 10;
            }

            if ($etudiant->sexe === $membre->sexe) {
                $score += 5;
            }
        }

        return $score;
    }

    private function genererNomGroupe(array $membres): string
    {
        $nom = '';

        foreach ($membres as $etudiant) {
            $lettres = preg_split(
                '//u',
                mb_strtolower(trim($etudiant->nom_complet)),
                -1,
                PREG_SPLIT_NO_EMPTY
            );

            $consonne = null;
            $voyelle = null;

            foreach ($lettres as $lettre) {
                if (preg_match('/^[aeiouyàâäéèêëïîôöùûüÿ]$/iu', $lettre)) {
                    $voyelle ??= $lettre;
                } elseif (preg_match('/^\p{L}$/u', $lettre)) {
                    $consonne ??= $lettre;
                }

                if ($consonne !== null && $voyelle !== null) {
                    break;
                }
            }

            if ($consonne !== null && $voyelle !== null) {
                $nom .= $consonne . $voyelle;
            } elseif (count($lettres) >= 2) {
                $nom .= $lettres[0] . $lettres[1];
            } elseif (count($lettres) === 1) {
                $nom .= $lettres[0];
            }
        }

        return $nom === ''
            ? 'Groupe'
            : mb_strtoupper(mb_substr($nom, 0, 1)) . mb_substr($nom, 1);
    }
}
