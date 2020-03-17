<?php 
        $user = Auth::user();
    ?>
<div id="left-sidebar"  class="sidebar table-success">
        <div class="sidebar-scroll" style="max-height: calc(100vh - 5rem);overflow-y: auto;">
            <div class="user-account">
                <img src="{{asset($menu['dataUser']->path_image)}}" class="rounded-lg user-photo" id="user_photo" alt="User Profile Picture">
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong id="nick_user">{{$user->nickname}}</strong></a>                    
                    <ul class="dropdown-menu dropdown-menu-right account animated flipInY">
                        <li><a href="/profile" id="btn-profile"><i class="icon-user"></i>My Profile</a></li>
                    </ul>
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
  