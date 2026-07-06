<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'nullable|max:100',
            'telephone' => 'nullable|max:20',
            'date_naissance' => 'nullable|date',
        ]);
        Patient::create($request->all());
        return redirect()->route('patients.index')->with('success', 'Patient ajouté !');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'nullable|max:100',
            'telephone' => 'nullable|max:20',
            'date_naissance' => 'nullable|date',
        ]);
        $patient->update($request->all());
        return redirect()->route('patients.index')->with('success', 'Patient modifié !');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé !');
    }
}