<?php
namespace App\Http\Controllers;

use App\Contracts\Repositories\EtudiantRepositoryInterface;
use App\Contracts\Repositories\GroupeEtudiantRepositoryInterface;
use App\DTOs\Etudiant\CreateEtudiantData;
use App\Http\Requests\StoreEudiantRequest;
use App\Services\Etudiant\CreerEtudiantService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class EtudiantController extends Controller
{
    public function __construct(
        private readonly EtudiantRepositoryInterface $etudiantRepository,
        private readonly GroupeEtudiantRepositoryInterface $groupeRepository,
        private readonly CreerEtudiantService $creerEtudiantService,
    ) {}


    public function index(): Response
    {
        return Inertia::render('ListeEtudiant', [
            'etudiants' => $this->etudiantRepository->obtenirTousPagine(),

            'groupes' => $this->groupeRepository
                ->obtenirTousPagine(),
        ]);
    }


    public function store(
        StoreEudiantRequest $request
    ): RedirectResponse {
        $donnees = new CreateEtudiantData(
            nomComplet: $request->validated('nom_complet'),
            sexe: $request->validated('sexe'),
            niveau: $request->validated('niveau'),
        );

        $this->creerEtudiantService->executer($donnees);

        return to_route('home')
            ->with('success', 'Étudiant ajouté avec succès.');
    }
}

