<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demandes_emploi', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email'); 
            $table->string('telephone');
            $table->integer('experience')->default(0);
            $table->string('domaine');
            $table->string('cv'); 
            $table->string('lettre_motivation'); 
            $table->timestamps();
            $table->integer('etat')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_emploi');
    }
};
