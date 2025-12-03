<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $primaryKey = 'id_medecin';
    protected $fillable = ['id_user','specialite'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'id_medecin');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'id_medecin');
    }
}
