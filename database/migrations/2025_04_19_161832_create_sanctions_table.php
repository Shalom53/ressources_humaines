<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            
            $table->string('motif')->nullable();  
            $table->date('date_debut')->nullable(); 
            $table->date('date_fin')->nullable(); 
            $table->string('type'); 
            $table->decimal('montant', 15, 2)->default(0);
            $table->integer('etat')->default(1);
            $table->timestamps();

            // Clé étrangère vers la table 'personnels'
            $table->bigInteger('personnel_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanctions');
    }
}
