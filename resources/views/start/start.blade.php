@extends('layouts.base')
@section('title','Liste du personnel')
@section('content')
<div class="container-fluid">

    <!-- Title & Breadcrumbs-->
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">
            <h4 class="theme-cl">Titre</h4>
        </div>

        <div class="col-md-7 text-right">
            <div class="btn-group mr-lg-2">
                <a href="#" class="btn  tooltips">
                    <i class="ti-flix ti-view-list-alt"></i>
                </a>
            </div>
            <div class="btn-group">
                <a href="#" class="btn gredient-btn" data-toggle="modal" data-target="#addcontact"
                    title="Create project">
                    Ajouter ou Liste
                </a>
            </div>
        </div>
    </div>
    <!-- Title & Breadcrumbs-->
    <div class="row">
        List of components
        <!-- phone mask -->


        <div class="input-group">
            <div class="col-md-6">
                <div class="input-group-addon">
                    <select class="select2 form-control" id="codePays"> </select>
                </div>
            </div>
            <input type="text" class="form-control" data-inputmask="'mask': ['+9[99] 999-99-99-99']" data-mask
                id="phoneNumber">
        </div>


        <!-- /.form group -->
    </div>
</div>
@endsection