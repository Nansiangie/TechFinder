@extends('template')

@section('main')
<main class="container-fluid px-4 my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-header {{ isset($utilisateur_edit) ? 'bg-warning text-dark' : 'bg-dark text-white' }} py-2">
                    <h6 class="mb-0 small">{{ isset($utilisateur_edit) ? 'Modifier #'.$utilisateur_edit->code_user : 'Nouvel Utilisateur' }}</h6>
                </div>
                <div class="card-body">

                    @if ($errors->any())
    <div class="alert alert-danger py-1 small mb-3">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <form action="{{ isset($utilisateur_edit) ? route('web.utilisateurs.update', $utilisateur_edit->code_user) : route('web.utilisateurs.store') }}" method="POST">
                        @csrf
                        @if(isset($utilisateur_edit)) @method('PUT') @endif

                        <div class="mb-2">
                            <label class="small fw-bold">Code User</label>
                            <input type="text" name="code_user" class="form-control form-control-sm" value="{{ $utilisateur_edit->code_user ?? '' }}" {{ isset($utilisateur_edit) ? 'readonly' : 'required' }}>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="small fw-bold">Nom</label>
                                <input type="text" name="nom_user" class="form-control form-control-sm" value="{{ $utilisateur_edit->nom_user ?? '' }}" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="small fw-bold">Prénom</label>
                                <input type="text" name="prenom_user" class="form-control form-control-sm" value="{{ $utilisateur_edit->prenom_user ?? '' }}" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Login</label>
                            <input type="text" name="login_user" class="form-control form-control-sm" value="{{ $utilisateur_edit->login_user ?? '' }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Mot de passe {{ isset($utilisateur_edit) ? '(Laisser vide si inchangé)' : '' }}</label>
                            <input type="password" name="password_user" class="form-control form-control-sm" {{ isset($utilisateur_edit) ? '' : 'required' }}>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="small fw-bold">Téléphone</label>
                                <input type="text" name="tel_user" class="form-control form-control-sm" value="{{ $utilisateur_edit->tel_user ?? '' }}" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="small fw-bold">Sexe</label>
                                <select name="sexe_user" class="form-select form-select-sm" required>
                                    <option value="M" {{ (isset($utilisateur_edit) && $utilisateur_edit->sexe_user == 'M') ? 'selected' : '' }}>M</option>
                                    <option value="F" {{ (isset($utilisateur_edit) && $utilisateur_edit->sexe_user == 'F') ? 'selected' : '' }}>F</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="small fw-bold">Rôle</label>
                                <select name="role_user" class="form-select form-select-sm" required>
                                    <option value="admin" {{ (isset($utilisateur_edit) && $utilisateur_edit->role_user == 'admin') ? 'selected' : '' }}>Admin</option>
                                    <option value="technicien" {{ (isset($utilisateur_edit) && $utilisateur_edit->role_user == 'technicien') ? 'selected' : '' }}>Technicien</option>
                                    <option value="client" {{ (isset($utilisateur_edit) && $utilisateur_edit->role_user == 'client') ? 'selected' : '' }}>Client</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold">État</label>
                                <select name="etat_user" class="form-select form-select-sm" required>
                                    <option value="actif" {{ (isset($utilisateur_edit) && $utilisateur_edit->etat_user == 'actif') ? 'selected' : '' }}>Actif</option>
                                    <option value="inactif" {{ (isset($utilisateur_edit) && $utilisateur_edit->etat_user == 'inactif') ? 'selected' : '' }}>Inactif</option>
                                    <option value="suspendu" {{ (isset($utilisateur_edit) && $utilisateur_edit->etat_user == 'suspendu') ? 'selected' : '' }}>Suspendu</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn {{ isset($utilisateur_edit) ? 'btn-warning' : 'btn-primary' }} btn-sm w-100 fw-bold">
                            {{ isset($utilisateur_edit) ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                        @if(isset($utilisateur_edit))
                            <a href="{{ route('web.utilisateurs.index') }}" class="btn btn-light btn-sm w-100 mt-2">Annuler</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-secondary mb-0 fw-bold">Liste des Utilisateurs</h5>
                <span class="badge bg-secondary rounded-pill">{{ $utilisateurs_list->total() }}</span>
            </div>
            <div class="table-responsive bg-white shadow-sm rounded mb-3">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3">CODE</th>
                            <th>NOM & PRÉNOM</th>
                            <th>ROLE</th>
                            <th>ETAT</th>
                            <th class="text-end pe-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($utilisateurs_list as $user)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $user->code_user }}</td>
                            <td>{{ $user->nom_user }} {{ $user->prenom_user }}</td>
                            <td><span class="badge bg-info text-dark">{{ $user->role_user }}</span></td>
                            <td>
                                @if($user->etat_user == 'actif') <span class="badge bg-success">Actif</span>
                                @elseif($user->etat_user == 'suspendu') <span class="badge bg-danger">Suspendu</span>
                                @else <span class="badge bg-secondary">Inactif</span> @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('web.utilisateurs.edit', $user->code_user) }}" class="btn btn-sm btn-outline-warning border-0 p-0 me-2">Modifier</a>
                                <form action="{{ route('web.utilisateurs.destroy', $user->code_user) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0 fw-bold" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end small">{{ $utilisateurs_list->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</main>
@endsection
