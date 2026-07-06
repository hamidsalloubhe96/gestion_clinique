<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Departement;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = Medecin::with('departement')->get();
        return view('medecins.index', compact('medecins'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('medecins.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:50',
            'prenom' => 'required|max:50',
            'specialite' => 'required|max:50',
            'departement_id' => 'required|exists:departements,id',
        ]);
        Medecin::create($request->all());
        return redirect()->route('medecins.index')->with('success', 'Médecin ajouté !');
    }

    public function edit(Medecin $medecin)
    {
        $departements = Departement::all();
        return view('medecins.edit', compact('medecin', 'departements'));
    }

    public function update(Request $request, Medecin $medecin)
    {
        $request->validate([
            'nom' => 'required|max:50',
            'prenom' => 'required|max:50',
            'specialite' => 'required|max:50',
            'departement_id' => 'required|exists:departements,id',
        ]);
        $medecin->update($request->all());
        return redirect()->route('medecins.index')->with('success', 'Médecin modifié !');
    }

    public function destroy(Medecin $medecin)
    {
        $medecin->delete();
        return redirect()->route('medecins.index')->with('success', 'Médecin supprimé !');
    }
}