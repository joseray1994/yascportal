@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12 view-index">
                    <div class="card">
                        <div class="header">
                            <h1>Schedule Weekly <i class="fa fa-calendar"></i></h1>
                            <ul class="header-dropdown">
                                <li><button id="csv" class="btn btn-info">TO CSV</button></li>
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="sel1 col-sm-2">Select Day:</label>
                                <select class="form-control col-sm-2 scheduleWeeklySearch" id="daySearch">
                                    <option value="allDays">All days</option>
                                    @foreach ($days as $item)
                                        <option value="{{ $item['id'] }}" {{ ( $item['id']== $NoD) ? 'selected' : '' }}> {{$item['Eng-name']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="body">
                                 @include('schedule.weekly.search')
                                <div class="table-responsive myScroll"  style="max-height:65vh; overflow: scroll;">
                                    @include('schedule.weekly.table')
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
            @include('schedule.weekly.form')
            @include('schedule.modal-suspended')
            @include('schedule.detail')
            @include('schedule.suspended')
          

             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="da" type="hidden" value="">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/schedule/AjaxScheduleweekly.js')}}"></script>
<script src="{{asset('modulos/documents/tableHTMLExport.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
@endsection