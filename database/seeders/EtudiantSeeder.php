<?php
namespace Database\Seeders;

use App\Models\Etudiant;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    public function run(): void
    {
        $etudiants = [
            ['nom_complet' => 'Awa Ndiaye', 'sexe' => 'Feminin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Moussa Diop', 'sexe' => 'Masculin', 'niveau' => 'niveau 3'],
            ['nom_complet' => 'Fatou Sow', 'sexe' => 'Feminin', 'niveau' => 'niveau 2'],
            ['nom_complet' => 'Ibrahima Fall', 'sexe' => 'Masculin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Mariama Ba', 'sexe' => 'Feminin', 'niveau' => 'niveau 3'],
            ['nom_complet' => 'Cheikh Diallo', 'sexe' => 'Masculin', 'niveau' => 'niveau 2'],
            ['nom_complet' => 'Aminata Gueye', 'sexe' => 'Feminin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Ousmane Faye', 'sexe' => 'Masculin', 'niveau' => 'niveau 3'],
            ['nom_complet' => 'Khady Sarr', 'sexe' => 'Feminin', 'niveau' => 'niveau 2'],
            ['nom_complet' => 'Mamadou Kane', 'sexe' => 'Masculin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Rokhaya Cisse', 'sexe' => 'Feminin', 'niveau' => 'niveau 3'],
            ['nom_complet' => 'Abdoulaye Ba', 'sexe' => 'Masculin', 'niveau' => 'niveau 2'],
            ['nom_complet' => 'Ndeye Astou Diouf', 'sexe' => 'Feminin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Modou Seck', 'sexe' => 'Masculin', 'niveau' => 'niveau 3'],
            ['nom_complet' => 'Sokhna Fall', 'sexe' => 'Feminin', 'niveau' => 'niveau 2'],
            ['nom_complet' => 'Pape Ndiaye', 'sexe' => 'Masculin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Adama Thiam', 'sexe' => 'Masculin', 'niveau' => 'niveau 2'],
            ['nom_complet' => 'Bineta Diop', 'sexe' => 'Feminin', 'niveau' => 'niveau 3'],
            ['nom_complet' => 'Lamine Sow', 'sexe' => 'Masculin', 'niveau' => 'niveau 1'],
            ['nom_complet' => 'Astou Gueye', 'sexe' => 'Feminin', 'niveau' => 'niveau 2'],
        ];

        foreach ($etudiants as $donnees) {
            Etudiant::firstOrCreate(
                ['nom_complet' => $donnees['nom_complet']],
                [
                    'sexe' => $donnees['sexe'],
                    'niveau' => $donnees['niveau'],
                    'groupe_etudiant_id' => null,
                ],
            );
        }
    }
}
