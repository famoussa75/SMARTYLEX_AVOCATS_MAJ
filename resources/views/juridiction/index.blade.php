@extends('layouts.base')
@section('title','Liste des juridictions')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="ti i-cl-0 ti-server"></i> Données externes > <span class="label bg-info"><b>Juridictions</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="#" title="Ajouter une juridiction" class="cl-white theme-bg btn btn-rounded" data-toggle="modal"
                        data-target="#addJuridiction">
                        <i class="fa fa-plus"></i>
                        Ajouter une juridiction
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des juridictions -->
    <div class="card col-md-12" style="margin-top:30px;padding:10px">
        <div class="table-responsive">
            <table id="juridictionsTable" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Type de tribunal</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($juridictions as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->nom }}</td>
                        <td>{{ $row->type_tribunal }}</td>
                        <td>{{ $row->telephone }}</td>
                        <td>{{ $row->adresse }}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#updateJuridiction" 
                               onclick="updateJuridiction('{{ $row->id }}', '{{ $row->nom }}', '{{ $row->type_tribunal }}', '{{ $row->telephone }}', '{{ $row->adresse }}')">
                                <i class="fa fa-pencil" style="color:dodgerblue;"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#deleteJuridiction" 
                               onclick="deleteJuridiction('{{ $row->id }}')">
                                <i class="fa fa-trash" style="color:brown;"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour ajouter une juridiction (Right Side) -->
<div class="modal fade right" id="addJuridiction" tabindex="-1" role="dialog" aria-labelledby="addJuridictionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <h5 class="modal-title" id="addJuridictionLabel">
                    <i class="fa fa-plus"></i> Nouvelle Juridiction
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('juridictions.store') }}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom de la juridiction *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="type_tribunal">Type de tribunal *</label>
                        <select class="form-control" id="type_tribunal" name="type_tribunal" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="Tribunal de Première Instance">Tribunal de Première Instance</option>
                            <option value="Cour d'Appel">Cour d'Appel</option>
                            <option value="Cour Suprême">Cour Suprême</option>
                            <option value="Tribunal de Commerce">Tribunal de Commerce</option>
                            <option value="Tribunal Administratif">Tribunal Administratif</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="text" class="form-control phone-input" id="telephone" name="telephone">
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <textarea class="form-control" id="adresse" name="adresse" rows="2"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn theme-bg cl-white">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier une juridiction -->
<div class="modal fade right" id="updateJuridiction" tabindex="-1" role="dialog" aria-labelledby="updateJuridictionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="updateJuridictionLabel">
                    <i class="fa fa-pencil"></i> Modifier la Juridiction
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('juridictions.update') }}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group">
                        <label for="edit_nom">Nom de la juridiction *</label>
                        <input type="text" class="form-control" id="edit_nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_type_tribunal">Type de tribunal *</label>
                        <select class="form-control" id="edit_type_tribunal" name="type_tribunal" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="Tribunal de Première Instance">Tribunal de Première Instance</option>
                            <option value="Cour d'Appel">Cour d'Appel</option>
                            <option value="Cour Suprême">Cour Suprême</option>
                            <option value="Tribunal de Commerce">Tribunal de Commerce</option>
                            <option value="Tribunal Administratif">Tribunal Administratif</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_telephone">Téléphone</label>
                        <input type="text" class="form-control phone-input" id="edit_telephone" name="telephone">
                    </div>
                    <div class="form-group">
                        <label for="edit_adresse">Adresse</label>
                        <textarea class="form-control" id="edit_adresse" name="adresse" rows="2"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn theme-bg cl-white">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour supprimer une juridiction -->
<div class="modal fade" id="deleteJuridiction" tabindex="-1" role="dialog" aria-labelledby="deleteJuridictionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteJuridictionLabel">
                    <i class="fa fa-exclamation-triangle"></i> Confirmer la suppression
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette juridiction ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('juridictions.destroy') }}" id="deleteJuridictionForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style pour le modal à droite */
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 400px;
        height: 100%;
        transform: translate3d(0%, 0, 0);
    }
    
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        border-radius: 0;
        border: none;
    }
    
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }
    
    .modal.right.fade .modal-dialog {
        right: -400px;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }
    
    .modal.right.fade.show .modal-dialog {
        right: 0;
    }
    
    .modal-content {
        border-radius: 0;
        border: none;
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
        .modal.right .modal-dialog {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser DataTable
        $('#juridictionsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json'
            },
            responsive: true
        });
        
        // Initialiser les champs de téléphone
        $('.phone-input').each(function() {
            $(this).inputmask({
                mask: '+999 999-99-99-99',
                placeholder: '+224 ___ __ __ __'
            });
        });
    });
    
    // Fonction pour remplir le formulaire de modification
    function updateJuridiction(id, nom, type_tribunal, telephone, adresse) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nom').value = nom;
        document.getElementById('edit_type_tribunal').value = type_tribunal;
        document.getElementById('edit_telephone').value = telephone;
        document.getElementById('edit_adresse').value = adresse;
    }
    
    // Fonction pour supprimer une juridiction
    function deleteJuridiction(id) {
        document.getElementById('delete_id').value = id;
    }
</script>

@endsection