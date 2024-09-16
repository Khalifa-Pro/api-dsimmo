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
        Schema::create('maisons', function (Blueprint $table) {
            $table->id();
            $table->integer('prix');
            $table->string('image')->nullable();
            $table->string('videos')->nullable();
            $table->string('adresse');
            $table->boolean('disponibilite')->default(true);
            $table->string('status');
            $table->integer('superficie')->unsigned();
            $table->integer('nombre_de_pieces');
            $table->string('numero_villa');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maisons');
    }
};
