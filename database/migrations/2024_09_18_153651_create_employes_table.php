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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();

            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('numero_cnss')->nullable();
            $table->string('quartier')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->tinyinteger('diplome')->nullable();
            $table->date('date_embauche')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->tinyInteger('sexe')->nullable();
            $table->integer('nationalite_id')->nullable();
          
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
        Schema::dropIfExists('employes');
    }
};
