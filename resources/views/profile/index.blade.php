@extends ('welcome')
@section ('content')
<?php 
        $user = Auth::user();
    ?>
<div class="row clearfix">

    <div class="col-lg-4 col-sm-12">
        <div class="card profile-header">
            <div class="header text-center">
            @if($menu['dataUser']->path_image)
            <img src="{{asset($menu['dataUser']->path_image)}}" id="image-profile" alt="profile image" class="img-thumbnail mx-auto" style="max-height:350px">
            @else
            <img src="{{asset('images/default.png')}}" id="image-profile" alt="profile image" class="img-thumbnail mx-auto" style="max-height:350px">
            @endif
            </div>
            <div class="body">
                <div>
                    <h4 class="m-b-0"><strong id="label_nickname">{{$user->nickname}}</strong></h4>
                    <span></span>
                </div>                          
            </div>
        </div>

        
        <div class="card-body">
            <div class="header">
                <legend>Info</legend>
            </div>
            <div class="body">
                <small class="text-muted">Name: </small>
                <p id="label_name">{{$data->name}}</p>
                <hr>
                <small class="text-muted">Last Name: </small>
                <p id="label_last_name">{{$data->last_name}}</p>
                <hr>
                <small class="text-muted">Notes: </small>
                <p id="label_notes">{{$data->notes}}</p>
                <hr>
                <small class="text-muted">Description: </small>
                <p id="label_description">{{$data->description}}</p>
                <hr>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12">

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs-new">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Overview" id="btnOverview">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Settings" id="btnSettings">Settings</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Documents" id="btnDocuments">Documents</a></li>
                </ul>
            </div>
        </div>
        
        <div class="tab-content padding-0">

            <div class="tab-pane animated fadeIn active" id="Overview">
                <div class="card">
                    <div class="header">
                        <legend>More Info</legend>
                    </div>
                    <div class="body">
                        <small class="text-muted">Address: </small>
                        <p id="label_address">{{$data->address}}</p>
                        <hr>
                        <small class="text-muted">Email address: </small>
                        <p id="label_email">{{$data->email}}</p>
                        <hr>
                        <small class="text-muted">Mobile: </small>
                        <p id="label_phone">{{$data->phone}}</p>
                        <hr>
                        <small class="text-muted">Birth Date: </small>
                        <p id="label_birthdate" class="m-b-0">{{$data->birthdate}}</p>
                        <hr>
                        <small class="text-muted">Emergency Contact: </small>
                        <p id="label_contact_name">{{$data->emergency_contact_name}}</p>
                        <p id="label_contact_phone">{{$data->emergency_contact_phone}}</p>
                    </div>
                </div>
            </div>

            <div class="tab-pane animated fadeIn" id="Settings">

                <div class="card">
                    <div class="body">
                        <h6>Basic Information</h6>
                        <form id="formProfile" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <h6>First Name:</h6>
                                    <input type="text" name="name" id="name" class="form-control" maxlength="150" value="{{$data->name}}">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <h6>Last  Name:</h6>
                                    <input type="text" name="last_name" id="last_name" class="form-control" maxlength="150" value="{{$data->last_name}}">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <h6>Phone:</h6>
                                    <input type="tel" name="phone" id="phone" class="form-control" maxlength="20" value="{{$data->phone}}">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <h6>Address:</h6>
                                    <input type="text" name="address" id="address" class="form-control" maxlength="190" value="{{$data->address}}">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <h6>Emergency Contact Name:</h6>
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" class="form-control" maxlength="150" value="{{$data->emergency_contact_name}}">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <h6>Emergency Contact Phone:</h6>
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" class="form-control" maxlength="20" value="{{$data->emergency_contact_phone}}">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <h6>Nickname:</h6>
                                    <input type="text" name="nickname" id="nickname" class="form-control text-lowercase" onkeypress="return RestrictSpace()" maxlength="150" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()" value="{{$data->nickname}}">
                                    <div class="my-2 seccion-sugerencia" style="display:none">
                                        <span class="badge badge-success my-2">available</span>
                                        <select name="sugerencias" id="sugerencias" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <h6>Birthday (YYYY-MM-DD):</h6>
                                    <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{date('Y-m-d', strtotime($data->birthdate))}}">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <h6>Notes:</h6>
                                    <input type="text" name="notes" id="notes" class="form-control" maxlength="150" value="{{$data->notes}}">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <h6>Information:</h6>
                                    <textarea name="description" id="description" class="form-control">{{$data->description}}</textarea>
                                </div>
                                <hr>
                                
                            </div>
                            <hr>
                            <div class="row segunda-seccion">
                            <input type="hidden" id="flag">
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="form-group error btn-group col-sm-12 show_pass_div">
                                            <div class="fancy-checkbox" bis_skin_checked="1" style="text-align:center; vertical-align:middle;">
                                            <label><input type="checkbox" id="show_pass"><span>Change password</span></label>
                                            </div>  
                                        </div>
                                        <div class="col-sm-6 form-group pass">
                                            <h6>Password:</h6>
                                            <input type="text" name="password" id="password" class="form-control" maxlength="20">
                                        </div>
                                        <div class="col-sm-6 form-group pass">
                                            <h6>Confirm Password:</h6>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" maxlength="20">
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="col-sm-12 form-group">
                                        <div class="card">
                                            <div class="body">
                                                <input type="file" class="dropify" id="dropify-event" name="image" data-default-file="{{asset($menu['dataUser']->path_image)}}" data-show-remove="false">
                                            </div>
                                        </div>  
                                    </div>          
                                </div>
                            </div>

                            <div class="col-sm-12 text-center " >					 
                                <button type="button" class="btn btn-danger btn-cancel">Cancel</button>
                                <button type="submit" class="btn btn-success segunda-seccion" id="btn-save" value="add">Save</button>
                                <input type="hidden" id="id_hidden" name="id_hidden" value="0">
                            </div>	
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane animated fadeIn" id="Documents">
                <div class="card">
                    <div class="header">
                        <legend>Documents</legend>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center" id="table-documents">
                                <thead class="text-white thead-yasc">
                                    <tr>
                                        <th>Document</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody id = 'document-list'></tbody>
                                @forelse($docs as $doc)
                                <tr>
                                    <td>{{$doc->name}}</td>
                                    <td><button type="button" class="btn btn-sm btn-outline-secondary download" data-toggle="tooltip" title="Download" value="{{$doc->id}}"> <i class="fa fa-download"></i></li></button></td>
                                </tr>
                                @empty
                                <tr id="no-data-doc"><td colspan="2">NO DATA</td></tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>

</div>

             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
        <input type="hidden" id="mat" value="{{$mat}}">
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/profile/AjaxProfile.js')}}"></script>
@endsection