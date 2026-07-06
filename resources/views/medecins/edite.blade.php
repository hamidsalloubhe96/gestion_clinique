@extends('layout')
@section('content')
<h2>Modifier le médecin</h2>
<form method="POST" action="{{ route('medecins.update', $medecin) }}">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ $medecin->nom }}" required>
    </div>
    <div class="mb-2">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" value="{{ $medecin->prenom }}" required>
    </div>
    <div class="mb-2">
        <label>Spécialité</label>
        <input type="text" name="specialite" class="form-control" value="{{ $medecin->specialite }}" required>
    </div>
    <div class="mb-2">
        <label>Département</label>
        <select name="departement_id" class="form-select" required>
            @foreach($departements as $d)
                <option value="{{ $d->id }}" @selected($medecin->departement_id == $d->id)>{{ $d->nom }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success mt-2">Enregistrer</button>
</form>
@endsection