@extends ('welcome')
@section ('content')
<div class="row clearfix">
    <div class="col-lg-12" >
        <div class="card">
            <div class="header">
                <h1 id="labelTitle">home <i class="fa fa-tasks"></i></h1>
                <ul class="header-dropdown">
                    <li><a href="javascript:void(0);" class="btn btn-success" disabled id="btn_add" >Add News <i class="fa fa-plus"></i></a></li>
                </ul>
            </div>
          
            <div class="body">
                
            </div>
        </div>
    </div>

</div>

             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
        <input type="hidden" id="mat" value="ODO">
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/documents/AjaxDocuments.js')}}"></script>
<script src="{{asset('modulos/news/AjaxNews.js')}}"></script>
@endsection