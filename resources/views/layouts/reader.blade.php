@extends('layouts.base')
@section('title','Lecteur du document')
@section('content')
<div class="container-fluid"="alert('bien')">
    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-9 align-self-center">
            <h4 class="theme-cl text-center"><i class="fa fa-mouse-pointer"></i> Cliquer sur l'icône pour ouvrir
                le
                document
            </h4>
        </div>
        <div class="col-md-3 text-right">
            <input type="text" name="readerMessage" value="back" hidden>
            <div class="btn-group">
                <a href="javascript:history.back()" class="cl-white theme-bg btn btn-rounded"
                    title="Cliquer pour fermer le fichier">
                    <i class="fa fa-long-arrow-left"></i> Retour
                </a>
            </div>
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