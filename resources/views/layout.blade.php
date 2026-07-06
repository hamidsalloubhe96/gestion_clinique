<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Clinique Chifa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#2a9d8f;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Clinique Chifa</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(auth()->user()->role === 'staff')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointments.index') }}">
                                Rendez-vous
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('patients.index') }}">Patients</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('medecins.index') }}">Médecins</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('departements.index') }}">Départements</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('appointments.create') }}">Prendre RDV</a></li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Déconnexion</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
</body>
</html>