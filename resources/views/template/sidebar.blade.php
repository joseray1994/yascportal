<?php 
        $user = Auth::user();
    ?>
<div id="left-sidebar"  class="sidebar table-success">
        <div class="sidebar-scroll" style="max-height: calc(100vh - 5rem);overflow-y: auto;">
            <div class="user-account">
                @if($menu['dataUser']->path_image)
                    <img src="{{asset($menu['dataUser']->path_image)}}" class="rounded-lg user-photo" id="user_photo" alt="User Profile">
                @else
                    <img src="{{asset('images/default.png')}}" class="rounded-lg user-photo" id="user_photo" alt="User Profile">
                @endif
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="/profile" class="dropdown-toggle user-name"><strong id="nick_user">{{$user->nickname}}</strong></a>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-center">{{$menu['typeuser']->name}}</h6>            
                    </div>
                </div>
                <hr>

            </div>
            <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu" >
                    @foreach ($menu['menuUser'] as $optionmenu)
                        <li id='sidebar{{$optionmenu->id_menu}}'><a href="{{$optionmenu->link}}"><i class="{{$optionmenu->icon}} text-danger"></i><span>{{$optionmenu->name}}</span></a> </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
  