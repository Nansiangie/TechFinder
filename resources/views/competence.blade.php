@extends('template')

@section('main')
<main class="container my-4">
    <div class="row">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header {{ isset($competence_edit) ? 'bg-warning text-dark' : 'bg-dark text-white' }} py-2">
                    <h6 class="mb-0 small">
                        {{ isset($competence_edit) ? 'Modifier la Compétence #'.$competence_edit->code_comp : 'Ajouter une Compétence' }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ isset($competence_edit) ? route('web.competences.update', $competence_edit->code_comp) : route('web.competences.store') }}" method="POST">
                        @csrf
                        @if(isset($competence_edit))
                            @method('PUT')
                        @endif

                        @if(isset($competence_edit))
                            <div class="mb-2">
                                <label class="small fw-bold text-muted">ID Compétence (Auto)</label>
                                <input type="text" class="form-control form-control-sm bg-light" value="{{ $competence_edit->code_comp }}" readonly>
                            </div>
                        @endif

                        <div class="mb-2">
                            <label class="small fw-bold">Label</label>
                            <input type="text" name="label_comp" class="form-control form-control-sm"
                                   value="{{ isset($competence_edit) ? $competence_edit->label_comp : '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold">Description</label>
                            <textarea name="description_comp" class="form-control form-control-sm" rows="2">{{ isset($competence_edit) ? $competence_edit->description_comp : '' }}</textarea>
                        </div>

                        <button type="submit" class="btn {{ isset($competence_edit) ? 'btn-warning' : 'btn-primary' }} btn-sm w-100 fw-bold">
                            {{ isset($competence_edit) ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>

                        @if(isset($competence_edit))
                            <a href="{{ route('web.competences.index') }}" class="btn btn-light btn-sm w-100 mt-2">Annuler</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-secondary mb-0 fw-bold">Liste des Compétences</h5>
                <span class="badge bg-secondary rounded-pill">{{ $competences_list->total() }} enregistrée(s)</span>
            </div>

            <div class="table-responsive bg-white shadow-sm rounded mb-3">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light text-secondary">
                        <tr class="small">
                            <th class="ps-3">CODE</th>
                            <th>LABEL</th>
                            <th>DESCRIPTION</th>
                            <th class="text-end pe-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach($competences_list as $competence)
                        <tr>
                            <td class="ps-3 text-muted">#{{ $competence->code_comp }}</td>
                            <td class="fw-bold">{{ $competence->label_comp }}</td>
                            <td>{{ Str::limit($competence->description_comp, 35) }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('web.competences.edit', $competence->code_comp) }}" class="btn btn-sm btn-outline-warning border-0 p-0 me-2" title="Modifier">
                                    Modifier
                                </a>

                                <form action="{{ route('web.competences.destroy', $competence->code_comp) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0 fw-bold" onclick="return confirm('Confirmer la suppression ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end small">
                {{ $competences_list->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div> </main>
@endsection
