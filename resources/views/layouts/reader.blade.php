@extends('layouts.base')
@section('title','Lecteur du document')
@section('content')
<div class="container-fluid"="alert('bien')">
  <!-- Title & Breadcrumbs -->
    <div class="page-header-custom d-flex flex-wrap align-items-center justify-content-between mb-4 p-3 shadow-sm bg-white rounded-3">

        <!-- Bloc gauche : icône + titre -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="icon-wrapper me-3 theme-bg">
                <i class="fa fa-mouse-pointer text-white"></i>
            </div>
            <div>
                <h4 class="page-title mb-1">
                    Cliquer sur l'icône pour ouvrir le document
                </h4>
            </div>
        </div>

        <!-- Bloc droit : bouton retour -->
        <div class="d-flex align-items-center mt-2 mt-md-0">
            <input type="text" name="readerMessage" value="back" hidden>
            <a href="javascript:history.back()" title="Cliquer pour fermer le fichier" class="btn btn-gradient-custom">
                <i class="fa fa-long-arrow-left me-1"></i> Retour
            </a>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <div>
            <div id="reader" class="col-md-12 col-lg-12 text-center" style="height:900px">
              <b>Nom original : </b>{{ $files[0]->nomOriginal }} <br>
                <i class="fa fa-file-pdf-o btn" style="font-size:20em; color:red"
                    onclick="readFile('{{ $files[0]->path }}')" title="Cliquer pour ouvrir le fichier"></i>
              
                @if(empty($files))
                    <h3><i class="fa fa-warning"></i> Fichier introuvable . . .</h3>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
@endsection