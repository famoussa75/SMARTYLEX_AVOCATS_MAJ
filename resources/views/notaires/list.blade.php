@extends('layouts.base')
@section('title','Liste des notaires')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="ti i-cl-0 ti-server"></i> Données externes > <span class="label bg-info"><b>Notaires</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="#" title="Ajouter un notaire" class="cl-white theme-bg btn btn-rounded" data-toggle="modal"
                        data-target="#addNotaire">
                        <i class="fa fa-plus"></i>
                        Ajouter un notaire
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des notaires -->
    <div class="card col-md-12" style="margin-top:30px;padding:10px">
        <div class="table-responsive">
            <table id="notairesTable" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Prénoms et Noms</th>
                        <th>Téléphone 1</th>
                        <th>Téléphone 2</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notaires as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->prenomNtr }} {{ $row->nomNtr }}</td>
                        <td>{{ $row->telNtr_1 }}</td>
                        <td>{{ $row->telNtr_2 }}</td>
                        <td>{{ $row->emailNtr }}</td>
                        <td>{{ $row->adresseNtr }}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#updateNotaire" 
                               onclick="updateNotaire('{{ $row->idNtr }}', '{{ $row->prenomNtr }}', '{{ $row->nomNtr }}', '{{ $row->telNtr_1 }}', '{{ $row->telNtr_2 }}', '{{ $row->emailNtr }}', '{{ $row->adresseNtr }}')">
                                <i class="fa fa-pencil" style="color:dodgerblue;"></i>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#deleteNotaire" 
                               onclick="deleteNotaire('{{ $row->idNtr }}')">
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

<!-- Modal pour ajouter un notaire  -->
<div class="modal fade" id="addNotaire" tabindex="-1" role="dialog" aria-labelledby="addNotaireLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <h5 class="modal-title" id="addNotaireLabel">
                    <i class="fa fa-plus"></i> Nouveau Notaire
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('notaires.store') }}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prenomNtr">Prénom</label>
                                <input type="text" class="form-control" id="prenomNtr" name="prenomNtr" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomNtr">Nom</label>
                                <input type="text" class="form-control" id="nomNtr" name="nomNtr" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telNtr_1">Téléphone 1</label>
                                <input type="text" class="form-control phone-input" id="telNtr_1" name="telNtr_1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telNtr_2">Téléphone 2</label>
                                <input type="text" class="form-control phone-input" id="telNtr_2" name="telNtr_2">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="emailNtr">Email</label>
                        <input type="email" class="form-control" id="emailNtr" name="emailNtr">
                    </div>
                    <div class="form-group">
                        <label for="adresseNtr">Adresse</label>
                        <textarea class="form-control" id="adresseNtr" name="adresseNtr" rows="2"></textarea>
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

<!-- Modal pour modifier un notaire -->
<div class="modal fade" id="updateNotaire" tabindex="-1" role="dialog" aria-labelledby="updateNotaireLabel" aria-hidden="true" style="width:100%">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="updateNotaireLabel">
                    <i class="fa fa-pencil"></i> Modifier le Notaire
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('notaires.update') }}" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_idNtr" name="idNtr">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_prenomNtr">Prénom</label>
                                <input type="text" class="form-control" id="edit_prenomNtr" name="prenomNtr" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nomNtr">Nom</label>
                                <input type="text" class="form-control" id="edit_nomNtr" name="nomNtr" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_telNtr_1">Téléphone 1</label>
                                <input type="text" class="form-control phone-input" id="edit_telNtr_1" name="telNtr_1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_telNtr_2">Téléphone 2</label>
                                <input type="text" class="form-control phone-input" id="edit_telNtr_2" name="telNtr_2">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_emailNtr">Email</label>
                        <input type="email" class="form-control" id="edit_emailNtr" name="emailNtr">
                    </div>
                    <div class="form-group">
                        <label for="edit_adresseNtr">Adresse</label>
                        <textarea class="form-control" id="edit_adresseNtr" name="adresseNtr" rows="2"></textarea>
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

<!-- Modal pour supprimer un notaire -->
<div class="modal fade" id="deleteNotaire" tabindex="-1" role="dialog" aria-labelledby="deleteNotaireLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteNotaireLabel">
                    <i class="fa fa-exclamation-triangle"></i> Confirmer la suppression
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce notaire ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('notaires.destroy') }}" id="deleteNotaireForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="idNtr" id="delete_idNtr">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style pour le bottom sheet */
    .modal.bottom .modal-dialog {
        position: fixed;
        margin: 0;
        width: 100%;
        max-width: 100%;
        bottom: 0;
        left: 0;
        right: 0;
    }
    
    .modal.bottom .modal-content {
        border-radius: 0;
        border-bottom: none;
    }
    
    .modal.bottom .modal-header {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    
    @media (min-width: 576px) {
        .modal.bottom .modal-dialog {
            max-width: 500px;
            margin: 0 auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser DataTable
        $('#notairesTable').DataTable({
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
    function updateNotaire(id, prenom, nom, tel1, tel2, email, adresse) {
        document.getElementById('edit_idNtr').value = id;
        document.getElementById('edit_prenomNtr').value = prenom;
        document.getElementById('edit_nomNtr').value = nom;
        document.getElementById('edit_telNtr_1').value = tel1;
        document.getElementById('edit_telNtr_2').value = tel2;
        document.getElementById('edit_emailNtr').value = email;
        document.getElementById('edit_adresseNtr').value = adresse;
    }
    
    // Fonction pour supprimer un notaire
    function deleteNotaire(id) {
        document.getElementById('delete_idNtr').value = id;
    }
</script>

@endsection