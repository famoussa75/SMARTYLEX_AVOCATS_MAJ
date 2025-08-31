@extends('layouts.base')
@section('title','Gestion des publicités')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs" style="height:100%;display:flex">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-bullhorn"></i> <span class="label bg-info"><b>Gestion des publicités</b></span></h4>
        </div>
        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="#" class="cl-white theme-bg btn btn-rounded" data-toggle="modal" data-target="#publiciteModal"
                        title="Créer une publicité">
                        <i class="fa fa-plus"></i>
                        Nouvelle publicité
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card col-md-12" style="margin-top:30px;padding:10px;display:grid;min-height:70vh">
        <div class="table-responsive">
            <table id="publicitesTable" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Image</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Lien</th>
                        <th scope="col">Date début</th>
                        <th scope="col">Date fin</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publicites as $index => $pub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($pub->image)
                                <img src="{{ asset('storage/publicites/' . $pub->image) }}" alt="{{ $pub->titre }}" style="width: 80px; height: 50px; object-fit: cover;">
                            @else
                                <span class="text-muted">Aucune image</span>
                            @endif
                        </td>
                        <td>{{ $pub->titre }}</td>
                        <td>
                            @if($pub->lien)
                                <a href="{{ $pub->lien }}" target="_blank">{{ Str::limit($pub->lien, 30) }}</a>
                            @else
                                <span class="text-muted">Aucun lien</span>
                            @endif
                        </td>
                        <td>{{ date('d/m/Y', strtotime($pub->debut)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($pub->fin)) }}</td>
                        <td>
                            @if($pub->statut == 'actif')
                                <span class="badge badge-success">Actif</span>
                            @else
                                <span class="badge badge-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-pub" data-id="{{ $pub->id }}" 
                                data-titre="{{ $pub->titre }}" data-lien="{{ $pub->lien }}"
                                data-debut="{{ $pub->debut }}" data-fin="{{ $pub->fin }}"
                                data-statut="{{ $pub->statut }}" data-image="{{ $pub->image }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-pub" data-id="{{ $pub->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal pour créer/éditer une publicité -->
<div class="modal fade" id="publiciteModal" tabindex="-1" role="dialog" aria-labelledby="publiciteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header cl-white theme-bg">
                <h5 class="modal-title" id="publiciteModalLabel">
                    <i class="fa fa-bullhorn"></i> <span id="modalTitle">Nouvelle publicité</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="publiciteForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="pubId" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="publiciteTitre">Titre de la publicité *</label>
                        <input type="text" class="form-control" id="publiciteTitre" name="titre" required placeholder="Entrez le titre">
                    </div>
                    <div class="form-group">
                        <label for="publiciteImage">Image *</label>
                        <input type="file" class="form-control-file" id="publiciteImage" name="image" accept="image/jpeg,image/png,image/gif">
                        <small class="form-text text-muted">Format: JPEG, PNG, GIF. Taille max: 2MB</small>
                        <div id="imagePreview" class="mt-2"></div>
                    </div>
                    <div class="form-group">
                        <label for="publiciteLien">Lien (optionnel)</label>
                        <input type="url" class="form-control" id="publiciteLien" name="lien" placeholder="https://exemple.com">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="publiciteDebut">Date de début *</label>
                                <input type="date" class="form-control" id="publiciteDebut" name="debut" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="publiciteFin">Date de fin *</label>
                                <input type="date" class="form-control" id="publiciteFin" name="fin" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publiciteStatut">Statut *</label>
                        <select class="form-control" id="publiciteStatut" name="statut" required>
                            <option value="actif">Actif</option>
                            <option value="inactif">Inactif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn theme-bg cl-white">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette publicité ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser DataTable
        $('#publicitesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json'
            },
            responsive: true,
            order: [[0, 'asc']]
        });

        // Gérer l'affichage de l'aperçu de l'image
        $('#publiciteImage').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').html(`<img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">`);
                }
                reader.readAsDataURL(file);
            }
        });

        // Gérer l'édition d'une publicité
        $('.edit-pub').click(function() {
            const id = $(this).data('id');
            const titre = $(this).data('titre');
            const lien = $(this).data('lien');
            const debut = $(this).data('debut');
            const fin = $(this).data('fin');
            const statut = $(this).data('statut');
            const image = $(this).data('image');

            $('#modalTitle').text('Modifier la publicité');
            $('#pubId').val(id);
            $('#publiciteTitre').val(titre);
            $('#publiciteLien').val(lien);
            $('#publiciteDebut').val(debut);
            $('#publiciteFin').val(fin);
            $('#publiciteStatut').val(statut);
            
            if (image) {
                $('#imagePreview').html(`<img src="{{ asset('storage/publicites/') }}/${image}" class="img-thumbnail" style="max-height: 150px;"><p class="text-muted mt-1">Image actuelle</p>`);
            } else {
                $('#imagePreview').html('');
            }

            $('#publiciteModal').modal('show');
        });

        // Gérer la suppression d'une publicité
        $('.delete-pub').click(function() {
            const id = $(this).data('id');
            $('#deleteForm').attr('action', '/publicites/' + id);
            $('#deleteModal').modal('show');
        });

        // Réinitialiser le modal lors de sa fermeture
        $('#publiciteModal').on('hidden.bs.modal', function() {
            $('#modalTitle').text('Nouvelle publicité');
            $('#pubId').val('');
            $('#publiciteForm')[0].reset();
            $('#imagePreview').html('');
        });

        // Soumission du formulaire
        $('#publiciteForm').submit(function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = $('#pubId').val() ? '/publicites/' + $('#pubId').val() : '/publicites';
            const method = $('#pubId').val() ? 'POST' : 'POST';
            
            // Ajout de la méthode PUT si on est en mode édition
            if ($('#pubId').val()) {
                formData.append('_method', 'PUT');
            }
            
            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    $('#publiciteModal').modal('hide');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'enregistrement.');
            });
        });
    });
</script>

<style>
    .badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>

@endsection