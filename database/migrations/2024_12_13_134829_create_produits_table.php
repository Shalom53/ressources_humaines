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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();

            $table->string('libelle')->nullable();
            $table->tinyInteger('unite_stock')->nullable();
            $table->tinyInteger('unite_vente')->nullable();
            $table->tinyInteger('unite_achat')->nullable();
            $table->tinyInteger('prix_achat')->nullable();
            $table->tinyInteger('prix_stock')->nullable();
            $table->tinyInteger('prix_vente')->nullable();
            $table->tinyInteger('equivalence_stock_achat')->nullable();
            $table->tinyInteger('equivalence_stock_vente')->nullable();

          
         
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
        Schema::dropIfExists('produits');
    }
};
