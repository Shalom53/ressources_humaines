<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remuneration_id')->constrained('remunerations')->cascadeOnDelete();

            $table->string('libelle')->nullable();
            $table->decimal('montant', 15, 2)->nullable();
            $table->string('etat')->default(1);

            $table->string('periode')->nullable(); 
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retenues');
    }
};
