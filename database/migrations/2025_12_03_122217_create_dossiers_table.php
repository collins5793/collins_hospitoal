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
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id('id_dossier');
            $table->text('consultation')->nullable();
            $table->text('examen')->nullable();
            $table->text('prescription')->nullable();
            $table->text('traitement')->nullable();
            $table->unsignedBigInteger('id_patient');
            $table->unsignedBigInteger('id_medecin');
            $table->timestamps();

            $table->foreign('id_patient')->references('id_patient')->on('patients')->cascadeOnDelete();
            $table->foreign('id_medecin')->references('id_medecin')->on('medecins')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};
