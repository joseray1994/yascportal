@extends ('welcome')
@section ('content')
<div class="row clearfix">
    <div class="col-lg-12" >
        <div class="card">
            <!-- <div class="header">
                <h1 id="labelTitle">Dashboard</h1>
                <hr>
            </div> -->
            <div class="body row">
                <div class="col-md-2 col-sm-12">
                    <h2>Birthday</h2>
                </div>
                <div class="col-md-6 col-sm-12" id="news" style="max-height:75vh; overflow-y: scroll;">
                    @forelse($data as $news)
                        <div class="card single_post ">
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
                                        @foreach($likes as $like)
                                            @if($news->id ==  $like['id_news'])
                                                <li><button class="icon-heart btn-like btn btn-secondary" onclick="addLike('{{$news->id}}')"> <span>{{$like['likes']}}</span></button></li>
                                            @endif
                                        @endforeach

                                        
                                    @if($news->status == 1)
                                        @foreach($comments as $comment)
                                            @if($news->id ==  $comment['id_news'])
                                                <li><button class="icon-bubbles btn-comments btn btn-secondary" onclick="toggleComments('{{$news->id}}')"> <span>{{$comment['comments']}}</span> </button></li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="card section-comment{{$news->id}}" style="display:none">
                                <div class="header">
                                    <h2 id="totalComments{{$news->id}}"></h2>
                                </div>
                                <div class="body" >
                                    <ul class="comment-reply list-unstyled more2" id="comments{{$news->id}}">
                                        
                                    </ul>                                        
                                </div>
                            </div>
                            <div class="card section-comment{{$news->id}}" style="display:none">
                                <div class="body">
                                    <ul class="comment-reply list-unstyled">
                                        <li class="row d-flex align-items-start">
                                            <div class="icon-box col-md-1 col-4">
                                                <div class="icon">
                                                    <img src="{{asset($menu['dataUser']->path_image)}}" class="rounded-lg user-photo" style="max-width:40px" alt="user_picture">
                                                </div>
                                            </div>
                                            <div class="text-box col-md-11 col-8 p-l-0 p-r0">
                                                <textarea name="description-comment" id="inputComment{{$news->id}}" class="form-control" placeholder="Please type what you think..."></textarea>
                                            </div>
                                        </li>  
                                    </ul> 
                                    <div class="form-group text-right">
                                        <button class="btn btn-success btn-save-comment" onclick="addComment('{{$news->id}}')">Post</button>
                                    </div>
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
                <div class="col-md-2 col-sm-12">
                    <h2>Reminders</h2>
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