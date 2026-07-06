<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'patient_id', 'departement_id', 'medecin_id',
        'date_souhaitee', 'motif', 'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}