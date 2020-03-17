@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h1 id="labelTitle">Reports <i class="fa fa-file-excel-o"></i></h1>
                        </div>

                        <div class="body">
                            <div class="table-responsive table-incident" style="display:none">
                                 @include('reports.search')
                                @include('reports.incidents')
                            </div>
                                
                        </div>
                        
                    </div>
                </div>   
                <div class="col-lg-3 col-md-6 col-sm-12" id = "incident">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Incident</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger"  id = "view-incident">View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "attendance">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Attendance</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view-attendance'>View Report</button>
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
<script src="{{asset('modulos/reports/AjaxReports.js')}}"></script>
@endsection