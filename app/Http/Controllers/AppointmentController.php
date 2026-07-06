<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Departement;
use App\Models\Medecin;
use App\Models\User;
use App\Notifications\NewAppointmentNotification;

class AppointmentController extends Controller
{
    // Formulaire public de demande de RDV (client)
    public function create()
    {
        $departements = Departement::all();
        return view('appointments.create', compact('departements'));
    }

    // Le client envoie sa demande
    public function store(Request $request)
    {
        $data = $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'date_souhaitee' => 'required|date|after_or_equal:today',
            'motif' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        // Crée ou met à jour la fiche patient liée à ce compte client
        $patient = Patient::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['nom' => $request->user()->name, 'telephone' => $data['telephone']]
        );

        $appointment = Appointment::create([
            'user_id' => $request->user()->id,
            'patient_id' => $patient->id,
            'departement_id' => $data['departement_id'],
            'date_souhaitee' => $data['date_souhaitee'],
            'motif' => $data['motif'],
            'statut' => 'en_attente',
        ]);

        $staffs = User::where('role', 'staff')->get();
        foreach ($staffs as $staff) {
            $staff->notify(new NewAppointmentNotification($appointment));
        }

        return redirect()->route('appointments.create')
            ->with('success', 'Votre demande de rendez-vous a été envoyée !');
    }

    // Liste des RDV (staff)
    public function index(Request $request)
    {
        if ($request->user()->role !== 'staff') {
            abort(403, 'Accès réservé au personnel.');
        }

        $appointments = Appointment::with('patient', 'departement', 'medecin')->latest()->get();
        $notifications = $request->user()->unreadNotifications;

        return view('appointments.index', compact('appointments', 'notifications'));
    }

    // Formulaire de création manuelle par le staff (patient déjà existant)
    public function createByStaff(Request $request)
    {
        if ($request->user()->role !== 'staff') {
            abort(403);
        }
        $patients = Patient::all();
        $departements = Departement::all();
        $medecins = Medecin::all();
        return view('appointments.create_staff', compact('patients', 'departements', 'medecins'));
    }

    public function storeByStaff(Request $request)
    {
        if ($request->user()->role !== 'staff') {
            abort(403);
        }
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'departement_id' => 'required|exists:departements,id',
            'medecin_id' => 'nullable|exists:medecins,id',
            'date_souhaitee' => 'required|date',
            'motif' => 'required|string|max:255',
            'statut' => 'required|in:en_attente,confirme,refuse',
        ]);

        Appointment::create($data);

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous créé !');
    }

    // Modifier un RDV (staff) : assigner médecin, changer statut
    public function edit(Request $request, Appointment $appointment)
    {
        if ($request->user()->role !== 'staff') {
            abort(403);
        }
        $medecins = Medecin::where('departement_id', $appointment->departement_id)->get();
        return view('appointments.edit', compact('appointment', 'medecins'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($request->user()->role !== 'staff') {
            abort(403, 'Accès réservé au personnel.');
        }

        $data = $request->validate([
            'medecin_id' => 'nullable|exists:medecins,id',
            'statut' => 'required|in:en_attente,confirme,refuse',
        ]);

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous mis à jour.');
    }

    // Supprimer un RDV (staff)
    public function destroy(Request $request, Appointment $appointment)
    {
        if ($request->user()->role !== 'staff') {
            abort(403);
        }
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Rendez-vous supprimé.');
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('appointments.index');
    }
}