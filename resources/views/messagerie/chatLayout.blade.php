
@extends('layouts.base')
@section('title','Messgerie')
@section('content')
    <div class="container-fluid">

        <!-- Title & Breadcrumbs-->
        <div class="row page-breadcrumbs">
            <div class="col-md-12 align-self-center">
                <h4 class="theme-cl">Messagerie</h4>
            </div>
        </div>
        <!-- Title & Breadcrumbs-->
        
        <!-- chat-wappers-->
        <div class="chat-wappers">
            <div class="app">
                <div class="row app-one">
                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 chat-conversation bl-1">
                    
                        <div class="row heading bg-light">
                        
                            <div class="col-sm-2 col-md-1 col-3 heading-avatar">
                                <div class="head-avater-icon">
                                <img src="assets/dist/img/user-7.jpg" alt="profil">
                                </div>
                            </div>
                            
                            <div class="col-sm-8 col-8 heading-name">
                                <a class=" heading-name-meta"> {{ Auth::user()->name }}</a>
                                <span class="heading-online cl-success">Online</span>
                            </div>
                            
                        </div>

                        <div class="row message col-md-12 col-sm-12 col-lg-12 col-xs-12" id="chat-conversation">
                            <ul class="chat-list padd-20 col-md-12 col-sm-12 col-lg-12">
                                
                                <li>
                                    <div class="chat-img"><img src="assets/dist/img/user-6.jpg" alt="user"></div>
                                    <div class="chat-rev-content">
                                        <div class="row">
                                            <div class="col-sm-10 col-md-6 col-6">
                                                <h5 class="mrg-bot-5 heading-name-meta">FOFANAH</h5>
                                            </div>
                                            <div class="col-sm-2 col-md-6 col-6">
                                                <div class="btn-group fl-right">
                                                    <button type="button" class="btn-trans" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-2x ti-more"></i>
                                                    </button>
                                                        <div class="dropdown-menu  bg-yellow">
                                                            <a class="dropdown-item" href="#"><i class="ti-file mr-2"></i>Archiver</a>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="time-meta">10:57 am</div>
                                            <div class="chating-box cl-white bg-purple">It’s Great opportunity to work.</div>
                                        </div>
                                    </div>
                                </li>
                                <!--chat Row -->
                                
                                <li class="chat-reverse">
                                    <div class="chat-rev-content">
                                        
                                        <div class="row">
                                            <div class="col-sm-2 col-xs-2 col-md-2 col-6">
                                                <div class="btn-group fl-right">
                                                    <button type="button" class="btn-trans" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-2x ti-more"></i>
                                                    </button>
                                                        <div class="dropdown-menu  bg-yellow">
                                                            <a class="dropdown-item" href="#"><i class="ti-file mr-2"></i>Archiver</a>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-10 col-md-10 col-6">
                                                <h5 class="mrg-bot-5" style="font-weight: bold;">DIALLO</h5>
                                            </div>
                                        </div>
                                        <div class="chating-box cl-white bg-info">It’s Great opportunity to work.</div>
                                        <div class="chat-time">10:57 am</div>
                                    </div>
                                    <div class="chat-img"><img src="assets/dist/img/user-7.jpg" alt="user"></div>
                                </li>
                                <!--chat Row -->
                                
                            </ul>
                        </div>
                        <div class="row chat-reply bg-light">
                            <div class="col-sm-10 col-xs-10 chat-reply-main">
                                <textarea class="form-control" rows="1" id="comment" placeholder="saisir votre message ici ........"></textarea>
                            </div>
                            <div class="col-sm-2 col-xs-2 chat-reply-send">
                                <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <!-- col-md-8 -->
                </div>
            </div>
        </div>
    </div>

@endsection
