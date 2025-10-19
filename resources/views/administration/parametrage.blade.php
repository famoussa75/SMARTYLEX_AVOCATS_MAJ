@extends('layouts.base')
@section('title','Paramètre avancé')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<style>
    


.file::-webkit-file-upload-button {
    visibility: hidden;
}

.file::before {

    content: 'Parcourir . . .';
    background: linear-gradient(top, #f9f9f9, #e3e3e3);
    border: 1px solid #999;
    border-radius: 3px;
    padding: 5px 8px;
    outline: none;
    white-space: nowrap;
    -webkit-user-select: none;
    cursor: pointer;
    text-shadow: 1px 1px #fff;
    font-weight: 700;
    font-size: 10pt;

}

input[type='file'] {}
</style>




<div class="container-fluid">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl"><i class="fa fa-wrench"></i> Paramètre avancé</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="padd-20" id="" method="post" action="{{ route('updateCabinet') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <h2 class="cl-white theme-bg text-center"><i class="fa fa-info-circle"></i> Informations du
                            cabinet</h2>
                        @foreach($cabinet as $c)
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSta" class="control-label">Nom du cabinet</label>
                                    <input type="text" class="form-control" name="nomCabinet" 
                                        value="{{$c->nomCabinet}}" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Email de contact</label>
                                    <input type="email" class="form-control" name="emailContact" 
                                        value="{{$c->emailContact}}" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Numero toge</label>
                                    <input type="email" class="form-control" name="numToge" 
                                        value="{{$c->numToge}}" readonly>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSt" class="control-label">Sigle</label>
                                    <input type="text" class="form-control"  name="nomCourt"
                                        value="{{$c->nomCourt}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Mot de passe</label><br>

                                        <div class="password-container">
                                            <input type="password" class="form-control" name="cleContact" value="{{$c->cleContact}}" id="passwordField3" style="width:100%">
                                            <i class="pass-view fa fa-eye" id="togglePasswordField3"></i>
                                        </div>
                                </div>


                            </div>
                            <div class="row col-md-12 mb-3 mt-3" style="border: 5px solid orange;padding:10px">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputM" class="control-label">Email des audiences</label>
                                                <input type="text" class="form-control" name="emailAudience" 
                                                    value="{{$c->emailAudience}}" readonly>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputM" class="control-label">Mot de passe</label><br>
                                                <div class="password-container">
                                                    <input type="password" class="form-control" name="cleAudience" value="{{$c->cleAudience}}" id="passwordField" >
                                                    <i class="pass-view fa fa-eye" id="togglePasswordField"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputM" class="control-label">Email des finances</label>
                                                <input type="text" class="form-control" name="emailFinance" 
                                                    value="{{$c->emailFinance}}" readonly>
                                                <div class="help-block with-errors"></div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputM" class="control-label">Mot de passe</label><br>
                                            
                                                <div class="password-container">
                                                    <input type="password" class="form-control" name="cleFinance" value="{{$c->cleFinance}}" id="passwordField2" >
                                                    <i class="pass-view fa fa-eye" id="togglePasswordField2"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 alert alert-warning">
                                        <h2><i class="fa fa-warning"></i> Message important</h2>
                                        <p>Les emails ci-contre sont des emails que votre plateforme se servira pour envoyer automatiquement ou manuellement des mails.</p>
                                        <p>Proprement dite, l'email audience sera utilisé pour envoyer des emails aux clients, email finance sera utiliser pour envoyer des factures aux clients.</p>
                                        <p>Ces emails doivent obligatoirement provenir de <a href="https://titan.email/" target="_blank">Titan</a> (Fournisseurs d'email).</p>
                                        <p>Pour tout autres Fournisseurs d'emails veuillez contacter l'équipe smartylex pour un support technique.</p>
                                        <p>S'il vous arrive de changer votre email ou votre mot de passe, assurez vous de les changer dans cette page aussi.</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSt" class="control-label">Slogan</label>
                                    <input type="text" class="form-control"  name="slogan"
                                        value="{{$c->slogan}}">
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Adresse du cabinet</label>
                                    <input type="text" class="form-control" name="adresseCabinet" 
                                        value="{{$c->adresseCabinet}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Telephone 1</label><br>
                                    <input type="text" class="form-control  phone-input" name="tel1" 
                                        value="{{$c->tel1}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Telephone 2</label> <br>
                                    <input type="text" class="form-control phone-input" name="tel2"  
                                        value="{{$c->tel2}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Site web</label>
                                    <input type="text" class="form-control" name="siteweb" 
                                        value="{{$c->siteweb}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">NIF</label>
                                    <input type="text" class="form-control" name="nif"  value="{{$c->nif}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Numero TVA</label>
                                    <input type="text" class="form-control" name="numTva" 
                                        value="{{$c->numTva}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Monnaie par defaut du système</label>
                                    <select name="monnaieParDefaut" class="form-control select2" id="monnaieParDefaut"
                                        style="width: 100%;">
                                        <option value="{{$c->monnaieParDefaut}}"><span
                                                style="color:red">{{$c->monnaieParDefaut}}</span></option>
                                        <option value="GNF">GNF</option>
                                        <option value="EURO">EURO</option>
                                        <option value="USD">USD</option>
                                        <option value="FCFA">FCFA</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Nombre de compte utilisateur </label>
                                    <input type="text" class="form-control" name="totalComptes" 
                                        value="{{$c->totalComptes}}" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type" class="control-label">Changer le logo</label>
                                    <input type="file" class="fichiers form-control" name="logo" accept="image/*">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <hr>
                        <h4><i class="fa fa-money"></i> Taux de change & Monnaies</h4>
                        <div class="row mrg-0 col-md-6">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Monnaies</label>
                                    <input type="text" class="form-control" name="tauxEchangeGNF" id="m1"
                                        value="{{$monnaies[0]->tauxEchangeGn}}" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Valeur</label>
                                    <input type="number" class="form-control" name="valeurTauxGNF" 
                                        value="{{$monnaies[0]->valeurTaux}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                        </div>
                        <div class="row mrg-0 col-md-6">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Monnaies</label>
                                    <input type="text" class="form-control" name="tauxEchangeEURO" id="m2"
                                        value="{{$monnaies[1]->tauxEchangeGn}}" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Valeur</label>
                                    <input type="number" class="form-control" name="valeurTauxEURO" 
                                        value="{{$monnaies[1]->valeurTaux}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                        </div>
                        <div class="row mrg-0 col-md-6">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Monnaies</label>
                                    <input type="text" class="form-control" name="tauxEchangeUSD" id="m3"
                                        value="{{$monnaies[2]->tauxEchangeGn}}" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Valeur</label>
                                    <input type="number" class="form-control" name="valeurTauxUSD" 
                                        value="{{$monnaies[2]->valeurTaux}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                        </div>
                        <div class="row mrg-0 col-md-6">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Monnaies</label>
                                    <input type="text" class="form-control" name="tauxEchangeCFA" id="m4"
                                        value="{{$monnaies[3]->tauxEchangeGn}}" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Valeur</label>
                                    <input type="number" class="form-control" name="valeurTauxCFA" 
                                        value="{{$monnaies[3]->valeurTaux}}">
                                    <div class="help-block with-errors"></div>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <h4><i class="fa fa-bank"></i> Comptes bancaires</h4>
                        <div class="col-md-12">
                            <label for="type" class="control-label">Inserez les RIBs de vos comptes bancaires</label>
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <tr>

                                    <th>Nom de la banque</th>
                                    <th>Device</th>
                                    <th>Code Banque</th>
                                    <th>Code Guichet</th>
                                    <th>Numero de compte</th>
                                    <th>Clé RIB</th>
                                    <th>IBAN</th>
                                    <th>Code BIC</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($compteBancaires as $cb)
                                <tr>
                                    <td><input type="hidden" name="formset[{{$cb->idCompteBank}}][idCompteBank]"
                                            value="{{$cb->idCompteBank}}">
                                        <input type="text" name="formset[{{$cb->idCompteBank}}][nomBank]" placeholder=""
                                            class="form-control" value="{{$cb->nomBank}}" required />
                                    </td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][devise]" placeholder=""
                                            class="form-control" value="{{$cb->devise}}" required />
                                    </td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][codeBank]"
                                            placeholder="" class="form-control" value="{{$cb->codeBank}}" /></td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][codeGuichet]"
                                            placeholder="" class="form-control" value="{{$cb->codeGuichet}}" /></td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][numCompte]"
                                            placeholder="" class="form-control" value="{{$cb->numCompte}}" required />
                                    </td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][cleRib]" placeholder=""
                                            class="form-control" value="{{$cb->cleRib}}" /></td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][iban]" placeholder=""
                                            class="form-control" value="{{$cb->iban}}" /></td>
                                    <td><input type="text" name="formset[{{$cb->idCompteBank}}][codeBic]" placeholder=""
                                            class="form-control" value="{{$cb->codeBic}}" /></td>

                                    <td>
                                    <button type="button" class="btn btn-outline-danger remove-input-field-RIB"><i class="fa fa-trash"></i></button></td>
                                   
                                </tr>
                                @endforeach
                                <tr>
                                    <td><input type="hidden" name="formset[{{count($compteBancaires)+1}}][idCompteBank]"
                                            value="{{count($compteBancaires)+1}}">
                                        <input type="text" name="formset[{{count($compteBancaires)+1}}][nomBank]"
                                            placeholder="" class="form-control" value="" /> </td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][devise]"
                                            placeholder="" class="form-control"/></td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][codeBank]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][codeGuichet]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][numCompte]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][cleRib]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][iban]"
                                            placeholder="" class="form-control" /></td>
                                    <td><input type="text" name="formset[{{count($compteBancaires)+1}}][codeBic]"
                                            placeholder="" class="form-control" /></td>

                                    <td><button type="button" name="add" id="dynamic-arRIB"
                                            class="cl-white theme-bg btn btn-outline-default"><i
                                                class="fa fa-plus"></i></button></td>
                                </tr>
                            </table>
                            <input type="hidden" id="valeurI" value="{{count($compteBancaires)+1}}">

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputSta" class="control-label">Termes et Conditions de facturation</label>
                                <textarea class="form-control" name="termesFacture" id="" cols="30" rows="4">{{$c->termesFacture}}</textarea>
                               
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <hr>
                        <h4><i class="fa fa-pencil"></i> Signature du cabinet</h4>
                        <textarea  name="signature" rows="4" id="summernote"
                                class="form-control"> @foreach($cabinet as $c) <?php echo $c->signature; ?> @endforeach</textarea> <br>
                        <hr>
                        <h4><i class="fa fa-file"></i> Rapport de tâche</h4><br>
                        <div class="col-md-12 row">
                            <div class="col-md-2 form-group">
                                <label for="inputSta" class="control-label mb-2">Activer/Désactiver le rapport de tâche</label>
                                    <div class="material-switch">
                                        <input id="someSwitchOptionSuccess" name="rapportTache" type="checkbox" @if ($cabinet[0]->rapportTache=='on') checked @else @endif>
                                        <label for="someSwitchOptionSuccess" class="label-success"></label>
                                    </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="inputSta" class="control-label" style="margin-left:22px">M'envoyer le rapport</label><br>
                                    <select class="custom-select mb-2 form-control" name="frequenceRapport">
                                        <option selected="{{$cabinet[0]->frequenceRapport}}">
                                            @if($cabinet[0]->frequenceRapport=='journalier')
                                                Chaque jour
                                            @elseif($cabinet[0]->frequenceRapport=='mensuel')
                                                Chaque mois
                                            @else
                                                Chaque trimestre
                                            @endif
                                        </option>
                                        <hr>
                                        <option value="journalier">Chaque jour</option>
                                        <option value="mensuel">Chaque mois</option>
                                        <option value="trimestriel">Chaque trimestre</option>
                                    </select>
                                
                            </div>
                        </div>
                        <hr>

                        @foreach($admin as $a)
                        @if($a->id==Auth::user()->id)
                        <h2 class="cl-white theme-bg text-center"><i class="fa fa-user-secret"></i> Compte
                            Administrateur</h2>
                        <div class="row mrg-0">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputSta" class="control-label">Nom complet</label>
                                    <input type="text" class="form-control" name="name" 
                                        value="{{$a->name}}" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                        value="{{$a->email}}" required>
                                    <div class="help-block with-errors"></div>
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputM" class="control-label">Initial</label>
                                    <input type="text" class="form-control" name="initial" 
                                        placeholder="Ex : ASK" value="{{$a->initial}}" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <label for="inputSt" class="control-label">Mot de passe</label><br>
                                    <a href="{{ route('editPassword', Auth::user()->email) }}" type="button"
                                        class="btn waves-effect waves-light btn-rounded btn-warning"><i
                                            class="fa fa-pencil"></i> Modifier le mot de passe</a>
                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="file" class="control-label">Changer la photo de profile</label>
                                    <input type="file" class="fichiers form-control" name="photo" accept="image/*">
                                </div>


                            </div>

                        </div>
                        @endif
                        @endforeach
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="theme-bg btn btn-rounded btn-block" style="width:50%;">
                                        Enregistrer les modifications</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>


