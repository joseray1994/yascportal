@extends ('welcome')
@section ('content')
<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h1 id="labelTitle">Reports <i class="fa fa-file-excel-o"></i></h1>
                        </div>
                        
                    </div>
                </div>   
                <div class="col-lg-3 col-md-6 col-sm-12" id = "incident">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Incident</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger"  id = "view-incident">View Incident Report</button>
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
                                <button class="btn btn-sm btn-danger" id = 'view-attendance'>View Attendance Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "focus">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Focus</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "medical_bureau">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Medical Bureau</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "tel_us">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Tel-us</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "speedez">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Speedez</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "etzel">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Etzel</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "call_experts">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Call Experts</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "edwards">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Edwards Ans Svc</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "emerald">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Emerald Coast</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12" id = "global">
                    <div class="card">
                        <div class="body text-center">
                            <div class="chart easy-pie-chart-1" data-percent="75"> <span><img src="../images/logo-yasc.jpeg" alt="user" class="rounded-circle"/></span> </div>
                            <h5>Global Messaging</h5>
                            <div class="m-t-15">
                                <button class="btn btn-sm btn-danger" id = 'view'>View Report</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
@endsection