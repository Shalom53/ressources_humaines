<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnesAPrevenirTable extends Migration
{
    public function up(): void
    {
        Schema::create('personnes_a_prevenir', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
        
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('profession')->nullable();
            $table->string('lien_parente')->nullable();
            $table->string('adresse')->nullable();
            $table->string('contact')->nullable();
        
            $table->integer('etat')->default(1);
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('personnes_a_prevenir');
    }
}

