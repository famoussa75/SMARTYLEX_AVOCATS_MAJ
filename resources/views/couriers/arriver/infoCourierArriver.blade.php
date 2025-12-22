@extends('layouts.base')
@section('title','Courriers - Arrivée')
@section('content')

<style>
.radio-sm {
    width: 18px;   /* taille du bouton */
    height: 18px;
    transform: scale(0.9);
    margin-right: 6px; /* petit espace avec le texte */
    padding: 10px;
    margin:10px;
    margin-top:30px;

}

.radio-group {
    display: flex;
    align-items: center; /* centre verticalement */
    justify-content: center; /* centre horizontalement si besoin */
    gap: 5px; /* espace entre input et label */
}
</style>

<div class="container-fluid">
@php
setlocale(LC_TIME, 'fr_FR');
@endphp
   
 <!-- Page Header -->
<div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

<div class="d-flex align-items-center mb-2 mb-md-0">
    <div class="icon-wrapper me-2">
        <i class="fa fa-envelope fs-4"></i>
    </div>

    <div>
        @if(empty($clientAffaire))
            <h4 class="page-title mb-0">
                Courrier Cabinet
                <span class="page-subtitle">› Courriers - Arrivée</span>
            </h4>
            <small class="text-muted">Gérez les courriers entrants du cabinet.</small>

        @else
            <h4 class="page-title mb-0 d-flex flex-wrap align-items-center">
            Courriers - Arrivée
                <a class="page-subtitle text-decoration-none fw-semibold"
                    href="{{ route('clientInfos', [$clientAffaire[0]->idClient, $clientAffaire[0]->slugClient]) }}">
                    &nbsp;› {{ $clientAffaire[0]->idClient }}
                </a>
                <span class="mx-2 text-muted">›</span>

                <a class="page-subtitle text-decoration-none fw-semibold"
                    href="{{ route('clientInfos', [$clientAffaire[0]->idClient, $clientAffaire[0]->slugClient]) }}">
                    {{ $clientAffaire[0]->prenom }} {{ $clientAffaire[0]->nom }} {{ $clientAffaire[0]->denomination }}
                </a>
                <span class="mx-2 text-muted">›</span>

                <a class="page-subtitle text-decoration-none fw-semibold"
                    href="{{ route('showAffaire', [$clientAffaire[0]->idAffaire, $clientAffaire[0]->slugAffaire]) }}">
                    {{ $clientAffaire[0]->idAffaire }} {{ $clientAffaire[0]->nomAffaire }}
                </a>

            </h4>
            <small class="text-muted">Courriers reçus liés à cette affaire.</small>
        @endif
    </div>
</div>

<div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">

    @if(Auth::user()->role == "Administrateur" && $courierArriver[0]->statut != 'Classé')
    <div class="dropdown d-inline-block">
        <button class="btn btn-gradient-custom cl-white btn-rounded shadow-sm dropdown-toggle d-flex align-items-center"
                type="button" id="actionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                style="padding: 8px 18px; font-weight: 500;">
            <i class="fa fa-cogs me-2"></i> &nbsp;
            <span>Actions</span>
        </button>

        <ul class="dropdown-menu dropdown-menu-right border-0 shadow-sm rounded-3 mt-2"
            aria-labelledby="actionsDropdown" style="min-width: 220px;">
            <li>
                <a class="dropdown-item d-flex align-items-center py-2"
                href="{{ route('taskForm', [$courierArriver[0]->idCourierArr, 'courier']) }}">
                    <i class="fa fa-plus-circle text-success me-2"></i>&nbsp;
                    <span>Créer une tâche</span>
                </a>
            </li>
            @if($courierArriver[0]->statut != 'Annulé')
            <li>
                <a class="dropdown-item d-flex align-items-center py-2"
                href="{{ route('classerCourrier', $courierArriver[0]->slug) }}">
                    <i class="fa fa-archive text-primary me-2"></i>&nbsp;
                    <span>Classer le courrier</span>
                </a>
            </li>
            @endif
        </ul>
    </div> &nbsp;

    @endif

    <a href="{{ route('listCourierArriver') }}"
       class="btn btn-outline-primary-custom btn-rounded shadow-sm d-flex align-items-center"
       style="padding: 8px 18px; font-weight: 500;">
        <i class="fa fa-navicon me-2"></i>&nbsp;
        <span>Liste des courriers</span>
    </a>
