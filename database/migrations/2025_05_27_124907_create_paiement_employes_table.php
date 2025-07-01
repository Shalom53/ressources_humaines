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
       Schema::create('paiement_employes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnels')->onDelete('cascade');
            $table->decimal('salaire_net', 15, 2);
            $table->decimal('salaire_brute', 15, 2);
            $table->decimal('retenue', 15, 2);
            $table->decimal('prime', 15, 2);
            $table->date('date_paiement');
            $table->string('mode_paiement')->nullable();
            $table->string('mois_paie'); 

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
        Schema::dropIfExists('paiement_employes');
    }
};
