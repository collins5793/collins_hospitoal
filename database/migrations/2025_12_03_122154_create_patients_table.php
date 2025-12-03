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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('id_patient');
            $table->unsignedBigInteger('id_user')->unique();
            $table->unsignedBigInteger('id_salle')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_salle')->references('id_salle')->on('salles')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
