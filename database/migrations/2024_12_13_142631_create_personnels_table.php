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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_cnss')->nullable();
            $table->tinyInteger('is_amu')->nullable();
            $table->tinyInteger('nbre_enfant')->nullable();
            $table->tinyInteger('is_pension_validite')->nullable();
            $table->tinyInteger('taux_pension_validite')->nullable();
            $table->float('nature_pension_validite')->nullable();
            $table->float('salaire')->nullable();

            $table->bigInteger('profession_id')->nullable();
            $table->bigInteger('employe_id')->nullable();

            $table->bigInteger('annee_id')->nullable();

            $table->integer('etat')->default(1);
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
        Schema::dropIfExists('personnels');
    }
};
