<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = 'id_patient';
    protected $fillable = ['id_user','id_salle'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'id_patient');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'id_patient');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'id_salle');
    }
}
