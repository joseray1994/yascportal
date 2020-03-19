@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h1 id="labelTitle">Clients <i class="fa fa-suitcase"></i></h1>
                            <ul class="header-dropdown">
                               <li style = "display:none" class = "btn-back"><a href="javascript:void(0);" class="btn btn-secondary">Back </a></li>
                                <li><a href="javascript:void(0);" class="btn btn-success" disabled id="btn_add" >New Client <i class="fa fa-plus"></i></a></li>
                            </ul>
                        </div>
                        
                        <!--Container de tabla clientes-->    
                        <div class="body tableClient"> 
                        <div class="input-group mb-3 input-group-sm">
                                    <div class="input-group-prepend">
                                        <select class="form-control" id="typesearch">
                                            <option value="name">Name</option>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control" id="search">
                                    <button type="button" class="btn btn-primary search-query"><i class="fa fa-search"></i></button>
                                </div>
                                <div class="table-responsive"  >
                                 @include('clients.table')
                                </div>
                                <div class="loading-table col-sm-12 text-center">
                                        <div class="spinner-grow text-success"></div>
                                        <div class="spinner-grow text-info"></div>
                                        <div class="spinner-grow text-warning"></div>
                                        <div class="spinner-grow text-danger"></div>
                                </div>


                            </div>
                            @include('clients.form')
                              @include('clients.form_contacts')
                        </div>
                    </div>
                </div>
</div>


             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
        <input type="hidden" id="mat" value="CDO">
        @include('documents.modal')
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/documents/AjaxDocuments.js')}}"></script>
<script src="{{asset('modulos/clients/AjaxClients.js')}}"></script>
@endsection