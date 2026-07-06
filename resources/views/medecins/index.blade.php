@extends('layout')
@section('content')
<h2>Médecins <span class="badge bg-secondary">{{ $medecins->count() }}</span></h2>
<a href="{{ route('medecins.create') }}" class="btn btn-primary mb-3">Ajouter</a>
<table class="table table-bordered table-striped">
    <thead><tr><th>N°</th><th>Nom</th><th>Prénom</th><th>Spécialité</th><th>Département</th><th>Actions</th></tr></thead>
<tbody>
    @foreach($medecins as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $m->nom }}</td>
            <td>{{ $m->prenom }}</td>
            <td>{{ $m->specialite }}</td>
            <td>{{ $m->departement->nom }}</td>
            <td>
                <a href="{{ route('medecins.edit', $m) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('medecins.destroy', $m) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
@endsection