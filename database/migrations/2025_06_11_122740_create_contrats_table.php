<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id');
            $table->string('type'); // CDD, CDI, Stage, Prestation
            $table->string('Dure')->nullable(); // Durée du contrat
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->decimal('salaire', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('fichier'); // Nom ou chemin du fichier PDF
            $table->string('statut')->default('actif'); // actif, inactif, etc.
            $table->boolean('etat')->default(1); // 1 = actif, 0 = inactif
            $table->timestamps();

            // Clé étrangère
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
