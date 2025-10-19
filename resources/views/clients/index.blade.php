@extends('layouts.base')
@section('title','Enregistrement du client')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"> <i class="fa fa-users"></i>&nbsp;&nbsp;Clients > <span class="label bg-info"><b>Nouveau</b></span></h4>
        </div>
        <div class="col-md-7 text-right">

            <div class="btn-group">
                @if(Auth::user()->role=='Collaborateur')
                <a href="{{ route('CollabClient') }}" title="Liste des clients"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-navicon"></i> Liste des clients
                </a>
                @else
                <a href="{{ route('clientListe') }}" title="Liste des clients"
                    class="cl-white theme-bg btn  btn-rounded">
                    <i class="fa fa-navicon"></i> Liste des clients
                </a>
                @endif
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->
    <div class="row">
        <div class="col-md-12 col-sm-12">

            <div class="row card page-breadcrumbs">
                <div class="col-12">
                    <div class="form-group">
                        <div class="text-center">
                            <h3><label for="typeEntreprise" class="active">Sélectionner le type du client</label></h3>
                            <select class="form-control" id="typeEntreprise" name="typeEntreprise">
                                <option value="" selected disabled>-- Choisissez --</option>
                                <option value="client physique">Client Physique (Personne)</option>
                                <option value="client moral">Client Moral (Entreprise)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <!-- form start -->
                <form class="padd-20" id="clientPhysique" method="post" action="{{ route('addClient') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="text-center">
                        <h2>Client Physique (Personne) </h2>
                        <br>

                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPName" class="control-label">Prénom</label>
                                <input type="text" class="form-control" id="inputPrenom" placeholder=""
                                    name="prenom" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputName" class="control-label">Nom</label>
                                <input type="text" class="form-control" id="inputNom" placeholder="" name="nom"
                                    required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Email de contact</label>
                                <input type="email" class="form-control" id="inputEmail" placeholder=""
                                    name="email"
                                    data-error="Cette saisie est invalide, veillez saisir une adresse email valide"
                                    required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputTelephone" class="control-label">Email de facturation</label><br>
                                <input type="email" class="form-control" name="emailFacture" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                       
                    </div>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputadresse" class="control-label">Adresse</label>
                                    <input type="text" class="form-control" id="inputadresse" placeholder=""
                                        name="adresse" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputTelephone" class="control-label">Téléphone</label><br>
                                    <input type="tel" class="form-control phone" value="+224"
                                        data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask
                                        data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask style="width: 228%;"
                                        id="inputTelephone" name="telephone" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6" hidden>
                                <div class="form-group">
                                    <label for="typeClient" class="control-label">Type Client</label>
                                    <select class="form-control" id="typeClient" name="typeClient">
                                        <option value="Client Physique" selected>Client Physique (Personne)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h2 style="text-align:center">Autres contacts (Facultatif)</h2>
                        <div class="row mrg-0">
                            <table class="table table-bordered" id="dynamicAddRemove-person">
                                <tr>

                                    <th>Prénom</th>
                                    <th>Nom</th>
                                    <th>Poste/Position</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th></th>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <input type="text" name="formset[0][prenom]"
                                            placeholder="" class="form-control"/>
                                    </td>
                                    <td><input type="text" name="formset[0][nom]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[0][poste]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[0][email]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[0][telephone]"
                                            placeholder="" class="form-control" /></td>
                            

                                    <td><button type="button" name="add" id="dynamic-clt-person"
                                            class="cl-white theme-bg btn btn-outline-default"><i
                                                class="fa fa-plus"></i></button></td>
                                </tr>
                            </table>
                        </div>
                       
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <a href="#" type="button" class="theme-bg btn btn-rounded btn-block"
                                        onclick="fechAClientExist2();" style="width:50%; color:white">
                                        Enregistrer</a>
                                </div>
                            </div>
                        </div>

                        <div class="add-popup modal fade" id="confirmClient2" tabindex="-1" role="dialog"
                            aria-labelledby="confirmClient2">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:gray;">
                                        <ul class="card-actions icons right-top">
                                            <li>
                                                <a href="javascript:void(0)" class="text-white" id="close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <i class="ti-close"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez
                                            l'enregistrement</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                                        <p>Un client de même nom ou de nom ressemblant existe déjà.
                                            Voulez-vous vraiment continuer ?</p>

                                        <div class="row mrg-0">
                                            <div class="col-md-12 col-sm-12">
                                                <a href="javascript:void(0)" class="btn btn-default"
                                                    data-dismiss="modal" aria-label="Close">
                                                    NON
                                                </a>

                                                <button type="submit" class="btn btn-primary">OUI</button>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="card padd-20" id="clientMoral" method="post" action="{{ route('addClient') }}"
                    enctype="multipart/form-data">
                    <div class="text-center">
                        <h2>Client Moral (Entreprise)</h2>
                        <br>
                        @csrf
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="entreprise" class="control-label">Dénomination</label>
                                <input type="text" class="form-control" name="denomination" id="inputDenomination"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmailR" class="control-label">Capital social</label>
                                <input type="text" class="form-control" name="capitalSocial" id="inputEmailR" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputSt" class="control-label">RCCM de l'entreprise</label>
                                <input type="text" class="form-control" id="inputSt" name="rccm" required>
                            </div>
                        </div>
                      
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputs" class="control-label">Adresse de l'entreprise</label>
                                <input type="text" class="form-control" name="adresseEntreprise" id="inputs" required>
                            </div>
                        </div>

                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputSt" class="control-label">NIF</label>
                                <input type="text" class="form-control" id="inputSt" name="nif" required>
                            </div>
                        </div>
                      
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputs" class="control-label">CNSS</label>
                                <input type="text" class="form-control" name="cnss" id="inputs" required>
                            </div>
                        </div>

                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputSta" class="control-label">Email de contact</label>
                                <input type="email" class="form-control" name="emailEntreprise" id="inputSta"
                                    data-error="cette adresse email de l'entreprise est invalid" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputTelephone" class="control-label">Email de facturation</label><br>
                                <input type="email" class="form-control" name="emailFacture" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputAd" class="control-label">Téléphone</label><br>
                                <input type="tel" class="form-control phone1" style="width: 228%;" value="+224"
                                    data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask
                                    name="telephoneEntreprise" id="inputAd" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type" class="control-label">Logo du client ( Facultatif )</label>
                                <input type="file" class="fichiers form-control" name="logo" accept="image/*">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h2 style="text-align:center">Représentant(e)</h2>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmailR" class="control-label">Prénom</label>
                                <input type="text" class="form-control" name="prenomRepresentant" id="inputEmailR"
                                    required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEs" class="control-label">Nom</label>
                                <input type="text" class="form-control" id="inputEs" name="nomRepresentant" required>
                            </div>
                        </div>

                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputM" class="control-label">Email</label>
                                <input type="email" class="form-control" name="emailRepresentant" id="inputM"
                                    placeholder="" data-error="cette adresse email est invalid"
                                    required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputA" class="control-label">Téléphone</label><br>
                                <input type="text" class="form-control phone2" style="width: 228%;" value="+224"
                                    data-inputmask="'mask': ['+99[9] 999-99-99-99']" data-mask id="inputA"
                                    name="telephoneRepresentant" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mrg-0">
                        <div class="col-sm-6">
                            <div class="form-group" hidden>
                                <label for="typeClient" class="control-label">Type Client</label>
                                <select class="form-control" id="typeClient" name="typeClient">
                                    <option value="Client Moral" selected>Client Moral (Entreprise)</option>
                                </select>
                            </div>
                        </div>
        
                    </div>
                    <hr>
                    <h2 style="text-align:center">Autres contacts (Facultatif)</h2>
                    <div class="row mrg-0">
                        <table class="table table-bordered" id="dynamicAddRemove-society">
                            <tr>

                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Poste/Position</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th></th>
                            </tr>
                            
                            <tr>
                                <td>
                                    <input type="text" name="formset[0][prenom]"
                                        placeholder="" class="form-control"/>
                                </td>
                                <td><input type="text" name="formset[0][nom]"
                                        placeholder="" class="form-control" /></td>
                                <td><input type="text" name="formset[0][poste]"
                                        placeholder="" class="form-control" /></td>
                                <td><input type="text" name="formset[0][email]"
                                        placeholder="" class="form-control" /></td>
                                <td><input type="text" name="formset[0][telephone]"
                                        placeholder="" class="form-control" /></td>
                        

                                <td><button type="button" name="add" id="dynamic-clt-society"
                                        class="cl-white theme-bg btn btn-outline-default"><i
                                            class="fa fa-plus"></i></button></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="text-center">
                                <a href="#" type="button" class="theme-bg btn btn-rounded btn-block"
                                    onclick="fechAClientExist();" style="width:50%; color:white">
                                    Enregistrer</a>
                            </div>
                        </div>
                    </div>

                    <div class="add-popup modal fade" id="confirmClient" tabindex="-1" role="dialog"
                        aria-labelledby="confirmClient">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color:gray;">
                                    <ul class="card-actions icons right-top">
                                        <li>
                                            <a href="javascript:void(0)" class="text-white" id="close"
                                                data-dismiss="modal" aria-label="Close">
                                                <i class="ti-close"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Confirmez
                                        l'enregistrement</h4>
                                </div>
                                <div class="modal-body">
                                    <h5 class="header-title m-t-0" style="text-align:left ;">Attention !</h5>
                                    <p>Un client de même dénomination ou de dénomination ressemblante existe déjà.
                                        Voulez-vous vraiment continuer ?</p>

                                    <div class="row mrg-0">
                                        <div class="col-md-12 col-sm-12">
                                            <a href="javascript:void(0)" class="btn btn-default" data-dismiss="modal"
                                                aria-label="Close">
                                                NON
                                            </a>

                                            <button type="submit" class="btn btn-primary">OUI</button>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('clt').classList.add('active');
</script>

<script>

// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll("form");

    for (var i = 0; i < forms.length; i++) {
        forms[i].addEventListener("submit", function(e) {

            var fichiersInput = this.querySelectorAll(
                ".fichiers"
            ); // Sélectionne tous les éléments avec la classe "fichier" à l'intérieur du formulaire courant

            var tailleMaxAutorisée = 104857600; // Taille maximale autorisée en octets (1 Mo ici)

            for (var j = 0; j < fichiersInput.length; j++) {
                var fichierInput = fichiersInput[j];
                var fichiers = fichierInput.files; // Liste des fichiers sélectionnés

                for (var k = 0; k < fichiers.length; k++) {
                    var fichier = fichiers[k];

                    if (fichier.size > tailleMaxAutorisée) {
                        alert("Le fichier " + fichier.name +
                            " est trop volumineux. Veuillez choisir un fichier plus petit.");
                        e.preventDefault(); // Empêche la soumission du formulaire
                        return; // Arrête la boucle dès qu'un fichier est trop volumineux
                    }
                }
            }
        });
    }
});


@endsection