@extends('layouts.master')
@section('title', 'BRIKNOW FORUM')
@section('csrf',csrf_token())
@push('style')
    <meta name="BE" content="{{ config('app.url_be') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-forum-detail.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}" />
@endpush
@section('breadcumb', 'Forum')
@section('back', route('forum.index'))
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- POSTINGAN -->
            <div class="col-md-9 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body p-3">
                                <div class="w-100 mb-4">
                                    <div class="row col-md-12">
                                        <span id="judul-detail" class="mt-2">{{$data->judul}}</span>
                                    </div>
                                    <div class="row col-md-12 d-flex justify-content-between">
                                        <div>
                                            <small id="date-detail">{{\Carbon\Carbon::create($data->created_at)->format('d/m/Y')}}</small>
                                        </div>
                                        <div>
                                            <small>
                                                <a href="#comment-section" class="text-decoration-none text-secondary"><i class="fas fa-comment-alt mr-1"></i>{{$data->forumcomment_count}} Comments</a>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-justify pl-2" style="min-height: 210`px;">
                                    {!! $data->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="comment-section">
                    <div class="col-md-12">
                        <!-- COMMENT POST -->
                            <div class="card shadow">
                                <div class="loadercomment" id="loader">
                                    <div class="loading">
                                        <img src="{{asset_app('assets/img/loading.gif')}}" width="60px" draggable="false" alt="">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="px-0 py-0">
                                        <form action="#" onsubmit="komen(event,this,'',{{$data->id}},'','');">
                                            @csrf
                                            <textarea class="w-100" name="comment" id="editor-comment" placeholder="Tulis komentar"></textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <!-- END -->
                    </div>
                    <div class="w-100 comment-area">
                        <?php $urut = 0; ?>
                        @forelse ($data->forumcomment as $value)
                            <?php $urut++; ?>
                            <div class="col-md-12" id="comment-{{$urut}}">
                                <!-- KOMENTAR 1 -->
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 text-left pt-2">
                                                    <div class="profile-comment d-flex align-items-center">
                                                        <a href="{{route('home.profileuser',$value->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                                                            @php $tempava = $value->user->avatar_id; @endphp
                                                            <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" width="40px" class="rounded-circle p-0 mr-2 detail-ava">
                                                            <label class="font-weight-bolder mb-0">{{$value->user->name}}</label> &middot;
                                                            <small class="text-secondary">{{\Carbon\Carbon::create($value->created_at)->diffForHumans()}}</small>
                                                        </a>
                                                    </div>
                                                    <div class="subforum w-100">
                                                        <div class="py-2 text-justify">
                                                            {!!$value->comment??'-'!!}
                                                        </div>
                                                        <div class="px-0 w-100 d-flex justify-content-between reply-{{$urut}}">
                                                            <div>
                                                                @if(count($value->child) > 0)
                                                                    <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut}}" onclick="showc('comment-{{$urut}}');">
                                                                    <span class="label-handle-comment-{{$urut}}">
                                                                        <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value->child)??0}} Replies
                                                                    </span>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            <button class="btn bg-white px-0 reply{{$urut}}" onclick="reply(this);" id="{{$urut}}" data-parent="{{$value->id}}" data-prj="{{$data->id}}" data-reply="{{$value->user->personal_number}}" style="text-decoration: none;">Reply</button>
                                                        </div>

                                                        {{-- sub comment --}}
                                                        <?php $urut2 = $urut; ?>
                                                        @forelse($value->child as $value2)
                                                            <?php $urut2++; ?>
                                                            <div class="w-100 sub-comment-{{$urut}} comment-{{$urut2}} d-n">
                                                                <div class="profile-comment d-flex align-items-center">
                                                                    <a href="{{route('home.profileuser',$value2->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                                                                        @php $tempava = $value2->user->avatar_id; @endphp
                                                                        <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" width="40px" class="rounded-circle p-0 mr-2 detail-ava">
                                                                        <label class="font-weight-bolder mb-0">{{$value2->user->name}}</label> &middot;
                                                                        <small class="text-secondary">{{\Carbon\Carbon::create($value2->created_at)->diffForHumans()}}</small>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="subforum sub-comment-{{$urut}} comment-{{$urut2}} d-n w-100">
                                                                <div class="py-2 text-justify comment-sub-1">
                                                                    {!!$value2->comment??'-'!!}
                                                                </div>
                                                                <div class="px-0 w-100 d-flex justify-content-between reply-sub-1 reply-{{$urut2}}">
                                                                    <div>
                                                                        @if(count($value2->child) > 0)
                                                                            <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut2}}" onclick="showc('comment-{{$urut2}}');">
                                                                            <span class="label-handle-comment-{{$urut2}}">
                                                                                <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value2->child)??0}} Replies
                                                                            </span>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                    <button class="btn bg-white px-0 reply{{$urut2}}" onclick="reply(this);" id="{{$urut2}}" data-parent="{{$value2->id}}" data-prj="{{$data->id}}" data-reply="{{$value2->user->personal_number}}" style="text-decoration: none;">Reply</button>
                                                                </div>
                                                                
                                                                <?php $urut3 = $urut2; ?>
                                                                    @forelse($value2->child as $value3)
                                                                        <?php $urut3++; ?>
                                                                        <div class="w-100 sub-comment-{{$urut2}} comment-{{$urut3}} d-n">
                                                                            <div class="profile-comment d-flex align-items-center">
                                                                                <a href="{{route('home.profileuser',$value3->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                                                                                    @php $tempava = $value3->user->avatar_id; @endphp
                                                                                    <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" width="40px" class="rounded-circle p-0 mr-2 detail-ava">
                                                                                    <label class="font-weight-bolder mb-0">{{$value3->user->name}}</label> &middot;
                                                                                    <small class="text-secondary">{{\Carbon\Carbon::create($value3->created_at)->diffForHumans()}}</small>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="subforum sub-comment-{{$urut2}} comment-{{$urut3}} d-n">
                                                                            <div class="py-2 text-justify comment-sub-2">
                                                                                {!!$value3->comment??'-'!!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="px-0 w-100 d-flex justify-content-between reply-sub-2 reply-{{$urut3}}">
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                    @empty
                                                                    @endforelse
                                                                <?php $urut2 = $urut3; ?>
                                                            </div>
                                                        @empty
                                                        @endforelse
                                                        {{-- /sub comment --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- END -->
                            <?php $urut = $urut2; ?>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- PROFILE SISI KANAN -->
            <div class="col-md-3 col-sm-12 px-0">
                <div class="row mx-0">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body p-2">
                                <div class="row mx-0">
                                    <div class="col-lg-2 col-md-12 col-sm-12 d-flex align-items-center justify-content-center text-center">
                                        @php 
                                            $tempava    = $data->user->avatar_id; 
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-center text-center">
                                            <a href="{{route('home.profileuser',$data->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                                                <div class="d-block position-static">
                                                    <img draggable='false' alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" class="rounded-circle ava-frame ava-profile position-absolute w-75">
                                                    @isset($level)
                                                        @if($level <> 1)
                                                            <img draggable='false' alt="image" src="{{asset_app("assets/img/frame/".$level.".png")}}" class="ava-profile position-relative">
                                                        @endif
                                                    @endisset
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 d-flex align-items-center forum-profile-user">
                                        <div>
                                            <div>
                                                <a href="{{route('home.profileuser',$data->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                                                    <span id="nama-kanan" class="font-weight-bold">{{$data->user->name}}</span>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{route('divisi',$data->user->divisis->id)}}" id="divisi-kanan" style="text-decoration: none;">{{\Str::limit($data->user->divisis->divisi,25)}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- MEDALS -->
                        <div class="card shadow">
                            <div class="d-flex justify-content-center text-center flex-wrap p-2">
                                @forelse($data->user->achievement as $item)
                                    <img draggable='false' width="40px" height="40px" src="{{asset_app($item->achievement->badge)}}" class="mx-2 my-2 badges" data-toggle="tooltip" data-placement="top" title="{{$item->achievement->activity->name}} Sebanyak {{$item->achievement->value}} Kali" alt="{{$item->achievement->activity->name}} Sebanyak {{$item->achievement->value}} Kali">
                                @empty
                                    <div class="w-100">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img draggable='false' width="40px" height="40px" alt="image" src="{{asset_app('assets/img/bx_bxs-trophy.png')}}" class="badges">
                                        </div>
                                        <div class="d-flex  justify-content-center  align-items-center">
                                            <b><i>No Achievements</i></b>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <!-- END MEDALS -->
                    </div>
                </div>
            </div>
            <!-- END -->
        <!-- END -->
    </div>
</div>
@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/plugin/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset_app('assets/js/page/forum-detail.js')}}"></script>
@endpush
