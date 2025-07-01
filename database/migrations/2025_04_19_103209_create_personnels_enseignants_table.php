<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsEnseignantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('personnels_enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            
            $table->string('dominante')->nullable();
            $table->string('sous_dominante')->nullable();
            $table->integer('volume_horaire')->nullable();
            $table->string('classe_intervention')->nullable();
            $table->decimal('salaire_total', 15, 2)->default(0);
            $table->integer('etat')->default(1);
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('personnels_enseignants');
    }
}
