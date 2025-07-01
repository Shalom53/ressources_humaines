<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostesTable extends Migration
{
    public function up(): void
    {
        Schema::create('postes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
           
            $table->decimal('salaire_base', 10, 2)->default(0);
            $table->decimal('salaire_horaire', 10, 2)->default(0);
            $table->timestamps();
             $table->integer('etat')->default(1);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('postes');
    }
}
