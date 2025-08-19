<footer class="sticky-footer" >
    <div class="container">
        <div class="text-center">
            <small class="font-15"> &nbsp;&nbsp; <img src="{{URL::to('/')}}/assets/img/3.png" style="height:40px;width:40px" alt=""
                    class="factureImage" /> &nbsp;&nbsp; Copyright © Smartylex - Version Beta 1.5 &nbsp;🚀&nbsp;&nbsp;</small>
        </div>
    </div>
</footer>

<!-- Switcher Start -->
<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
    <div class="rightMenu-scroll" >

        <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large theme-bg"
            style="text-align: center;">Thèmes du système <i class="ti-close"></i></button>
        <div class="right-ch-sideBar" id="side-scroll">
            <div class="user-box">

                <div class="profile-img">
                    @if(Auth::user()->role != 'Administrateur')
                    @if(Session::has('photo'))
                    @foreach (Session::get('photo') as $photo)
                    <img src="{{URL::to('/')}}/{{$photo->photo}}" alt="...">
                    @endforeach
                    @endif
                    @else
                    <img src="{{URL::to('/')}}/{{Auth::user()->photo}}" alt="...">
                    @endif
                    <!-- this is blinking heartbit-->
                    <div class="notify setp"> <span class="heartbit"></span> </div>
                </div>
                <div class="profile-text">
                    <h4>{{Auth::user()->name}}</h4>
                    <span>
                        @if(Auth::user()->role=='Administrateur')
                        Administrateur
                        @elseif(Auth::user()->role=='Assistant')
                        Assistant(e)
                        @elseif(Auth::user()->role=='Collaborateur')
                        Collaborateur
                        @endif
                    </span>

                </div>
                <div class="tabbable-line">
                    <ul class="nav nav-tabs bg-primary-light">
                        <li></li>
                        <li class="active">
                            <a class="bg-info-light" href="#options" data-toggle="tab">
                                <i class="ti-palette"></i> </a>
                        </li>


                    </ul>
                    <div class="tab-content">
                        <!-- Option Tab -->
                        <div class="tab-pane active" id="options">
                            <ul id="themecolors" class="m-t-20">
                                <li><a href="{{route('setTheme','red-skin')}}" class="default-theme">1</a></li>
                                <li><a href="{{route('setTheme','green-skin')}}" class="green-theme">2</a></li>
                                <li><a href="{{route('setTheme','blue-skin')}}" class="blue-theme">3</a></li>
                                <li><a href="{{route('setTheme','yellow-skin')}}" class="yellow-theme">4</a></li>
                                <li><a href="{{route('setTheme','purple-skin')}}" class="purple-theme">5</a></li>
                                <li><a href="{{route('setTheme','cyan-skin')}}" class="cyan-theme">6</a></li>
                                <li><a href="{{route('setTheme','red-skin-light')}}"
                                        class="default-light-theme working">7</a></li>
                                <li><a href="{{route('setTheme','green-skin-light')}}" class="green-light-theme">8</a>
                                </li>
                                <li><a href="{{route('setTheme','blue-skin-light')}}" class="blue-light-theme">9</a>
                                </li>
                                <!-- <li><a href="{{route('setTheme','yellow-skin-light')}}"
                                        class="yellow-light-theme">10</a></li>
                                <li><a href="{{route('setTheme','purple-skin-light')}}"
                                        class="purple-light-theme">11</a></li>
                                <li><a href="{{route('setTheme','cyan-skin-light')}}" class="cyan-light-theme ">12</a>
                                </li> -->
                            </ul>

                        </div>
                    </div>
                </div>
                <hr>
               <div class="col-md-12"><b><i class="fa fa-lock"></i> Mode de confidentialité</b></div>
                <div class="col-md-12">
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="infowitch"
                            checked="">
                        <label class="onoffswitch-label label-default" for="infowitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Switcher -->