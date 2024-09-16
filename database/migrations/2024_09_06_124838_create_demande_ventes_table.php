<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demande_ventes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('appartement_id')->nullable(); // Colonne pour la clé étrangère de l'appartement
            $table->unsignedBigInteger('maison_id')->nullable(); // Colonne pour la clé étrangère de la maison
            $table->unsignedBigInteger('terrain_id')->nullable(); // Colonne pour la clé étrangère du terrain
            $table->string('etat_validation')->default('en attente');
            $table->integer('prix');
            $table->boolean('paiement')->default(false);
            $table->timestamps();

            // Définir les clés étrangères
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appartement_id')->references('id')->on('appartements')->onDelete('set null');
            $table->foreign('maison_id')->references('id')->on('maisons')->onDelete('set null');
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_ventes');
    }
};
