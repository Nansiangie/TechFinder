@extends('template')

@section('main')
<main class="container my-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header {{ isset($intervention_edit) ? 'bg-warning text-dark' : 'bg-dark text-white' }} py-2">
                    <h6 class="mb-0 small">{{ isset($intervention_edit) ? 'Modifier #'.$intervention_edit->code_int : 'Nouvelle Intervention' }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ isset($intervention_edit) ? route('web.interventions.update', $intervention_edit->code_int) : route('web.interventions.store') }}" method="POST">
                        @csrf
                        @if(isset($intervention_edit)) @method('PUT') @endif

                        <div class="mb-2">
                            <label class="small fw-bold">Date</label>
                            <input type="datetime-local" name="date_int" class="form-control form-control-sm" value="{{ isset($intervention_edit) ? \Carbon\Carbon::parse($intervention_edit->date_int)->format('Y-m-d\TH:i') : '' }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="small fw-bold">Client</label>
                            <select name="code_user_client" class="form-select form-select-sm" required>
                                <option value="">Choisir un client...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->code_user }}" {{ (isset($intervention_edit) && $intervention_edit->code_user_client == $client->code_user) ? 'selected' : '' }}>
                                        {{ $client->nom_user }} {{ $client->prenom_user }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="small fw-bold">Technicien</label>
                            <select name="code_user_tech" class="form-select form-select-sm" required>
                                <option value="">Choisir un technicien...</option>
                                @foreach($techniciens as $tech)
                                    <option value="{{ $tech->code_user }}" {{ (isset($intervention_edit) && $intervention_edit->code_user_tech == $tech->code_user) ? 'selected' : '' }}>
                                        {{ $tech->nom_user }} {{ $tech->prenom_user }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="small fw-bold">Compétence Requise</label>
                            <select name="code_comp" class="form-select form-select-sm" required>
                                <option value="">Choisir...</option>
                                @foreach($competences as $comp)
                                    <option value="{{ $comp->code_comp }}" {{ (isset($intervention_edit) && $intervention_edit->code_comp == $comp->code_comp) ? 'selected' : '' }}>
                                        {{ $comp->label_comp }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold">Description</label>
                            <textarea name="description_int" class="form-control form-control-sm" rows="2" required>{{ $intervention_edit->description_int ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn {{ isset($intervention_edit) ? 'btn-warning' : 'btn-primary' }} btn-sm w-100 fw-bold">Enregistrer</button>
                        @if(isset($intervention_edit))
                            <a href="{{ route('web.interventions.index') }}" class="btn btn-light btn-sm w-100 mt-2">Annuler</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-secondary mb-0 fw-bold">Liste des Interventions</h5>
            </div>
            <div class="table-responsive bg-white shadow-sm rounded mb-3">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3">DATE</th>
                            <th>CLIENT</th>
                            <th>TECHNICIEN</th>
                            <th>COMPÉTENCE</th>
                            <th class="text-end pe-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($interventions_list as $int)
                        <tr>
                            <td class="ps-3 fw-bold">{{ \Carbon\Carbon::parse($int->date_int)->format('d/m/Y H:i') }}</td>
                            <td>{{ $int->client->nom_user ?? 'N/A' }}</td>
                            <td>{{ $int->technicien->nom_user ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $int->competence->label_comp ?? 'N/A' }}</span></td>
                            <td class="text-end pe-3">
                                <a href="{{ route('web.interventions.edit', $int->code_int) }}" class="btn btn-sm btn-outline-warning border-0 p-0 me-2">Modifier</a>
                                <form action="{{ route('web.interventions.destroy', $int->code_int) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0 fw-bold" onclick="return confirm('Confirmer ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end small">{{ $interventions_list->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</main>
@endsection
