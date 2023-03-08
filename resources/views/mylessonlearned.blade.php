@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/my_project.css')}}">

@endpush

@section('breadcumb', 'My Lesson Learned')
@section('back', route('home'))

@section('content')
    <div class="row">
        <div class="col-md-12" id="konten">
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                    <h3>My Lesson Learned</h3>
                </div>
                <div class="p-2 bd-highlight">
                    <button id="btn-sort-lesson" data-toggle="dropdown"
                            class="btn btn-filter bg-white dropdown-toggle">
                        All Tahap Proyek
                    </button>
                    @if(request()->segment(count(request()->segments())) === 'mylesson')
                        <ul class="dropdown-menu dropdown-menu-left">
                            <li onclick="sortByTahap('sortInitLesson')" id="sortInitLesson" data-value="init"
                                class="dropdown-item">All Tahap Proyek
                            </li>
                            <li onclick="sortByTahap('planSort')" id="planSort" data-value="Plan" class="dropdown-item">
                                Plan
                            </li>
                            <li onclick="sortByTahap('procurementSort')" id="procurementSort" data-value="Procurement"
                                class="dropdown-item">Procurement
                            </li>
                            <li onclick="sortByTahap('devSort')" id="devSort" data-value="Development"
                                class="dropdown-item">Development
                            </li>
                            <li onclick="sortByTahap('pilotSort')" id="pilotSort" data-value="Pilot" class="dropdown-item">
                                Pilot Run
                            </li>
                            <li onclick="sortByTahap('implSort')" id="implSort" data-value="Implementation"
                                class="dropdown-item">Implementation
                            </li>
                        </ul>
                    @else
                        <ul class="dropdown-menu dropdown-menu-left">
                            <li id="sortInitLesson" data-value="init"
                                class="dropdown-item">{{request()->segment(count(request()->segments()))}}
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="p-2 bd-highlight bd-highlight" style="width: 15%">
                    <div class="d-flex justify-content-end">
                        <select name="direktorat" id="direktorat-lesson-init" onchange="changeDirec();"  class="form-control text-black select2" data-live-search="true"
                                style="height: 44px" value="{{old('direktorat')}}">
                            <option value="" disabled selected>Pilih Direktorat</option>
                            @if(empty($direktorat))
                                <option value="finance" data-value="finance">{{$dataList ?? 'NOT FOUND'}}</option>
                            @else
                                <option value="unselect" data-value="unselect">All Direktorat</option>
                                @foreach($direktorat as $dirContent)
                                    <option value="{{$dirContent->direktorat }}" data-value="{{ $dirContent->direktorat }}">{{$dirContent->direktorat}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="p-2 bd-highlight bd-highlight" style="width: 15%">
                    <div class="d-flex justify-content-end">
                        <select id="divisi-lesson-init" class="mr-auto p-2 form-control select2" value="{{old('divisi')}}" name="divisi[]"></select>
                    </div>
                </div>
            </div>
            <!-- NAVIGASI -->
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                    <h4 id="main-title-lesson">All</h4>
                </div>

                <div class="p-2 bd-highlight" id="search">
                    <div class="input-group w-100">
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control"
                            id="searchLessoninit" placeholder="Search by Nama Project">
                        <div class="input-group-prepend">
                            <div onclick="searchLesson()" class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;">
                                <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- REVIEW -->
            <div class="table-responsive" id="review">
                <div class="card card-body w-100 d-flex mb-4" style="border-radius: 10px">
                    <div class="row">
                        <div class="col-3">
                            <h6>Direktorat</h6>
                        </div>
                        <div class="col-3">
                            <h6>Uker</h6>
                        </div>
                        <div class="col-3">
                            <h6>Nama Project</h6>
                        </div>
                        <div class="col-2">
                            <h6>Konsultan</h6>
                        </div>
                        <div class="col-1">
                            <h6>Action</h6>
                        </div>
                    </div>
                </div>
                {{--                for each--}}
                <div id="container-lesson">
                </div>
                <div class="d-flex justify-content-sm-end content-pagination" id="pag">
                </div>
            </div>
            <!-- REVIEW -->
        </div>
    </div>

@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/public-lesson.js')}}"></script>
@endpush
