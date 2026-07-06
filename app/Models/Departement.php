<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable = ['nom'];

    public function medecins()
    {
        return $this->hasMany(Medecin::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}