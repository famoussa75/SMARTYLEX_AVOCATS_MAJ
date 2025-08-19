@extends('layouts.base')
@section('title','Annuaires')
@section('content')
<div class="container-fluid">


    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

        <h4 class="theme-cl"><i class="ti i-cl-0 ti-server"></i> Données externes > <span class="label bg-info"><b>Annuaire de contact</b></span></h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#importData">
                        <i class=" ti-import i-cl-4"></i> Mettre à jour
                    </a>
                </div>
            </div>
            <div class="btn-group mr-lg-2">
                <div class="btn-group">
                    <a href="" title="Créer une tâche" class="cl-white theme-bg btn btn-rounded" data-toggle="modal"
                        data-target="#addcontact">
                        <i class=" fa fa-plus"></i>
                        Ajouter un contact
                    </a>
                </div>
            </div>
        </div>

    </div>

        <!-- Title & Breadcrumbs-->

        <div class="card  col-md-12" style="margin-top:30px;padding:10px">

            <div class=" table-responsive">
                <div class="category-filter">
                    <select id="categoryFilter" class="categoryFilter form-control">
                        <option value="">Tous</option>

                    </select>
                </div>
                <table id="filterTable" class="filterTable dataTableExport table table-bordered table-hover"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Societe</th>
                            <th>Prenoms & Noms</th>
                            <th>Position</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($annuaires as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->societe }}</td>
                            <td>{{ $row->prenom_et_nom }}</td>
                            <td>{{ $row->poste_de_responsabilite }}</td>
                            <td>{{ $row->telephone }}</td>
                            <td>{{ $row->email }}</td>
                            <td><a href="" data-toggle="modal" id="{{ $row->id }}" data-target="#updateContact" onclick="var id= this.id ; updateContact(id)"><i class="fa fa-pencil" style="color:dodgerblue ;"></i></a>
                                <a href="" data-toggle="modal" id="{{ $row->id }}" data-target="#deleteContact" onclick="var id= this.id ; deleteContact(id)"><i class="fa fa-trash" style="color:brown ;"></i></a>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>

<div class="add-popup modal fade" id="importData" tabindex="-1" role="dialog" aria-labelledby="importData">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class=" ti-import"></i> Mise à jour de l'annuaire</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <!-- form start -->
                            <form class="padd-20" method="post" action="{{ route('importAnnuaireData') }}"
                                enctype="multipart/form-data">
                                <div class="text-center">
                                    @csrf
                                </div>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <h5><i class="fa fa-info-circle"></i> Instructions :</h5>
                                        <p><b>1.</b> Telechargez le format appropié du fichier <b>EXCEL</b> pour la base
                                            de donnée. <a class="load"
                                                href="{{URL::to('/')}}/assets/format_database/annuaires.xlsx"
                                                download="annuaires.xlsx"><i class="fa fa-download"></i> Telecharger le
                                                format ici </a></p>
                                        <p><b>2.</b> Importez la base de données <b>EXCEL</b> après avoir remplis
                                            l'annuaire en respectant le format.</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mrg-0">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="label-control"> Importer le fichier ici</label>
                                            <input type="file" accept=".xls,.xlsx," class="fichiers form-control" name="fichiers"
                                                required>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="cl-white theme-bg btn btn-rounded btn-block btn-default"
                                                    style="width:50%;"><i class="fa fa-check"></i> Valider</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="addcontact" tabindex="-1" role="dialog" aria-labelledby="addcontact">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nouveau contact</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('contact.create')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Société</label>
                                        <input type="text" class="form-control" name="societe">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Prénom et Nom</label>
                                        <input type="text" class="form-control" name="prenom_et_nom" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Position</label>
                                        <input type="text" class="form-control" name="poste_de_responsabilite">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Téléphone(s)</label>
                                        <input type="text" class="form-control" name="telephone">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="client" class="control-label">Lier à un client (Facultatif):</label>

                                        <select class="form-control  select2" data-placeholder="selectionner le client" style="width: 100%;" name="idClient" id="client">

                                            <option value="" selected disabled>-- Choisissez --</option>
                                            @foreach ($clients as $data )
                                            <option value={{ $data->idClient }}>
                                                {{$data->prenom}} {{$data->nom}} {{$data->denomination}}
                                            </option>
                                            @endforeach

                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                        style="width:50%;"> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="updateContact" tabindex="-1" role="dialog" aria-labelledby="updateContact">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification du contact</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('contact.update')}}" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="description">Société</label>
                                        <input type="text" class="form-control" name="societe" id="societeContact">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Prénom et Nom</label>
                                        <input type="text" class="form-control" name="prenom_et_nom"  id="prenom_et_nomContact" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Position</label>
                                        <input type="text" class="form-control" name="poste_de_responsabilite" id="poste_de_responsabiliteContact">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Téléphone(s)</label>
                                        <input type="text" class="form-control" name="telephone" id="telephoneContact">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Email</label>
                                        <input type="email" class="form-control" name="email" id="emailContact" required>
                                    </div>
                                    <input type="hidden" name="idContact" id="idContact">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block "
                                        style="width:50%;"> Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="add-popup modal fade" id="deleteContact" tabindex="-1" role="dialog" aria-labelledby="deleteContact">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:gray;">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez la suppression</h4>
            </div>
            <form method="post" action="{{route('contact.delete')}}" accept-charset="utf-8"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                    <p>Voulez-vous vraiment supprimer ce contact du systeme ?</p>
                    <input type="hidden" id="idContactDelete" name="idContact">

                    <div class="row mrg-0">
                        <div class="col-md-12 col-sm-12">
                            <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal"
                                aria-label="Close">
                                NON
                            </a>

                            <button type="submit" class="btn btn-danger">OUI</button>

                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>

<script>

    // Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");
   
    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function (e) {
           
            var fichiersInput = this.querySelectorAll(".fichiers"); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name + " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});
document.getElementById('de').classList.add('active');
</script>


<!-- /.row -->
@endsection