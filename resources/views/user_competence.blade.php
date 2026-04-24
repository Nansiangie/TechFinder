@extends('template')

@section('main')
<main class="container my-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-2">
                    <h6 class="mb-0 small">Affecter une Compétence</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('web.user_competences.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold">Technicien</label>
                            <select name="code_user" class="form-select form-select-sm" required>
                                <option value="">Sélectionner...</option>
                                @foreach($techniciens as $tech)
                                    <option value="{{ $tech->code_user }}">{{ $tech->nom_user }} {{ $tech->prenom_user }} ({{ $tech->code_user }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="small fw-bold">Compétence</label>
                            <select name="code_comp" class="form-select form-select-sm" required>
                                <option value="">Sélectionner...</option>
                                @foreach($competences as $comp)
                                    <option value="{{ $comp->code_comp }}">{{ $comp->label_comp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Affecter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-secondary mb-0 fw-bold">Matrice des Compétences</h5>
            </div>
            <div class="table-responsive bg-white shadow-sm rounded mb-3">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3">TECHNICIEN</th>
                            <th>CODE COMPÉTENCE</th>
                            <th class="text-end pe-3">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($affectations as $aff)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $aff->utilisateur->nom_user ?? $aff->code_user }}</td>
                            <td><span class="badge bg-secondary">#{{ $aff->code_comp }}</span></td>
                            <td class="text-end pe-3">
                                <form action="{{ route('web.user_competences.destroy', ['code_user' => $aff->code_user, 'code_comp' => $aff->code_comp]) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0 fw-bold" onclick="return confirm('Retirer cette compétence ?')">Retirer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end small">{{ $affectations->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</main>
@endsection
