<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $primaryKey = 'id_consultation';
    protected $fillable = ['id_patient','id_medecin','id_dossier','date'];
    protected $casts = [
    'date' => 'datetime',
];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'id_medecin');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'id_dossier');
    }
}
