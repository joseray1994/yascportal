@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h1>Inventory <i class="fa fa-tasks"></i></h1>
                        </div>
                        @include('inventory.form')
                        <div class="body">
                                <div class="input-group mb-3 input-group-sm">
                                    <div class="input-group-prepend">
                                        <select class="form-control" id="typesearch">
                                            <option value="name">name</option>
                                            <option value="id">id</option>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" id="search">
                                    <button type="button" class="btn btn-primary search-query">Search</button>
                                </div>
                                <div class="table-responsive">
                                 @include('inventory.table')
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
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/inventory/AjaxInventory.js')}}"></script>
@endsection


