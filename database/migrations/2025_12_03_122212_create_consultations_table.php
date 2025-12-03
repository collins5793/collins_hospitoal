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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id('id_consultation');
            $table->unsignedBigInteger('id_patient');
            $table->unsignedBigInteger('id_medecin');
            $table->unsignedBigInteger('id_dossier');
            $table->dateTime('date')->useCurrent();
            $table->timestamps();

            $table->foreign('id_patient')->references('id_patient')->on('patients')->cascadeOnDelete();
            $table->foreign('id_medecin')->references('id_medecin')->on('medecins')->cascadeOnDelete();
            $table->foreign('id_dossier')->references('id_dossier')->on('dossiers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
