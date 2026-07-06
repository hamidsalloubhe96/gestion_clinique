@extends('layout')
@section('content')
<h2>Départements <span class="badge bg-secondary">{{ $departements->count() }}</span></h2>
<a href="{{ route('departements.create') }}" class="btn btn-primary mb-3">Ajouter</a>
<table class="table table-bordered table-striped">
    <thead><tr><th>N°</th><th>Nom</th><th>Actions</th></tr></thead>
<tbody>
    @foreach($departements as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nom }}</td>
            <td>
                <a href="{{ route('departements.edit', $d) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('departements.destroy', $d) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
@endsection