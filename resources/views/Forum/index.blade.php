@extends('layouts/master_forum')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())
@section('back', route('katalog.index'))

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/plugin/load/sklt-load.css')}}">
@endpush
@section('myforum')
    @forelse ($myData as $myPost)
        <li class="nav-item dropdown border-bottom border-abu p-1">
            <div class="w-100 d-flex align-items-center">
                <div class="p-0 d-flex align-items-center justify-content-center thumb-katalog">
                    <a href="{{route('forum.detail',$myPost->slug)}}" class="text-left menu-kiri d-flex justify-content-center w-100 h-100 text-decoration-none p-0" tabindex="-1" role="button">
                        <img src="{{asset_app($myPost->thumbnail)}}" width="50px" class="card-img-left border-0 rounded thumb">
                    </a>
                </div>
                <div class="w-75 pl-1 content-myforum">
                    <div class="card-body content-project"> 
                        <div class="d-flex justify-content-between align-items-center">
                            <b class="d-block lh-15 mb-1">
                                <a href="{{route('forum.detail',$myPost->slug)}}" class="text-dark text-left text-decoration-none p-0" tabindex="-1" role="button">
                                    {{\Str::limit($myPost->judul,16,'..')}}
                                </a>
                            </b>
                            <div class="dropdown">
                                <button data-toggle="dropdown" class="btn m-0 p-0 dropdown-toggle dropdown-myforum" type="button" id="dropdownMenuButton" aria-expanded="true">
                                    <svg class="w-6 h-6 mx-1 mb-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-myforum" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('forum.edit',$myPost->id)}}">Edit</a>
                                    @if(session('role') == 3)
                                        <a class="dropdown-item" href="#" onclick="hapus({{$myPost->id}})">Remove</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="d-flex align-items-center justify-content-between ven-proj text-secondary w-100">
                            <span>
                                @if ($myPost->restriction == '1')
                                    <svg class="w-6 h-6 mb-1" width="15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                    Private
                                @else
                                    <svg class="w-6 h-6 mb-1" width="15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Public
                                @endif
                            </span>
                            <div>{{\Carbon\carbon::create($myPost->updated_at)->format('d/m/Y')}}</div>
                        </span>
                    </div>
                </div>
            </div>
        </li>
    @empty
        <div class="col-md-12 d-flex justify-content-center mt-5">
            <img src="{{asset_app('assets/img/belum_ada_forum.png')}}" class="w-75" draggable="false" alt="">
        </div>
    @endforelse
@endsection

