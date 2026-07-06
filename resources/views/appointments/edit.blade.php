@extends('layout')
@section('content')

@php($notifications = collect())

<h2>Modifier le rendez-vous</h2>
<form method="POST" action="{{ route('appointments.update', $appointment) }}" style="max-width:500px;">
    @csrf @method('PUT')
    <p><strong>Patient :</strong> {{ $appointment->patient->nom ?? '—' }}</p>
    <p><strong>Département :</strong> {{ $appointment->departement->nom ?? '—' }}</p>

    <div class="mb-3">
        <label>Médecin</label>
        <select name="medecin_id" class="form-select">
            <option value="">-- Non assigné --</option>
            @foreach($medecins as $m)
                <option value="{{ $m->id }}" @selected($appointment->medecin_id == $m->id)>{{ $m->nom }} {{ $m->prenom }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Statut</label>
        <select name="statut" class="form-select">
            <option value="en_attente" @selected($appointment->statut=='en_attente')>En attente</option>
            <option value="confirme" @selected($appointment->statut=='confirme')>Confirmé</option>
            <option value="refuse" @selected($appointment->statut=='refuse')>Refusé</option>
        </select>
    </div>

    <button class="btn btn-success">Enregistrer</button>
</form>
@endsection