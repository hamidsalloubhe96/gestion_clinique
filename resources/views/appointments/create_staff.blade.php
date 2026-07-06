@extends('layout')
@section('content')

<div class="card shadow-sm" style="max-width: 550px; margin: 0 auto;">
    <div class="card-header text-white" style="background-color:#2a9d8f;">
        <h4 class="mb-0">Créer un rendez-vous</h4>
    </div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('appointments.store_staff') }}" autocomplete="off">
            @csrf

            <div class="mb-3 position-relative">
                <label class="form-label fw-bold">Patient</label>
                <input
                    type="text"
                    id="patient_search"
                    class="form-control"
                    placeholder="Tapez le nom du patient..."
                    required
                >
                <input type="hidden" name="patient_id" id="patient_id">
                <div id="suggestions-box" class="list-group position-absolute w-100 shadow-sm"
                     style="z-index: 1000; max-height: 200px; overflow-y: auto; display:none;">
                </div>
                <small class="text-muted">Seuls les patients déjà enregistrés sont acceptés.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Département</label>
                <select name="departement_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($departements as $d)
                        <option value="{{ $d->id }}">{{ $d->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Médecin (optionnel)</label>
                <select name="medecin_id" class="form-select">
                    <option value="">-- Non assigné --</option>
                    @foreach($medecins as $m)
                        <option value="{{ $m->id }}">{{ $m->nom }} {{ $m->prenom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Date</label>
                <input type="date" name="date_souhaitee" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Motif</label>
                <textarea name="motif" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Statut</label>
                <select name="statut" class="form-select">
                    <option value="en_attente">En attente</option>
                    <option value="confirme">Confirmé</option>
                    <option value="refuse">Refusé</option>
                </select>
            </div>

            <button class="btn w-100 fw-bold text-white" style="background-color:#2a9d8f;">
                Créer le rendez-vous
            </button>
        </form>
    </div>
</div>

<script>
    const patients = [
        @foreach($patients as $p)
            { id: {{ $p->id }}, nom: @json($p->nom . ' ' . $p->prenom) },
        @endforeach
    ];

    const searchInput = document.getElementById('patient_search');
    const hiddenInput = document.getElementById('patient_id');
    const suggestionsBox = document.getElementById('suggestions-box');

    searchInput.addEventListener('input', function () {
        const valeur = this.value.trim().toLowerCase();
        hiddenInput.value = '';
        suggestionsBox.innerHTML = '';

        if (valeur.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }

        const resultats = patients.filter(p => p.nom.toLowerCase().includes(valeur));

        if (resultats.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }

        resultats.slice(0, 8).forEach(p => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = p.nom;
            item.addEventListener('click', () => {
                searchInput.value = p.nom;
                hiddenInput.value = p.id;
                suggestionsBox.style.display = 'none';
            });
            suggestionsBox.appendChild(item);
        });

        suggestionsBox.style.display = 'block';
    });

    // Ferme la liste si on clique ailleurs
    document.addEventListener('click', function (e) {
        if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
            suggestionsBox.style.display = 'none';
        }
    });
</script>

@endsection