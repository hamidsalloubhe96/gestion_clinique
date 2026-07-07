@extends('layout')
@section('content')

<div class="card shadow-sm" style="max-width: 500px; margin: 0 auto;">
    <div class="card-header text-white" style="background-color:#2a9d8f;">
        <h4 class="mb-0">Créer un compte staff</h4>
    </div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('staff.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom complet</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button class="btn w-100 text-white" style="background-color:#2a9d8f;">Créer le compte</button>
        </form>
    </div>
</div>
@endsection