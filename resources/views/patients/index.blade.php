@extends('layout')
@section('content')
<h2>Patients <span class="badge bg-secondary">{{ $patients->count() }}</span></h2>
<a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Ajouter</a>
<table class="table table-bordered table-striped">
    <thead><tr><th>N°</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Naissance</th><th>Actions</th></tr></thead>
<tbody>
    @foreach($patients as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->nom }}</td>
            <td>{{ $p->prenom }}</td>
            <td>{{ $p->telephone }}</td>
            <td>{{ $p->date_naissance }}</td>
            <td>
                <a href="{{ route('patients.edit', $p) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('patients.destroy', $p) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
@endsection