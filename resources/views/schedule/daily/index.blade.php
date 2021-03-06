@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12">
                   @include('schedule.daily.search') 
                </div>
                <div class="col-lg-8" style="height:100vh">
                    <div class="card">
                        <div class="body">
                            <h4 id="titledaily">{{$day['Eng-name']}} {{$date}}<i class="fa fa-tasks"></i></h4>
                            <div class="table-responsive myScroll" style="max-height:65vh; overflow-x: scroll;">
                              @include('schedule.daily.table')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" >
                    <div class="card myScroll" style="max-height:32vh; overflow-x: scroll;">
                        <div class="body">
                        <h4>Day off <i class="fa fa-tasks"></i></h4>
                                <div class="table-responsive">
                              @include('schedule.daily.dayoff')
                            </div>
                        </div>
                    </div>
                    <div class="card myScroll" style="max-height:33vh; overflow-x: scroll;">
                        <div class="body">
                        <h4>Break & Lunch <i class="fa fa-tasks"></i></h4>
                                <div class="table-responsive">
                              @include('schedule.daily.break')
                            </div>
                        </div>
                    </div>
                </div>
</div>
            @include('schedule.daily.form')
             <!-- Passing BASE URL to AJAX -->
        <input id="url" type="hidden" value="{{ \Request::url() }}">
        <input id="baseUrl" type="hidden" value="{{ \Request::root() }}">
@endsection
@section('script')
<script src="{{asset('modulos/ajaxscript_actions.js')}}"></script>
<script src="{{asset('modulos/schedule/AjaxScheduledaily.js')}}"></script>
@endsection