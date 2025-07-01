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
        public function up(): void
        {
            Schema::create('bulletins_paie', function (Blueprint $table) {
                $table->id();

                // Référence unique du bulletin (ex: MAR-BULL-000001)
                $table->string('reference')->unique();

                 // Période (ex: 2025-05 pour mai 2025)
                 $table->string('periode');

                // Informations de l'employé
                $table->unsignedBigInteger('personnel_id');
                $table->string('nom');
                $table->string('prenom');
                $table->string('adresse');
                $table->string('poste');

                // Salaire de base et horaire
                $table->decimal('salaire_base', 15, 2)->default(0);
                $table->decimal('salaire_horaire', 15, 2)->default(0);

                // Indemnités et primes
                $table->decimal('heures_supp', 15, 2)->default(0);
                $table->decimal('logement', 15, 2)->default(0);
                $table->decimal('commission', 15, 2)->default(0);
                $table->decimal('transport', 15, 2)->default(0);
                $table->decimal('conges', 15, 2)->default(0);
                $table->decimal('prime_repos', 15, 2)->default(0);
                $table->decimal('divers', 15, 2)->default(0);

                // Total salaire brut
                $table->decimal('salaire_brut', 15, 2)->default(0);

                // Retenues
                $table->decimal('cnss', 15, 2)->default(0);
                $table->decimal('ins', 15, 2)->default(0);
                $table->decimal('irpp', 15, 2)->default(0);
                $table->decimal('tcs', 15, 2)->default(0);
                $table->decimal('credit', 15, 2)->default(0);
                $table->decimal('absences', 15, 2)->default(0);
                $table->decimal('avance_salaire', 15, 2)->default(0);
                $table->decimal('acompte', 15, 2)->default(0);
                $table->decimal('autre_retenue', 15, 2)->default(0);

                // Total retenues
                $table->decimal('total_retenue', 15, 2)->default(0);

                // Salaire net à payer
                $table->decimal('salaire_net', 15, 2)->default(0);

                // Date de paiement
                $table->date('date_paiement');

                $table->timestamps();

                // Clé étrangère vers personnel
                $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');

                $table->integer('etat')->default(1);
            });
        }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulletins_paie');
    }
};
