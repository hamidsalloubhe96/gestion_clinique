@extends('layout')
@section('content')

<div class="d-flex justify-content-between align-items-center">
    <h2>Demandes de rendez-vous <span class="badge bg-secondary">{{ $appointments->count() }}</span></h2>
    <a href="{{ route('appointments.create_staff') }}" class="btn btn-primary mb-3">+ Nouveau RDV</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($notifications->count() > 0)
    <div class="alert alert-info">
        <strong>Nouvelles notifications :</strong>
        <ul class="mb-0">
            @foreach($notifications as $notif)
                <li>
                    {{ $notif->data['message'] }}
                    <form action="{{ route('notifications.read', $notif->id) }}" method="POST" style="display:inline">
                        @csrf @method('PUT')
                        <button class="btn btn-link btn-sm">Marquer comme lu</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endif

<table class="table table-bordered table-striped">
    
      <thead>
    <tr>
        <th>N°</th><th>Patient</th><th>Département</th><th>Médecin</th><th>Date</th><th>Motif</th><th>Statut</th><th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($appointments as $rdv)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $rdv->patient ? $rdv->patient->nom . ' ' . $rdv->patient->prenom : '—' }}</td>
            <td>{{ $rdv->departement->nom ?? '—' }}</td>
            <td>{{ $rdv->medecin->nom ?? 'Non assigné' }}</td>
            <td>{{ $rdv->date_souhaitee }}</td>
            <td>{{ $rdv->motif }}</td>
            <td>{{ $rdv->statut }}</td>
            <td>
                <a href="{{ route('appointments.edit', $rdv) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('appointments.destroy', $rdv) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
@endsection