@extends('template')

@section('main')
<div class="container-fluid h-100 bg-light">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <h1 class="display-4 fw-bold text-primary">TechFinder</h1>
                <p class="text-muted">Gestion Intelligente des Interventions Technologiques</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-4 text-center">Connexion</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Identifiant</label>
                            <input type="text" name="login_user" class="form-control form-control-lg bg-light border-0" placeholder="Ex: admin" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Mot de passe</label>
                            <input type="password" name="password_user" class="form-control form-control-lg bg-light border-0" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                            Se connecter
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4 text-muted small">
                &copy; 2026 TechFinder &bull; 3il3
            </div>
        </div>
    </div>
</div>
@endsection
