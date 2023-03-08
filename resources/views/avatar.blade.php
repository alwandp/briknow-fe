@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/profile.css')}}">
@endpush

@section('breadcumb', 'Profile / Avatar')
@section('back', route('home.profile'))
@section('id_project', session('avatar_id'))

@section('content')
    <div class="row judul">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 text-center d-flex justify-content-center">
                    <div class="relative">
                        <img draggable='false' alt="image" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" class="rounded-circle ava">
                    </div>
                </div>
                <div class="col-md-10 d-flex align-items-center px-1">
                    <div>
                        <div>
                            <h3 id="nama-kanan">{{$data->name}}</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="pb-2">
                                <span class="font-weight-bold text-black header-direktorat">{{$data->divisis->direktorat == NULL ? 'Lainnya' : $data->divisis->direktorat}}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="pb-2">
                                <img draggable='false' alt="image" src="{{asset_app('assets/img/Group.png')}}" class="img-fluid pr-2">
                                <span><a href="{{url('/')}}/divisi/{{$data->divisis->id}}" id="divisi-kanan" style="text-decoration: none;">{{$data->divisis->divisi}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="w-100 pb-2">

        <div class="col-md-12 p-0">
            <div class="row py-0 px-4 d-flex justify-content-center">
                <div class="row collection-avatar">
                    @foreach($avatar as $item)
                        <div class="col-lg-2 col-md-3 col-sm-6 py-2">
                            <div class="d-flex justify-content-center align-items-center">
                                <img draggable='false' alt="image" src="{{asset_app($item->path)}}" class="rounded-circle {{session('level_id') >= $item->level_id ? 'ava ava-touch' : 'ava-lock'}}  {{session('avatar_id') == $item->id ? 'ava-active' : ''}} relative"  data-id="{{$item->id}}">
                                @if(session('level_id') < $item->level_id)
                                    <div class="avatar-cover">
                                        <div class="text-center">
                                            <i class="fas fa-lock text-white"></i>
                                        </div>
                                        <div class="fs-12 text-center text-white">Reach {{$item->level->name}} to unlock</div>
                                    </div>
                                @endif
                                @if(session('avatar_id') == $item->id)
                                    <div class="avatar-cover checked-avatar">
                                        <div class="text-center">
                                            <i class="fas fa-check text-success" style="font-size:50px;"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row d-flex justify-content-end control px-4 pt-4 pb-3">
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/page/avatar.js')}}"></script>
@endpush