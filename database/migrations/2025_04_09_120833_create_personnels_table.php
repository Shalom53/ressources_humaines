<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    public function up(): void
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poste_id')->constrained('postes');
            $table->integer('etat')->default(1);
            // Ajout des nouveaux statuts
            $table->enum('statut', [
                'actif', 
                'inactif', 
                'suspendu', 
                'licencié', 
                'retraite', 
                'démission', 
                'congé'
            ])->default('actif');

            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('contact');
            $table->string('email')->unique();
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('prefecture_naissance')->nullable();
            $table->enum('sexe', ['Masculin', 'Féminin']);
            $table->string('photo')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('quartier_residentiel')->nullable();
            $table->enum('situation_familiale', ['Marié(e)', 'Célibataire', 'Divorcé(e)', 'Veuf(ve)']);
            $table->integer('nombre_enfants')->default(0);
            $table->enum('situation_agent', ['Permanent', 'Vacataire', 'Stagiaire']);
            $table->string('diplome_academique_plus_eleve');
            $table->string('intitule_diplome');
            $table->string('universite_obtention')->nullable();
            $table->year('annee_obtention_diplome')->nullable();
            $table->string('diplome_professionnel')->nullable();
            $table->string('lieu_obtention_diplome_professionnel')->nullable();
            $table->year('annee_obtention_diplome_professionnel')->nullable();
            $table->integer('anciennete')->nullable();
            $table->string('nom_epoux_ou_epouse')->nullable();
            $table->string('contact_epoux_ou_epouse')->nullable();
            $table->date('date_prise_service')->nullable();
            $table->string('mot_de_passe')->nullable();

            $table->timestamps();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
}
