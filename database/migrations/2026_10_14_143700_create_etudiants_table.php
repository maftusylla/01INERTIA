<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('etudiants', function (Blueprint $table) {
        $table->id();
        $table->string('nom_complet');
        $table->enum('sexe', ['Masculin', 'Feminin']);
        $table->enum('niveau', ['niveau 1', 'niveau 2', 'niveau 3']);

        $table->foreignId('groupe_etudiant_id')
            ->nullable()
            ->constrained('groupe_etudiants')
            ->nullOnDelete();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
