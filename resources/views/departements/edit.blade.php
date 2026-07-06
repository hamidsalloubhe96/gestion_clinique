@extends('layout')
@section('content')
<h2>Modifier le département</h2>
<form method="POST" action="{{ route('departements.update', $departement) }}">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ $departement->nom }}" required>
    </div>
    <button class="btn btn-success mt-2">Enregistrer</button>
</form>
@endsection