<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $primaryKey = 'id_salle';
    protected $fillable = ['type'];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'id_salle');
    }
}
