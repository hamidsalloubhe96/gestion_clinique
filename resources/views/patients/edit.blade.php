@extends('layout')
@section('content')
<h2>Modifier le patient</h2>
<form method="POST" action="{{ route('patients.update', $patient) }}">
    @csrf @method('PUT')
    <div class="mb-2"><label>Nom</label><input type="text" name="nom" class="form-control" value="{{ $patient->nom }}" required></div>
    <div class="mb-2"><label>Prénom</label><input type="text" name="prenom" class="form-control" value="{{ $patient->prenom }}"></div>
    <div class="mb-2"><label>Téléphone</label><input type="text" name="telephone" class="form-control" value="{{ $patient->telephone }}"></div>
    <div class="mb-2"><label>Date de naissance</label><input type="date" name="date_naissance" class="form-control" value="{{ $patient->date_naissance }}"></div>
    <button class="btn btn-success mt-2">Enregistrer</button>
</form>
@endsection