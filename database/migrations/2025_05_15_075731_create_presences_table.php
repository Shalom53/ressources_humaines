<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
            Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->time('heure_arrivee')->nullable();
            $table->time('heure_depart')->nullable();
            $table->enum('retard', ['oui', 'non'])->default('non');
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('presences');
    }
};
