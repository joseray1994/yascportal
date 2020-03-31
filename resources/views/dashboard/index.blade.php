@extends ('welcome')
@section ('content')
<div class="row clearfix">
    <div class="col-lg-12" >
        <div class="row clearfix">
            <div class="col-md-2 col-sm-12">
                <div class="card">
                <h2>Birthday</h2>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 myScroll" style="max-height:75vh; overflow-y: scroll;">
                <div class="gallery b4gallery" style="display:none;">
                </div>
                @forelse($data as $news)
                    <div class="card single_post" >
                        <div class="header" id="news{{$news->id}}">
                            <div class="icon-box col-md-12 col-4">
                                <legend>{{$news->title}}</legend>
                                <div class="icon">
                                    <img src="{{$news->path_image}}" class="rounded-lg user-photo" style="max-width:40px" alt="user_picture">
                                    <span>{{$news->nickname}} -  {{$news->created_at}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="img-post">
                                <img  class="gallery-item d-block img-fluid" src="{{$news->path}}" alt="picture" />
                            </div>
                            <h5 class="mx-5">{{$news->title}}</h5>
                            <div id="more{{$news->id}}" style="display:none">
                                <p>{!!$news->description!!}</p>
                            </div>
                            <button onclick="toggleDescription('{{$news->id}}')" type="button" class="btn btn-link"><span id="titleBtnRead{{$news->id}}">Read More...</span></button>
                        </div>
                        <div class="footer" id="comment{{$news->id}}">
                            <ul class="stats my-2">
                                    @foreach($likes as $like)
                                        @if($news->id ==  $like['id_news'])
                                            @if($like['flagLike'])
                                                <li><button class="icon-heart btn btn-danger" id="btnLikes{{$news->id}}" onclick="addLike('{{$news->id}}')"> <span id="countLikes{{$news->id}}">{{$like['likes']}}</span></button></li>
                                            @else
                                                <li><button class="icon-heart btn btn-secondary" id="btnLikes{{$news->id}}" onclick="addLike('{{$news->id}}')"> <span id="countLikes{{$news->id}}">{{$like['likes']}}</span></button></li>
                                            @endif
                                        @endif
                                    @endforeach

                                    
                                @if($news->status == 1)
                                    @foreach($comments as $comment)
                                        @if($news->id ==  $comment['id_news'])
                                            <li><button class="icon-bubbles btn-comments btn btn-secondary" onclick="toggleComments('{{$news->id}}')"> <span id="totalCommentsLabel{{$news->id}}">{{$comment['comments']}}</span> </button></li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="section-comment{{$news->id}}" style="display:none">
                        <hr>
                            <div class="header">
                                <h2 id="totalComments{{$news->id}}"></h2>
                            </div>
                            <div class="body myScrollComments" style="max-height:40vh; overflow: scroll;">
                                <ul class="comment-reply list-unstyled more2" id="comments{{$news->id}}">
                                    
                                </ul>                                        
                            </div>
                        </div>
                        <div class="loading-comments text-center" style="display:none">
                            <div class="spinner-grow text-success"></div>
                            <div class="spinner-grow text-info"></div>
                            <div class="spinner-grow text-warning"></div>
                            <div class="spinner-grow text-danger"></div>
                        </div>
                        <div class="section-comment{{$news->id}}" style="display:none">
                            <div class="body">
                                <ul class="comment-reply list-unstyled">
                                    <li class="row d-flex align-items-start">
                                        <div class="icon-box col-md-1 col-4">
                                            <div class="icon">
                                                <img src="{{asset($menu['dataUser']->path_image)}}" class="rounded-lg user-photo" style="max-width:40px" alt="user_picture">
                                            </div>
                                        </div>
                                        <div class="text-box col-md-11 col-8 p-l-0 p-r0">
                                            <textarea name="description-comment" id="inputComment{{$news->id}}" class="form-control" placeholder="Please type what you think..." style="max-height:100px"></textarea>
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
                <div class="card">
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
<script src="{{asset('/vendor/LightboxGallery/mauGallery.min.js')}}"></script>
<script src="{{asset('/vendor/LightboxGallery/scripts.js')}}"></script>
@endsection