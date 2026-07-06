<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $fillable = ['nom', 'prenom', 'specialite', 'departement_id'];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}