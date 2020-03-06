@extends ('welcome')
@section ('content')
<div class="row clearfix">
    <div class="col-lg-12 col-xl-12 col-xs-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h1>Settings <i class="fa fa-tasks"></i></h1>
                <ul class="header-dropdown">
                    <li><a href="javascript:void(0);" class="btn btn-success" disabled id="btn_add" >New Setting <i class="fa fa-plus"></i></a></li>
                </ul>
            </div><br>
            @include('settings.form')
            <div class="body">
                <div class="input-group mb-3 input-group-sm">
                    <div class="input-group-prepend">
                        <select class="form-control" id="typesearch">
                            <option value="name">Name</option>
                            <option value="option">Option</option>
                            <option value="id">ID</option>
                        </select>
                    </div>
                    <input type="text" class="form-control" id="search">
                    <button type="button" class="btn btn-primary search-query">Search</button>
                </div>
                <div class="table-responsive">
                    @include('settings.table')
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Passing BASE URL to AJAX -->
<input id="url" type="hidden" value="{{ \Request::url() }}">
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/settings/AjaxSettings.js')}}"></script>
@endsection