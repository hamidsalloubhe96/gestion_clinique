@extends('layout')
@section('content')
<h2>Ajouter un médecin</h2>
<form method="POST" action="{{ route('medecins.store') }}">
    @csrf
    <div class="mb-2">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Spécialité</label>
        <input type="text" name="specialite" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Département</label>
        <select name="departement_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($departements as $d)
                <option value="{{ $d->id }}">{{ $d->nom }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success mt-2">Enregistrer</button>
</form>
@endsection