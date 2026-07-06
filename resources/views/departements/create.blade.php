@extends('layout')
@section('content')
<h2>Ajouter un département</h2>
<form method="POST" action="{{ route('departements.store') }}">
    @csrf
    <div class="mb-2">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <button class="btn btn-success mt-2">Enregistrer</button>
</form>
@endsection