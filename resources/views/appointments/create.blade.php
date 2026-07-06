@extends('layout')
@section('content')

@php($notifications = collect())

<h2>Prendre un rendez-vous</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('appointments.store') }}" style="max-width: 500px;">
    @csrf
    <div class="mb-3">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Département souhaité</label>
        <select name="departement_id" class="form-select" required>
            <option value="">-- Choisir un département --</option>
            @foreach($departements as $d)
                <option value="{{ $d->id }}">{{ $d->nom }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Date souhaitée</label>
        <input type="date" name="date_souhaitee" class="form-control" required min="{{ date('Y-m-d') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Motif de la consultation</label>
        <textarea name="motif" class="form-control" rows="3" required></textarea>
    </div>
    <button class="btn btn-success">Envoyer la demande</button>
</form>
@endsection