</div>


</div>

    <!-- Title & Breadcrumbs-->
    <div class="row">
        <div class="card col-md-8">
            <br>
            <!-- The timeline -->
            <ul class="timeline timeline">
                <!-- timeline item -->
                <li class="time-label">
                    <span class="bg-purple">
                        @foreach ($courierArriver as $courier )
                        Expéditeur : {{ $courier->expediteur }}
                        @endforeach
                    </span>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <div class="timeline-item">
                        <h3 class="timeline-header">Informations</h3>
                        <div class="timeline-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                         <tr>
                                            <td>N° du courrier</td>
                                            <td> {{ $courier->numero }}</td>
                                        </tr>
                                        @if(empty($clientAffaire))
                                        <tr>
                                             <td>Type de courrier</td>
                                             <td>Courrier Cabinet</td>
                                         </tr>
                                        @else
                                         <tr>
                                             <td>Client </td>
                                             <td>{{ $clientAffaire[0]->prenom }} {{ $clientAffaire[0]->nom }}{{ $clientAffaire[0]->denomination }}</td>
                                         </tr>
                                         <tr>
                                             <td>Affaire </td>
                                             <td>{{ $clientAffaire[0]->nomAffaire }}</td>
                                         </tr>
                                        @endif
                                        <tr>
                                            <td>Objet</td>
                                            <td> {{ $courier->objet }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date du courrier</td>
                                            <td>
                                                <small
                                                    class="label bg-info">{{ $courier->dateCourier? date('d-m-Y', strtotime( $courier->dateCourier)) :'N/A'}}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date d'arrivée</td>
                                            <td>
                                                <small
                                                    class="label bg-warning">{{$courier->dateArriver? date('d-m-Y', strtotime( $courier->dateArriver)) :'N/A'}}</small>
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <td>Statut </td>
                                            <td> {{ $courier->statut }}</td>
                                        </tr>
                                        @if($courier->signifie)
                                        <tr>
                                            <td>Signifié par </td>
                                            <td> {{ $courier->signifie }}</td>
                                        </tr>
                                        @endif
                                        @if(Auth::user()->role=='Administrateur')
                                        <tr>
                                            <td>Confidentialité</td>
                                            <td>
                                                @if($courier->confidentialite=='on')
                                                <div class="btn-group">
                                                    <a  href="{{ route('offConfArriver',$courier->slug) }}" class="cl-white bg-danger btn  btn-rounded"
                                                        title="Classer le courier">
                                                        <i class="fa fa-lock"></i>
                                                        Désactiver la Confidentialité
                                                    </a>
                                                </div>
                                                @else
                                                <div class="btn-group">
                                                    <a  href="{{ route('onConfArriver',$courier->slug) }}" class="cl-white bg-primary btn  btn-rounded"
                                                        title="Classer le courier">
                                                        <i class="fa fa-unlock"></i>
                                                        Activer la Confidentialité
                                                    </a>
                                                </div>
                                                @endif

                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(empty($clientAffaire))
                        @else
                        <div class="row mb-4">
                            <div class="col-md-4 mb-4">

                                @if($courier->statutCourierTrasmise === 'Transmis')

                                    <button class="form-control btn btn-secondary btn-rounded" disabled>
                                        <i class="fa fa-check"></i> Courrier déjà transmis au client
                                    </button>

                                @else

                                    <form action="{{ route('soumetreCourierArrivers') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <button type="submit" class="form-control btn btn-primary btn-rounded">
                                                <i class="fa fa-send"></i> Transmettre au client
                                            </button>
                                            <input type="hidden" name="slugCourier" value="{{ $courier->slug }}">
                                        </div>
                                    </form>

                                @endif

                            </div>
                        </div>

                        
                        @endif
                    </div>
                </li>
                <!-- END timeline item -->
            </ul>
        </div>
        <div class="card col-md-4">
            <br>
            <!-- The timeline -->
            <ul class="timeline timeline">
                <!-- timeline item -->
                <li class="time-label">
                    <span class="bg-warning">
                        Fichiers
                    </span>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <div class="timeline-item">
                        <h3 class="timeline-header">Pièce du courrier</h3>
                        <div class="timeline-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        @foreach ($courierFile as $courierFile )
                                        <tr>
                                            <td><i class="fa  fa-file-pdf-o" style="color:red; font-size:1.5em;"></i>
                                            </td>
                                            <td> <a class="load" href="{{route('readFile', [$courierFile->slug])}}"
                                                    style="color:red" class="toggle"
                                                    title="Cliquer pour afficher le contenu du fichier">Ouvrir</a> </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <li class="time-label">
                    <span class="bg-primary">
                        Taches
                    </span>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <div class="timeline-item">
                        <h3 class="timeline-header">Traitement du  courrier</h3>
                        <div class="timeline-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        @if(empty($tacheCourier))
                                        <tr>
                                            <span>Aucun traitement encours.</span>
                                        </tr>
                                        @endif
                                        @foreach ($tacheCourier as $t )
                                        <tr>
                                            <td> 
                                                {{$loop->iteration}}- <a class="load" href="{{ route('infosTask', [$t->slug]) }}" style="color:blue"
                                                    class="toggle"
                                                    title="Cliquer pour afficher la tâche">{{$t->titre}}</a>
                                             </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <li class="time-label">
                    <span class="bg-info">Courriers liés </span>&nbsp;
                    <a href="#" title="Lier un courrier" data-toggle="modal" data-target="#modal-2"
                        class="cl-white bg-info btn  btn-rounded">
                        <i class="fa fa-plus"></i>
                    </a>
                   
                </li>
                <li>
                    <div class="timeline-item">
                        <div class="timeline-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <div class="row text text-center ">

                                            @foreach ($courierArriverLiers as $c )

                                                @if($c->slugArriver!=$courierArriver[0]->slug)
                                                <tr>

                                                    <td>
                                                    Courrier Arrivé - N° {{$c->numero}} <br> <a class="load"
                                                            href="{{ route('detailCourierArriver', [$c->slugArriver]) }}"
                                                            style="color:blue" class="toggle"
                                                            title="Cliquer pour afficher le courrier">
                                                            @if(empty($infoCourier))
                                                                {{$c->objet}}  > Courrier cabinet
                                                            @else
                                                                @php
                                                                    $found = false;
                                                                @endphp
                                                                @foreach($infoCourier as $info)
                                                                    @if($info->slugCourierLier == $c->slugArriver)
                                                                        {{$info->idClient}} > {{$info->prenom}} {{$info->nom}} {{$info->denomination}}  > {{$info->idAffaire}} {{$info->nomAffaire}}
                                                                        @php $found = true; @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach

                                                                @if(!$found)
                                                                    {{$c->objet}} > Courrier cabinet
                                                                @endif
                                                            @endif


                                                    </td>
                                                    <td>
                                                        <a href="{{route('deleteLiaisonCourier',[$c->slugTCourierLier])}}"  onclick="event.preventDefault(); confirmDelete(this.href)" class="toggle" title="Supprimer"><i class="fa fa-trash" style="color:red"></i></a>
                                                    </td>
                                                </tr>
                                                @endif

                                            @endforeach
                                        </div>

                                        <div class="row text text-center ">


                                            @foreach ($courierDepartLiers as $c )
                                        <tr>

                                            <td>
                                                Courrier Départ - N° {{$c->numCourier}}<br> <a class="load"
                                                    href="{{ route('infoCourierDepart', [$c->slugDepart]) }}"
                                                    style="color:blue" class="toggle"
                                                    title="Cliquer pour afficher le courrier">

                                                    @if(empty($infoCourierDepart))
                                                        {{$c->objet}} >  Courrier cabinet

                                                    @else
                                                        @php
                                                            $found = false;
                                                        @endphp
                                                        @foreach($infoCourierDepart as $info)

                                                            @if($info->slugCourierLier == $c->slugDepart)
                                                                {{$info->idClient}} > {{$info->prenom}} {{$info->nom}} {{$info->denomination}}  > {{$info->idAffaire}} {{$info->nomAffaire}}
                                                                @php $found = true; @endphp
                                                                @break
                                                            @endif
                                                        @endforeach

                                                        @if(!$found)
                                                            {{$c->objet}} > Courrier cabinet
                                                        @endif
                                                    @endif

                                                     </a>
                                            </td>
                                            <td>
                                                <a href="{{route('deleteLiaisonCourier',[$c->slugTCourierLier])}}" onclick="event.preventDefault(); confirmDelete(this.href)" class="toggle" title="Supprimer"><i class="fa fa-trash" style="color:red"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </div>


                                        @if(empty($courierArriverLiers) && empty($courierDepartLiers))
                                            Aucun courrier trouvé.
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- modal-courier lier -->
<div class="modal modal-box-2 fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="myModalLabel">
            <div class="modal-header theme-bg">
                <ul class="card-actions icons right-top">
                    <li>
                        <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
                <h4 class="modal-title text-center"><i class="fa fa-link"></i> Lier à d'autres courriers</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">

                        <form class="padd-20" method="post" action="{{route('saveCourierLier')}}"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="text-center">
                                    @csrf
                                </div>


                                <div class="radio-group">
                                    <label>
                                        <input type="radio" name="categorie" id="client" value="depart" class="radio-sm"> Courrier client
                                    </label>

                                    <label>
                                        <input type="radio" name="categorie" id="cabinet" value="arrive" class="radio-sm"> Courrier  cabinet
                                    </label>
                                    <label>
                                        <input type="radio" name="categorie" id="suggerer" value="suggerer" class="radio-sm"> Me suggerer
                                    </label>
                                </div>
                                <br>

                                <div class="container" id="suggererClient">
                                    <div class="row">
                                    <label for="clientReq">Suggestions de courriers départ concernant ce client:</label>

                                        <select id=""  class="form-control select2" style="width:100%" name="idCourierLier[]" >
                                            <option value=""></option>

                                            @foreach ($suggeCourierDepart as $c)

                                              <!--  <option value="{{ $c->slugDepart }}">{{$c->idClient }}>  {{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }} >{{ $c->idAffaire }} {{ $c->nomAffaire }} -->
                                                 <option value="{{ $c->slugDepart }}">N° {{$c->numCourier}} - {{$c->objet}}
                                                 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <br><br>

                                <div class="container" id="clientCourrier">
                                    <div class="row">
                                        <div class="col-md-4" id="clientContent-req">
                                            <div class="form-group">
                                                <label for="clientReq">Sélectionner le client* :</label>
                                                    <select id="clientReq" onchange="fetchAffaireCouriers($(this).val())"  class="form-control select2" style="width:100%" >
                                                        <option value=""></option>
                                                        @foreach ($client as $c)
                                                            <option value="{{ $c->idClient }}">{{ $c->prenom }} {{ $c->nom }} {{ $c->denomination }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 d-none" id="affaireContent-req">
                                            <div class="form-group">
                                                <label for="affaireClient-req">Affaire du client concerné* :</label>
                                                <select id="affaireClient-req"  class="form-control select2 my-2" style="width:100%" >
                                                </select>


                                            </div>
                                        </div>



                                    </div>
                                    <div class="row">

                                        <div class="form-group">

                                            <option value=""><span>courrier départ </span></option>
                                            <select class="form-control select2"  id="courrierDepartSelect" name="idCourierLier[]" style="width:100%">
                                                <!-- Dynamique -->
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label>Courriers Arrivés</label>
                                            <select class="form-control select2"  id="courrierArriverSelect" name="idCourierLier[]" style="width:100%">
                                                <!-- Dynamique -->
                                            </select>

                                        </div>


                                    </div>
                                </div>


                                <div class="container" id="courrierCabinet">
                                    <div class="form-group">
                                        <label>Courriers Arrivés Cabinet</label>
                                        <select class="form-control select2"  id="courrierArriverCabinetSelect" name="idCourierLier[]" style="width:100%">
                                            <option value=""></option>
                                            @foreach($courriersArriverCabinet as $cabinet)
                                                @if($cabinet->slug)
                                                    <option value="{{ $cabinet->slug }}">N° {{ $cabinet->numero }} - {{ $cabinet->objet }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Courriers Départs Cabinet</label>
                                        <select class="form-control select2"  id="courrierDepartCabinetSelect" name="idCourierLier[]" style="width:100%">
                                            <option value=""></option>
                                            @foreach($courriersDepartCabinet as $cabinet)
                                                @if($cabinet->slug)

                                                    <option value="{{ $cabinet->slug }}">N° {{ $cabinet->numCourier }} - {{ $cabinet->objet }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                @if(empty($courierArriverLiers) && !empty($courierDepartLiers))
                                   <input type="hidden" name="cleCommune" value="{{$courierDepartLiers[0]->cleCommune}}">
                                @elseif(!empty($courierArriverLiers) && empty($courierDepartLiers))
                                    <input type="hidden" name="cleCommune" value="{{$courierArriverLiers[0]->cleCommune}}">
                                @elseif(!empty($courierArriverLiers) && !empty($courierDepartLiers))
                                    <input type="hidden" name="cleCommune" value="{{$courierArriverLiers[0]->cleCommune}}">
                                @else
                                    <input type="hidden" name="cleCommune" value="">
                                @endif

                                <input type="hidden" name="slugCourier"  id="slugCourier"   value="{{$courier->slug}}">

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
        </div>
    </div>
</div>
<!-- End modal-courier lier -->

<script>
    document.getElementById('cr').classList.add('active');
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        // Cacher les sections au départ
        $('#clientCourrier').hide();
        $('#courrierCabinet').hide();
        $('#suggererClient').hide();

        function resetClientSection() {
            // Réinitialiser les champs client, mais pas les selects cabinet
            $('#clientReq').val('').trigger('change');
            $('#affaireClient-req').val('').trigger('change');
            $('#courrierArriverSelect').empty().trigger('change');
            $('#courrierDepartSelect').empty().trigger('change');
            $('#selectedAffaireName').addClass('d-none').text('');
        }

        function resetCabinetSelection() {
            // Réinitialiser uniquement la sélection du cabinet, sans vider les options
            $('#courrierArriverCabinetSelect').val('').trigger('change');
            $('#courrierDepartCabinetSelect').val('').trigger('change');
        }

        // Détecter le changement sur les radios
        $('input[name="categorie"]').on('change', function () {
            if ($(this).attr('id') === 'client') {
                $('#clientCourrier').show();
                $('#courrierCabinet').hide();
                $('#suggererClient').hide();

                resetClientSection();
            } else if ($(this).attr('id') === 'cabinet') {
                $('#clientCourrier').hide();
                 $('#suggererClient').hide();
                $('#courrierCabinet').show();
                resetCabinetSelection(); // Ne pas vider les options !
            } else if ($(this).attr('id') === 'suggerer') {
                $('#clientCourrier').hide();
                $('#courrierCabinet').hide();
                $('#suggererClient').show();


                resetCabinetSelection(); // Ne pas vider les options !
            }


        });

    });

</script>


@endsection