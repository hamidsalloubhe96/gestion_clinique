@extends('layout')
@section('content')
<h2>Ajouter un patient</h2>
<form method="POST" action="{{ route('patients.store') }}">
    @csrf
    <div class="mb-2"><label>Nom</label><input type="text" name="nom" class="form-control" required></div>
    <div class="mb-2"><label>Prénom</label><input type="text" name="prenom" class="form-control"></div>
    <div class="mb-2"><label>Téléphone</label><input type="text" name="telephone" class="form-control"></div>
    <div class="mb-2"><label>Date de naissance</label><input type="date" name="date_naissance" class="form-control"></div>
    <button class="btn btn-success mt-2">Enregistrer</button>
</form>
@endsection