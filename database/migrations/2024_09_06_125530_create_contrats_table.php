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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string('numero_contrat')->unique(); // Numéro unique pour chaque contrat
            $table->date('date_debut'); // Date de début du contrat
            $table->date('date_fin'); // Date de fin du contrat
            $table->string('type'); // Type de contrat (par exemple : vente, location)
            $table->decimal('montant', 10, 2); // Montant du contrat
            $table->unsignedBigInteger('appartement_id')->nullable()->unique(); // Colonne pour la clé étrangère de l'appartement
            $table->unsignedBigInteger('maison_id')->nullable()->unique(); // Colonne pour la clé étrangère de la maison
            $table->unsignedBigInteger('terrain_id')->nullable()->unique(); // Colonne pour la clé étrangère du terrain
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Définir les clés étrangères
            $table->foreign('appartement_id')->references('id')->on('appartements')->onDelete('set null');
            $table->foreign('maison_id')->references('id')->on('maisons')->onDelete('set null');
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
