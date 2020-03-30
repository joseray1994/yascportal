@extends ('welcome')
@section ('content')
<div class="row clearfix">
          <div class="col-sm-12">
                  <div class="header">
                      <h1 id="labelTitle">Reminder <i class="fa  fa-file-text-o"></i></h1>
                  </div>
            
          </div>   
          <div class="col-sm-6">
            <div class="card">
                    <div class="body tableZoom"> 
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
                            @include('reminder.table')
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

          <div class="col-sm-6">
            <div class="card">
              <div class="body "> 
              @include('reminder.form')     
              </div>
            </div>
          </div>
</div>

             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
        <input type="hidden" id="mat" value="RMD">
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/reminder/AjaxReminder.js')}}"></script>
@endsection