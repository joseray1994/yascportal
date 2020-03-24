@extends ('welcome')
@section ('content')
<div class="row clearfix">
    <div class="col-lg-12" >
        <div class="card">
            <div class="header">
                <h1 id="labelTitle">Dashboard</h1>
                <hr>
            </div>
            <div class="body">
                <div class="col-lg-6 col-md-12 col-sm-12 left-box">
                    @forelse($data as $news)
                        <div class="card single_post">
                            <div class="body">
                                <div class="img-post">
                                    <img class="d-block img-fluid" src="{{$news->path}}" alt="First slide">
                                </div>
                                <h3>{{$news->title}}</h3>
                                <div id="more{{$news->id}}" style="display:none">
                                    <p>{!!$news->description!!}</p>
                                </div>
                                <button onclick="toggleDescription('{{$news->id}}')" type="button" class="btn btn-link"><span id="titleBtnRead{{$news->id}}">Read More</span></button>
                            </div>
                            <div class="footer">
                                <ul class="stats">
                                    <li><button class="icon-heart btn-like btn btn-secondary" value="{{$news->id}}"> <span>28</span></button></li>
                                    <li><button class="icon-bubbles btn-comments btn btn-secondary" onclick="toggleComments('{{$news->id}}')"> <span>123</span> </button></li>
                                </ul>
                            </div>
                            <div class="card section-comment" style="display:none">
                                <div class="header">
                                    <h2>Comments 3</h2>
                                </div>
                                <div class="body" >
                                    <ul class="comment-reply list-unstyled more2">
                                        <li class="row clearfix">
                                            <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="{{asset('images/sm/avatar3.jpg')}}" alt="Awesome Image"></div>
                                            <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                                <h5 class="m-b-0">Gigi Hadid </h5>
                                                <p>Why are there so many tutorials on how to decouple WordPress? how fast and easy it is to get it running (and keep it running!) and its massive ecosystem. </p>
                                                <ul class="list-inline">
                                                    <li><a href="javascript:void(0);">Mar 09 2018</a></li>
                                                    <li><a href="javascript:void(0);">Reply</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>                                        
                                </div>
                            </div>
                            <div class="card section-comment" style="display:none">
                                <div class="body">
                                    <ul class="comment-reply list-unstyled">
                                        <li class="row clearfix">
                                            <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="{{asset('images/sm/avatar2.jpg')}}" alt="Awesome Image"></div>
                                            <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                            <textarea name="description-comment" id="inputComment{{$news->id}}" class="form-control" placeholder="Please type what you think..."></textarea>
                                            </div>
                                        </li>  
                                    </ul>        
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-success btn-save-comment">Post</button>
                                </div>
                            </div>
                            
                        </div>
                    @empty
                        <div class="card single_post">
                            <div class="body">
                                <h3>No News</h3>
                            </div>
                        </div>
                    @endforelse
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
<script src="{{asset('modulos/dashboard/AjaxDashboard.js')}}"></script>
@endsection