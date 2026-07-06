<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        $departements = [
            'Ophtalmologie',
            'Endocrinologie',
            'Cardiologie',
            'Dermatologie',
            'Pédiatrie',
            'Gynécologie',
            'Médecine générale',
            'Dentisterie',
            'Neurologie',
            'Orthopédie',
        ];

        foreach ($departements as $nom) {
            Departement::firstOrCreate(['nom' => $nom]);
        }
    }
}