<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFinder - 3il3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; color: #0d6efd !important; }
        footer { background: #ffffff; border-top: 1px solid #dee2e6; }
        /* Permet de centrer parfaitement le Welcome au milieu de l'écran */
        .main-container { min-height: calc(100vh - 120px); display: flex; align-items: center; justify-content: center; flex-direction: column; }
    </style>
</head>
<body class="d-flex flex-column h-100">

    {{-- On affiche la nav UNIQUEMENT si on n'est pas sur la page login --}}
    @if(!Route::is('login'))
    {{-- On affiche TOUJOURS la barre de navigation --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid">
            <a class="navbar-brand text-primary fw-bold" href="#">TechFinder</a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('web.utilisateurs.*') ? 'active' : '' }}" href="{{ route('web.utilisateurs.index') }}">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('web.competences.*') ? 'active' : '' }}" href="{{ route('web.competences.index') }}">Compétences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('web.interventions.*') ? 'active' : '' }}" href="{{ route('web.interventions.index') }}">Interventions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('web.user_competences.*') ? 'active' : '' }}" href="{{ route('web.user_competences.index') }}">Affectations</a>
                    </li>
                </ul>

                {{-- Partie Droite : Profil simulé --}}
                <div class="navbar-nav align-items-center">
                    <span class="text-light me-3 small">
                        Bonjour, <strong>Mode Dev</strong>
                    </span>
                    {{-- Bouton inactif juste pour le design --}}
                    <button class="btn btn-outline-secondary btn-sm fw-bold" disabled>Déconnexion</button>
                </div>
            </div>
        </div>
    </nav>

    @endif
    {{-- FIN DU BLOC NAV --}}

    {{-- Conteneur principal qui pousse le footer vers le bas --}}
    <div class="flex-grow-1">
        @yield('main')
    </div>

    <footer class="footer mt-auto py-3">
        <div class="container-fluid px-5">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary h4 mb-0">3il3</span>
                <span class="fw-bold text-dark h4 mb-0">2026</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
