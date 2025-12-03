<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $primaryKey = 'id_dossier';
    protected $fillable = [
        'consultation','examen','prescription','traitement','id_patient','id_medecin'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'id_medecin');
    }

    public function consultationLink()
    {
        return $this->hasOne(Consultation::class, 'id_dossier');
    }
}