@section('content')
    <div class="row mb-4 sticky-top head-forum">
        <div class="col-md-12 d-flex">
            <div class="mb-2 mr-auto">
                <h4 class="font-weight-bolder text-dark">Forum Diskusi</h4>
            </div>
            <div class="control border-1 border-0 h-35 c-sm mr-1">
                <button type="button" data-toggle="modal" data-target="#draftlist" class="btn btn-primary border-0 btn-search rounded h-35 px-1 w-100" type="submit" id="button-addon2"><i class="fa fa-file mr-1" aria-hidden="true"></i>Drafts</button>
            </div>
            <div class="control border-1 border-0 h-35 c-sm mr-1">
                <a href="{{route('forum.create')}}" class="btn btn-success border-0 btn-search rounded h-35 px-1 w-100" type="submit" id="button-addon2"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Buat post</a>
            </div>
        </div>
        <div class="col-md-12 px-4">
            <form style="width: 100%" action="#" id="search">
                <div class="w-100 row mx-0">
                    <div class="col-md-8 col-sm-12 input-group control border-1 pencarian border-0 h-35 mb-2 px-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text border-0 h-35"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control main-cari-2iaef input-search border-0 h-35" value="{{isset($kunci) ? $kunci : ''}}" placeholder="Search Thread . . .">
                        <button class="btn btn-info" type="submit" id="button-addon2">Search</button>
                    </div>
                    <div class="col-md-2 control border-1 border-0 h-35 c-lg">
                        <button type="button" data-toggle="modal" data-target="#draftlist" class="btn btn-primary btn-block border-0 btn-search rounded h-35 px-1" type="submit" id="button-addon2"><i class="fa fa-file mr-1" aria-hidden="true"></i>Drafts</button>
                    </div>
                    <div class="col-md-2 control border-1 border-0 h-35 c-lg">
                        <a href="{{route('forum.create')}}" class="btn btn-success btn-block border-0 btn-search rounded h-35 px-1" type="submit" id="button-addon2"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Buat Post</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row px-2 forum-content">
        <div class="col-md-12 sklt mt-2">
            <div class="ph-item border control list-forum mb-2">
                <div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3">
                    <div class="ph-picture w-100"></div>
                </div>
                <div class="content-forum-area">
                    <div class="ph-row h-100">
                        <div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div>
                        <div class="ph-col-4 h-25 mb-2 thumb-lg"></div>
                        <div class="ph-col-12 big"></div>
                        <div class="ph-col-8"></div>
                        <div class="ph-col-6"></div>
                    </div>
                </div>
                <div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg">
                    <div class="ph-picture w-50 h-100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 sklt mt-2">
            <div class="ph-item border control list-forum mb-2">
                <div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3">
                    <div class="ph-picture w-100"></div>
                </div>
                <div class="content-forum-area">
                    <div class="ph-row h-100">
                        <div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div>
                        <div class="ph-col-4 h-25 mb-2 thumb-lg"></div>
                        <div class="ph-col-12 big"></div>
                        <div class="ph-col-8"></div>
                        <div class="ph-col-6"></div>
                    </div>
                </div>
                <div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg">
                    <div class="ph-picture w-50 h-100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 sklt mt-2">
            <div class="ph-item border control list-forum mb-2">
                <div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3">
                    <div class="ph-picture w-100"></div>
                </div>
                <div class="content-forum-area">
                    <div class="ph-row h-100">
                        <div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div>
                        <div class="ph-col-4 h-25 mb-2 thumb-lg"></div>
                        <div class="ph-col-12 big"></div>
                        <div class="ph-col-8"></div>
                        <div class="ph-col-6"></div>
                    </div>
                </div>
                <div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg">
                    <div class="ph-picture w-50 h-100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 sklt mt-2">
            <div class="ph-item border control list-forum mb-2">
                <div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3">
                    <div class="ph-picture w-100"></div>
                </div>
                <div class="content-forum-area">
                    <div class="ph-row h-100">
                        <div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div>
                        <div class="ph-col-4 h-25 mb-2 thumb-lg"></div>
                        <div class="ph-col-12 big"></div>
                        <div class="ph-col-8"></div>
                        <div class="ph-col-6"></div>
                    </div>
                </div>
                <div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg">
                    <div class="ph-picture w-50 h-100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-end" id="pag">
    </div>
@endsection

@section('popup')
    <!-- Modal -->
    <div class="modal fade" id="draftlist" tabindex="-1" role="dialog" aria-labelledby="draftlist" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title" id="exampleModalLongTitle">Pilih Draft</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                @forelse($draft as $item)
                    <div class="border-bottom mb-1 p-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start">
                                <div class="px-2 d-flex align-items-center">
                                    @if($item->kategori == '0')
                                        <i class="fa fa-file fs-18"></i>
                                    @else
                                        <i class="fa fa-link fs-18"></i>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <small class="d-block font-weight-bold lh-12"><a href="{{route('forum.draft',$item->id)}}" class="text-black text-decoration-none">{{\Str::limit($item->judul,30)}}</a></small>
                                        <small class="d-block text-secondary lh-12">{{\Carbon\carbon::create($item->updated_at)->diffForHumans()}}</small>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button onclick="hapus({{$item->id}})" class="btn text-secondary"><i class="fa fa-trash fs-15"></i></button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center">
                        Belum Ada Draft
                    </div>
                @endforelse
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/page/forum.js')}}"></script>
@endpush