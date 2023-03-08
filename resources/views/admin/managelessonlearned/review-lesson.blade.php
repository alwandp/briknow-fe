@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/review.css') }}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')

    <div class="row">
        <div class="col-md-12" id="konten">
            <h3 class="pl-2 pt-5">Manage Lesson Learned</h3>
            <div class="d-flex justify-content-start mb-3 px-3">
                <div class="p-2 bd-highlight">
                    <button id="btn-sort-lesson" data-toggle="dropdown"
                    class="btn btn-tahap bg-white dropdown-toggle">
                        All Tahap Proyek
                    </button>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <li onclick="sortByTahap('sortInitLesson')" id="sortInitLesson" data-value="init"
                            class="dropdown-item">All Tahap Proyek</li>
                        <li onclick="sortByTahap('planSort')" id="planSort" data-value="Plan" class="dropdown-item">Plan
                        </li>
                        <li onclick="sortByTahap('procurementSort')" id="procurementSort" data-value="Procurement"
                            class="dropdown-item">Procurement</li>
                        <li onclick="sortByTahap('devSort')" id="devSort" data-value="Development" class="dropdown-item">
                            Development</li>
                        <li onclick="sortByTahap('pilotSort')" id="pilotSort" data-value="Pilot Run" class="dropdown-item">Pilot
                            Run</li>
                        <li onclick="sortByTahap('implSort')" id="implSort" data-value="Implementation"
                            class="dropdown-item">Implementation</li>
                    </ul>
                </div>
            </div>
            <!-- NAVIGASI -->
            <div class="row bd-highlight mb-4">
                <div class="col-6 bd-highlight">
                    <h4 id="main-title-lesson">All</h4>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-4">
                            <div class="bd-highlight">
                                <div class="d-flex justify-content-end w-100">
                                    <select name="direktorat" id="direktorat-lesson-init" onchange="changeDir();" class="form-control text-black select2"
                                        data-live-search="true" style="height: 44px" value="{{ old('direktorat') }}">
                                        <option value="" disabled selected>Pilih Direktorat</option>
                                        @if (empty($direktorat))
                                            <option value="finance" data-value="finance">{{ $dataList ?? 'NOT FOUND' }}</option>
                                        @else
                                            <option value="init" data-value="init">All Direktorat</option>
                                            @foreach ($direktorat as $dirContent)
                                                <option value="{{ $dirContent->direktorat }}" data-value="{{ $dirContent->direktorat }}">
                                                    {{ $dirContent->direktorat }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bd-highlight">
                                <div class="d-flex justify-content-end w-100">
                                    <select id="divisi-lesson-init" class="mr-auto p-2 form-control select2" value="{{ old('divisi') }}" name="divisi[]">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <!-- Search -->
                            <div class="bd-highlight" id="search">
                                <div class="input-group w-100">
                                    <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control" id="searchLessoninit"
                                        placeholder="Cari Project">
                                    <div class="input-group-prepend">
                                        <div onclick="searchLesson()" class="input-group-text"
                                            style="background: #f0f0f0; border-radius: 0 8px 8px 0;">
                                            <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Search -->
                        </div>
                    </div>
                </div>
    
            </div>

            <!-- REVIEW -->
            <div class="mb-5" id="review">
                <div class="card card-lesson w-100 d-flex mb-3">
                    <div class="row">
                        <div class="col-3">
                            <h6>Direktorat</h6>
                        </div>
                        <div class="col-3">
                            <h6>Uker</h6>
                        </div>
                        <div class="col-2">
                            <h6>Nama Project</h6>
                        </div>
                        <div class="col-2">
                            <h6>Konsultan</h6>
                        </div>
                        <div class="col-2">
                            <h6>Action</h6>
                        </div>
                    </div>
                </div>
                {{--                for each --}}
                <div id="container-review">
                </div>
            </div>
            <div class="d-flex justify-content-sm-end content-pagination" id="pag">
            </div>
            <!-- REVIEW -->
        </div>
    </div>
@endsection

@push('page-script')
    <script src="{{ asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset_app('assets/js/page/review-lesson.js') }}"></script>
@endpush
