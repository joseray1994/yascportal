@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h1><a href="javascript:window.history.back();" data-toggle="tooltip" title="Regresar a Vacancies"><i class="fa fa-arrow-left"></i></a><label style="padding-right:20px; padding-left:20px;">Candidates <i class="fa fa-users"></i></label></h1>

                            <ul class="header-dropdown">
                                <li><a href="javascript:void(0);" class="btn btn-success" disabled id="btn_add" >New Candidate <i class="fa fa-plus"></i></a></li>
                            </ul>
                        </div>
                        @include('candidates.form')
                       
                        <div class="body">
                                <div class="input-group mb-3 input-group-sm">
                                    <div class="input-group-prepend">
                                        <select class="form-control" id="typesearch">
                                            <option value="name">name</option>
                                            <option value="mail">Email</option>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" id="search">
                                    <button type="button" class="btn btn-primary search-query">Search</button>
                                </div>
                                <div class="table-responsive">
                                 @include('candidates.table')
                                </div>
                                <div class="loading-table col-sm-12 text-center">
                                        <div class="spinner-grow text-success"></div>
                                        <div class="spinner-grow text-info"></div>
                                        <div class="spinner-grow text-warning"></div>
                                        <div class="spinner-grow text-danger"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
           
             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
        <input type="hidden" id="mat" value="CAD">
        @include('candidates.detail')
        @include('documents.modal')
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/candidates/AjaxCandidate.js')}}"></script>
<script src="{{asset('modulos/documents/AjaxDocuments.js')}}"></script>
@endsection