document.getElementById('pa').classList.add('active');

// Controle de la taille des fichiers
document.addEventListener("DOMContentLoaded", function() {
    console.warn = () => {};
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

$('#summernote').summernote({
        placeholder: 'Inserer une signature',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
</script>
<!-- /.row -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/google-libphonenumber/3.2.24/google-libphonenumber.min.js"></script>

<script>
    document.querySelectorAll('.phone-input').forEach(input => {
        const iti = window.intlTelInput(input, {
            initialCountry: "gn",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
            formatOnDisplay: true,
            autoHideDialCode: false,
            nationalMode: false
        });

        const phoneUtil = libphonenumber.PhoneNumberUtil.getInstance();
        const PNT = libphonenumber.PhoneNumberType;

        const feedback = input.parentElement.querySelector('.help-block.with-errors');
        function setFeedback(msg, isError) {
            if (feedback) {
                feedback.textContent = msg || '';
                feedback.style.color = isError ? 'crimson' : 'green';
            }
        }

        let maxNational = null;
        let lastValidValue = ''; // pour revenir en arrière si dépasse

        function updateMaxNationalLength() {
            const countryData = iti.getSelectedCountryData();
            const iso2 = countryData.iso2 ? countryData.iso2.toUpperCase() : null;
            maxNational = null;

            if (iso2) {
                try {
                    let exampleNumber = phoneUtil.getExampleNumberForType(iso2, PNT.MOBILE);
                    if (!exampleNumber) {
                        exampleNumber = phoneUtil.getExampleNumberForType(iso2, PNT.FIXED_LINE);
                    }
                    if (exampleNumber) {
                        const nationalExample = phoneUtil.format(exampleNumber, libphonenumber.PhoneNumberFormat.NATIONAL);
                        maxNational = nationalExample.replace(/\D/g, '').length;
                    }
                } catch (e) {
                    console.warn('Impossible d\'obtenir la longueur nationale pour', iso2, e);
                }
            }
        }

        function validateAndProvideFeedback() {
            if (!iti.isValidNumber()) {
                setFeedback('Numéro invalide ou incomplet.', true);
            } else {
                setFeedback('Numéro valide.', false);
            }
        }

        // initialisation
        updateMaxNationalLength();
        validateAndProvideFeedback();
        lastValidValue = input.value;

        input.addEventListener('countrychange', () => {
            updateMaxNationalLength();
            validateAndProvideFeedback();
            lastValidValue = input.value;
        });

        input.addEventListener('input', () => {
            // Extrait uniquement les chiffres de la partie nationale affichée
            const digitsOnly = input.value.replace(/\D/g, '');
            if (maxNational && digitsOnly.length > maxNational) {
                // dépassement : on revient à la dernière valeur valide
                input.value = lastValidValue;
            } else {
                // pas de dépassement : on met à jour le "dernier bon"
                lastValidValue = input.value;
            }
            validateAndProvideFeedback();
        });

        // soumission : mettre le numéro complet international
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                input.value = iti.getNumber();
            });
        }

        // valeur par défaut si présente
        const defaultVal = input.dataset.default;
        if (defaultVal) {
            iti.setNumber(defaultVal);
            updateMaxNationalLength();
            validateAndProvideFeedback();
            lastValidValue = input.value;
        }
    });
</script>




@endsection