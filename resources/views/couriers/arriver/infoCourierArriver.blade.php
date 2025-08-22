@extends('layouts.base')
@section('title','Courriers - Arrivée')
@section('content')
<div class="container-fluid">
@php
setlocale(LC_TIME, 'fr_FR');
@endphp

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

   
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        @if(empty($clientAffaire))
        <div class="col-md-6 align-self-center">
            <h5 class="theme-cl">Courrier cabinet > <span class="label bg-info-light"><b><i class="fa fa-envelope"></i> Courriers - Arrivée</b></span></h5>
        </div>
        @else
        <div class="col-md-6 align-self-center">
            <h5 class="theme-cl">
            <a class="" href="{{route('clientInfos', [$clientAffaire[0]->idClient,$clientAffaire[0]->slugClient])}}">{{ $clientAffaire[0]->idClient }} > {{ $clientAffaire[0]->prenom }} {{ $clientAffaire[0]->nom }}{{ $clientAffaire[0]->denomination }} </a> > <a class="" href="{{ route('showAffaire', [$clientAffaire[0]->idAffaire,$clientAffaire[0]->slugAffaire]) }}">{{ $clientAffaire[0]->idAffaire }} {{ $clientAffaire[0]->nomAffaire }}</a> > <span class="label bg-info-light"><b><i class="fa fa-envelope"></i> Courriers - Arrivée</b></span></h5>
        </div>
    
        @endif
      
        <div class="col-md-6 text-right">

           @if(Auth::user()->role=="Administrateur" && $courierArriver[0]->statut != 'Classé')
            <div class="btn-group">
                <a  href="{{ route('taskForm',[$courierArriver[0]->idCourierArr,'courier'])}}" type="button" class="cl-white theme-bg btn  btn-rounded"
                    title="Créer une tâche">
                    <i class="fa fa-plus"></i>
                    Créer une tâche
                </a>
            </div>
                @if($courierArriver[0]->statut == 'Annulé')
                @else
                <div class="btn-group">
                    <a  href="{{ route('classerCourrier',$courierArriver[0]->slug) }}" class="cl-white theme-bg btn  btn-rounded"
                        title="Classer le courier">
                        <i class="fa fa-arrow-down"></i>
                        Classer
                    </a>
                </div>
                @endif
            @else
            @endif
            
            <div class="btn-group">
                <a  href="{{ route('listCourierArriver') }}" class="cl-white theme-bg btn  btn-rounded"
                    title="Afficher la liste des couriers">
                    <i class="fa fa-navicon"></i>
                    Liste des couriers
                </a>
            </div>
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
                                                @if(empty($courier->dateCourier))
                                                    <small>N/A</small>
                                                @else
                                                    <small
                                                         class="label bg-info">{{ date('d-m-Y', strtotime( $courier->dateCourier))}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date d'arrivée</td>
                                            <td>
                                                @if(empty($courier->dateArriver))
                                                    <small>N/A</small>
                                                @else

                                                    <small
                                                        class="label bg-warning">{{ date('d-m-Y', strtotime( $courier->dateArriver))}}</small>
                                                @endif
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <td>Statut </td>
                                            <td> {{ $courier->statut }}</td>
                                        </tr>
                                        @if (!empty($couriersHuissier))
                                            <p>Huissier : {{ $couriersHuissier[0]->prenomHss }}  {{ $couriersHuissier[0]->nomHss }}</p>
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
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                <form action="{{ route('soumetreCourierArrivers') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <button type="submit" class="form-control bg-primary btn-rounded">Transmettre</button>
                                        <input type="hidden" name="slugCourier" value="{{ $courier->slug }}">
                                    </div>
                                </form>
                                </div>
                                <div class="col-md-3"></div>
                                <br><br><br><br>
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

                    @if($courier->statut=='Annulé')
                        
                        @else
                            <a href="#" title="Lier un courrier" data-toggle="modal" data-target="#modal-2"
                                    class="cl-white bg-info btn  btn-rounded">
                                    <i class="fa fa-plus"></i>
                                </a>
                        @endif
                   
                   
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
                                                                        {{$info->idClient}} > {{$info->prenom}} {{$info->nom}} > {{$info->idAffaire}} {{$info->nomAffaire}}
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
                                                                {{$info->idClient}} > {{$info->prenom}} {{$info->nom}} > {{$info->idAffaire}} {{$info->nomAffaire}}
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
                                               
                                                <option value="{{ $c->slugDepart }}">{{$c->idClient }}>  {{ $c->prenom }} {{ $c->nom }} >{{ $c->idAffaire }} {{ $c->nomAffaire }} 
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
                                                    <option value="{{ $cabinet->slug }}">{{ $cabinet->numero }} {{ $cabinet->objet }}</option>
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
                                            
                                                    <option value="{{ $cabinet->slug }}">{{ $cabinet->numCourier }} {{ $cabinet->objet }}</option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('cr').classList.add('active');
</script>


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