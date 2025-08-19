<div class="col-md-7 text-right">
    <div class="btn-group">
        <a href="#" class="btn gredient-btn" data-toggle="modal" data-target="#addcontact" title="Liste des Affaires">
        Liste des affaires
        </a>
    </div>
    <div class="btn-group">
        <a href="#" style="color:red" class="btn gredient-btn" data-toggle="modal" data-target="#addcontact" title="Créer un client">
        Créer un client
        </a>
    </div>
</div>





<div class="col-md-12 col-sm-12">
    <div class="card">
        <!-- form start -->
        <form method="post" action="{{ route('addFileBusinesse') }}" enctype="multipart/form-data"   class="padd-20">
            <div class="text-center">
                <h2>Jointure de la pièce a l'affaire</h2>
                <br>
                @csrf
            </div>
            <div class="row mrg-0">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputPName" class="control-label">Nom de la pièce </label>
                        <input type="text" class="form-control" id="inputPName" placeholder="nom de la pièce jointe " data-error=" veillez saisir le nom de la pièce jointe" name="filename" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Selectionner l'affaire </label>
                        <select class="form-control select2" name="idAffaire" required>
                             <option value="" selected disabled>-- Choisissez --</option>
                            @if(isset($data) && $data->count() >=1)
                                <option value="{{ $data->id }}" selected>{{ $data->nom }}</option>
                            @elseif(isset($affaires))
                                @foreach ($affaires as $data)
                                    <option value="{{ $data->id }}" >{{ $data->nom }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="help-block with-errors"></div>
                  </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title m-t-0">Joindre la Pièce</h4>
                        </div>
                        <div class="card-body">
                                <input type="file" name="pathFiles" id="files" accept="image/*">
                            <div id="show-files"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mrg-0">
                <div class="col-12">
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="theme-bg btn btn-rounded btn-block " style="width:50%;"> Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>





    <div class="add-popup modal fade" id="addcontact" tabindex="-1" role="dialog" aria-labelledby="addcontact">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header theme-bg">
                    <ul class="card-actions icons right-top">
                        <li>
                            <a href="javascript:void(0)" class="text-white" data-dismiss="modal" aria-label="Close">
                                <i class="ti-close"></i>
                            </a>
                        </li>
                    </ul>
                    <h4 class="modal-title">Nouveau client</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-addon br br-light no-br"><i class="ti-user"></i></span>
                            <input type="text" class="form-control no-bl" id="add_name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-addon br br-light no-br"><i class="ti-email"></i></span>
                            <input type="email" class="form-control no-bl" id="add_email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-addon br br-light no-br"><i class="ti-mobile"></i></span>
                            <input type="text" class="form-control no-bl" id="add_phone" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Location</label>
                        <div class="input-group">
                            <span class="input-group-addon br br-light no-br"><i class="ti-location-pin"></i></span>
                            <input type="text" class="form-control no-bl" id="add_address">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Annulé</button>
                    <button class="btn ">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
