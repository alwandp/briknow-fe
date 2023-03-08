@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/plugin/load/sklt-load.css')}}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))
@section('csrf',csrf_token())

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Forum</h3>

        <!-- NAVIGASI -->
            <div class="d-flex bd-highlight mb-3">
                <div class="mr-auto p-2 bd-highlight">
                    <a class="btn btn-light btn-sm active" href="{{ route('manageforum_all') }}" role="button">Published</a>
                    <a class="btn btn-light btn-sm" href="{{ route('manageforum_removed') }}" role="button">Removed</a>
                </div>
                    
                <!-- Dropdowns -->
                    <div class="p-2 bd-highlight" id="drop-nama-proyek">
                        <div class="dropdown show">
                            <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort by
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" id="sort-all" onclick="getdatalist()">All Project</a>
                                <a class="dropdown-item" href="#" id="sort-private" onclick="sortPrivate()">Private Only</a>
                                <a class="dropdown-item" href="#" id="sort-public" onclick="sortPublic()">Public Only</a>
                            </div>
                        </div>
                    </div>
                <!-- Dropdowns -->
                
                <!-- Search -->
                    <div class="p-2 bd-highlight" id="search">
                        <form action="#" class="w-100" id="search">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="search">
                                        <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Search Forum.." aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </form>
                    </div>
                <!-- Search -->
            </div>
        <!-- NAVIGASI -->

        <div class="forum-content pb-2">
            
        </div>

        <div class="w-100 d-flex justify-content-end" id="pag">
        </div>
    </div>
</div>
@endsection

@push('page-script')
    <script>
        localStorage.clear();
    </script>
    <script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/manageforum_all.js')}}"></script>
@endpush