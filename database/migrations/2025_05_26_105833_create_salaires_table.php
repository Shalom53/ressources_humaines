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
       Schema::create('salaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poste_id')->constrained('postes');
            $table->decimal('montant_base', 10, 2);
            $table->timestamps();
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
        Schema::dropIfExists('salaires');
    }
};
