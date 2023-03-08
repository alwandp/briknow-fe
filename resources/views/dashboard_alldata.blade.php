@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('katalog.index'))

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">

        <!-- BUTTONS -->
        <div class="d-flex justify-content-between">
            <div class="my-3 d-flex flex-wrap">
                <a href="{{route('dashboard.performance')}}" class="btn btn-outline-primary mt-2 mr-3" id="performance" role="button">Performance</a>
                <a href="{{route('dashboard.alldata')}}" class="btn btn-outline-primary mt-2 mr-3 active" id="alldata" role="button">All Data</a>
                <a href="{{route('dashboard.comsuport')}}" class="btn btn-outline-primary mt-2 mr-3" id="comsuport" role="button">Communication Suppport</a>
            </div>

            <div class="my-3 d-flex flex-wrap">
                <a href="#" class="btn btn-outline-primary mt-2 mr-3" id="dropdownMenuLink" style="text-decoration: none;"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Download<i class="fa fa-caret-down" style="margin-left: 1rem !important;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                    <a href="{{route('laporan.alldataexcel')}}" target="_blank" class="btn dropdown-item">
                        <i class="far fa-file-excel mr-2"></i>Xlsx
                    </a>
                    <a href="{{route('laporan.alldatapdf')}}" target="_blank" class="btn dropdown-item">
                        <i class="far fa-file-pdf mr-2"></i>PDF
                    </a>
                </div>
            </div>
        </div>
        <!-- END BUTTONS -->

        <!-- CHART 1 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="graph_visitor">
                        <div class="card-body px-4 pb-0">
                            <div class="row d-flex justify-content-between">
                                <h6>Overview</h6>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('dashboard.exxlprojectvisitor')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('dashboard.expdfprojectvisitor')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <hr class="d-block mt-0 mb-2 m-0 garis-bawah" style="width:10%;">
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 d-flex flex-row">
                                    <div class="pr-2">
                                        <h1 id="count_visitor_today">{{$raw->today??'-'}}</h1>
                                    </div>
                                    <div class="pr-2">
                                        <div class="pt-1">
                                            Pengunjung<br>
                                            hari ini
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 d-flex flex-row">
                                    <div class="pr-2">
                                        <h1 id="count_visitor_30">{{$raw->last30??'-'}}</h1>
                                    </div>
                                    <div class="pr-2">
                                        <div class="pt-1">
                                            Pengunjung<br>
                                            30 hari terakhir
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END CHART 1 -->

        <div class="row">
            <!-- Most USER -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="pb-2">
                                <h6>User Paling Banyak Mengakses</h6>
                                <hr id='waow'>
                            </div>
                            @php
                                $i = 1;
                                $x = count($most) + 1;
                                $y = count($most) + 1;
                            @endphp
                            @forelse ($most as $item)
                                <hr>
                                <div class="d-flex">
                                    <div class="pr-2">
                                        <span class="font-weight-bold">{{$i++}}</span>
                                    </div>
                                    <div class="pr-2">
                                        <span class="font-weight-bold">{{$item->name??"-"}}</span>
                                    </div>
                                    <div class="ml-auto pr-2">
                                        <span>{{$item->user->divisi->shortname??"-"}}</span>
                                    </div>
                                </div>
                            @empty

                            @endforelse
                            @while ($x <= 10)
                                <hr>
                                <div class="d-flex">
                                    <div class="pr-2">
                                        <span class="font-weight-bold">{{$x++}}</span>
                                    </div>
                                    <div class="pr-2">
                                        <span class="text-secondary font-italic">Empty</span>
                                    </div>
                                </div>
                            @endwhile
                        </div>
                    </div>
                </div>
            <!-- End Most USER -->

            <!-- Most UKER -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="pb-2">
                                <h6>Uker Paling Banyak Mengakses</h6>
                                <hr id='waow'>
                            </div>
                            @php
                                $y = 1;
                            @endphp
                            @forelse ($mostUk as $item)
                                <hr>
                                <div class="d-flex">
                                    <div class="pr-2">
                                        <span class="font-weight-bold">{{$y++}}</span>
                                    </div>
                                    <div class="pr-2">
                                        <span class="font-weight-bold">{{$item->shortname??"-"}}</span>
                                    </div>
                                </div>
                            @empty

                            @endforelse
                            @while ($y <= 10)
                                <hr>
                                <div class="d-flex">
                                    <div class="pr-2">
                                        <span class="font-weight-bold">{{$y++}}</span>
                                    </div>
                                    <div class="pr-2">
                                        <span class="text-secondary font-italic">Empty</span>
                                    </div>
                                </div>
                            @endwhile
                        </div>
                    </div>
                </div>
            <!-- End Most UKER -->
        </div>

        <!-- CHART 2 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="graph_projectK">
                        <div class="card-body px-4 pb-0">
                            <div class="row d-flex justify-content-between">
                                <h6>Proyek per Konsultan/Vendor</h6>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('dashboard.exxlprojectkonsultant')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('dashboard.expdfprojectkonsultant')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <hr class="d-block mt-0 mb-2 m-0 garis-bawah" style="width:10%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END CHART 2 -->

        <!-- CHART 3 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="graph_projectD">
                        <div class="card-body px-4 pb-0">
                            <div class="row d-flex justify-content-between">
                                <h6>Proyek per Divisi</h6>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('dashboard.exxlprojectdivisi')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('dashboard.expdfprojectdivisi')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <hr class="d-block mt-0 mb-2 m-0 garis-bawah" style="width:10%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END CHART 3 -->

        <!-- CHART 4 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card" id="graph_projectT">
                        <div class="card-body px-4 pb-0">
                            <div class="row d-flex justify-content-between">
                                <div class="pb-3">
                                    <h6>Proyek per Tahun</h6>
                                    <hr id='waow'>
                                </div>
                                <div class="pb-3">
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('dashboard.exxlpertahun')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('dashboard.expdfpertahun')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END CHART 4 -->
    </div>
</div>

@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/core.js')}}" ></script>
    <script src="{{asset_app('assets/js/charts.js')}}" ></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}" ></script>
    <script src="{{asset_app('assets/js/script/dashboard.js')}}"></script>
@endpush
