<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\GroupeEtudiantRepositoryInterface;
use App\DTOs\Groupe\GenerateGroupData;
use App\Http\Requests\GenerateGroupRequest;
use App\Services\Groupe\GenererGroupesService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GroupeEtudiantController extends Controller
{
    public function __construct(
        private readonly GroupeEtudiantRepositoryInterface $groupeRepository,
        private readonly GenererGroupesService $genererGroupesService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('ListeEtudiant', [
            'etudiants' => app(
                GroupeEtudiantRepositoryInterface::class
            )->obtenirTous()->flatMap(
                fn ($groupe) => $groupe->etudiants
            ),
            'groupes' => $this->groupeRepository
                ->obtenirTous()
                ->load('etudiants'),
        ]);
    }

    public function generer(
        GenerateGroupRequest $request
    ): RedirectResponse {
        $donnees = new GenerateGroupData(
            tailleGroupe: (int) $request->validated('taille_groupe'),
        );

        $this->genererGroupesService->executer($donnees);

        return to_route('home')
            ->with('success', 'Les groupes ont été générés avec succès.');
    }
}

