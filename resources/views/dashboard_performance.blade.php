@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <style>
        #waow{
            border: solid rgba(47, 128, 237, 1);
            max-width: 85px;
            margin: 0;
        }
    </style>
@endpush

@section('breadcumb', 'Admin')
@section('back', route('katalog.index'))

@section('content')

<div class="row mx-0">
    <div class="col-md-12" id="konten">
        <!-- BUTTONS -->
        <div class="d-flex justify-content-between">
            <div class="my-3 d-flex flex-wrap">
                <a href="{{route('dashboard.performance')}}" class="btn btn-outline-primary mt-2 mr-3 active" id="performance" role="button">Performance</a>
                <a href="{{route('dashboard.alldata')}}" class="btn btn-outline-primary mt-2 mr-3" id="alldata" role="button">All Data</a>
                <a href="{{route('dashboard.comsuport')}}" class="btn btn-outline-primary mt-2 mr-3" id="comsuport" role="button">Communication Suppport</a>
            </div>

            <div class="my-3 d-flex flex-wrap">
                <a href="#" class="btn btn-outline-primary mt-2 mr-3" id="dropdownMenuLink" style="text-decoration: none;"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Download<i class="fa fa-caret-down" style="margin-left: 1rem !important;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                    <a href="{{route('laporan.allexcel')}}" target="_blank" class="btn dropdown-item">
                        <i class="far fa-file-excel mr-2"></i>Xlsx
                    </a>
                    <a href="{{route('laporan.allpdf')}}" target="_blank" class="btn dropdown-item">
                        <i class="far fa-file-pdf mr-2"></i>PDF
                    </a>
                </div>
            </div>
        </div>
        <!-- END BUTTONS -->

        <div class="row">
            <!-- Most Project -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body px-4 pb-0">
                            <div class="row d-flex justify-content-between">
                                <h6>Proyek Paling Banyak Dicari</h6>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('laporan.proyektop5')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('laporan.proyektop5pdf')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row  pb-3">
                                <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                            </div>
                            <div id="graph2" class="d-flex align-items-center justify-content-center" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            <!-- End Most Project -->

            <!-- Most Consultant -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body px-4 pb-0">
                            <div class="row d-flex justify-content-between">
                                <h6>Konsultan/Vendor Paling Banyak Dicari</h6>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('laporan.vendortop5')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('laporan.vendortop5pdf')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row  pb-3">
                                <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                            </div>
                            <div id="graph" class="d-flex align-items-center justify-content-center" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            <!-- End Most Consultant -->
        </div>

        <!-- data lesson learned & communication support-->
        <div class="row">
            <!-- lesson learned -->
            <div class="col-md-12">
                <h4>Lesson Learned Analytics</h4>
                <hr/>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body px-4 pb-0">
                        <div class="row d-flex justify-content-between">
                            <h6>Lesson Learned per Tahap Project</h6>
                            <div>
                                <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                    <a href="{{route('laporan.lessontop5')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-excel mr-2"></i>Xlsx
                                    </a>
                                    <a href="{{route('laporan.lessontop5pdf')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-pdf mr-2"></i>PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row  pb-3">
                            <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                        </div>
                        <div id="graph3" class="d-flex align-items-center justify-content-center" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- lesson learned -->
            <div class="col-md-12">
                <h4>Communication Support Analytics</h4>
                <hr/>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body px-4 pb-0">
                        <div class="row d-flex justify-content-between">
                            <h6>Content Communication Initiative Paling Banyak Dicari</h6>
                            <div>
                                <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                    <a href="{{route('laporan.cominittop5')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-excel mr-2"></i>Xlsx
                                    </a>
                                    <a href="{{route('laporan.cominittop5pdf')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-pdf mr-2"></i>PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row  pb-3">
                            <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                        </div>
                        <div id="graphComInitiative" class="d-flex align-items-center justify-content-center" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body px-4 pb-0">
                        <div class="row d-flex justify-content-between">
                            <h6>Project Strategic Initiative Paling Banyak Dicari</h6>
                            <div>
                                <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                    <a href="{{route('laporan.strategictop5')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-excel mr-2"></i>Xlsx
                                    </a>
                                    <a href="{{route('laporan.strategictop5pdf')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-pdf mr-2"></i>PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row  pb-3">
                            <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                        </div>
                        <div id="graphStraInitiative" class="d-flex align-items-center justify-content-center" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body px-4 pb-0">
                        <div class="row d-flex justify-content-between">
                            <h6>Implementation Yang Paling Banyak Dicari</h6>
                            <div>
                                <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                    <a href="{{route('laporan.imptop5')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-excel mr-2"></i>Xlsx
                                    </a>
                                    <a href="{{route('laporan.imptop5pdf')}}" target="_blank" class="btn dropdown-item">
                                        <i class="far fa-file-pdf mr-2"></i>PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row  pb-3">
                            <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                        </div>
                        <div id="graphImplementation" class="d-flex align-items-center justify-content-center" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Most Keyword -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="d-flex justify-content-between">
                                <div class="pb-3">
                                    <h6>Tags/Keyword Paling Banyak Dicari</h6>
                                    <hr id='waow'>
                                </div>
                                <div class="pb-3">
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                                        <a href="{{route('dashboard.exxltagspopuler')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('dashboard.expdftagspopuler')}}" target="_blank" class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @php
                                $i = 0;
                                $x = count($most) + 1;
                                $y = count($most) + 1;
                            @endphp
                            <!-- Per Baris -->
                                @forelse ($data->tags as $tag)
                                    @php
                                        $i++;
                                    @endphp
                                    @if ($tag->keyword_log_count > 0)
                                    <hr>
                                    <div class="d-flex" data-toggle="collapse" href="#drop{{$i}}" role="button" aria-expanded="false" aria-controls="drop{{$tag->nama}}" style="cursor: pointer;">
                                        <div class="pr-2">
                                            <span class="font-weight-bold">{{$i}}</span>
                                        </div>
                                        <div class="pr-2">
                                            <span class="font-weight-bold">{{$tag->nama}}</span>
                                        </div>
                                        <div class="ml-auto pr-2">
                                            <span class="text-secondary">{{$tag->keyword_log_count}} Pencarian</span>
                                            <span class="dropdown-toggle"></span>
                                        </div>
                                    </div>
                                    <div class="collapse" id="drop{{$i}}">
                                        <div class="d-flex ml-3 text-secondary">Proyek Terkait</div>
                                        <div class="d-flex flex-wrap">
                                            @forelse ($data->relateds as $related)
                                                @if ($related->nama == $tag->nama)
                                                    <a href="{{route('project.index', $related->slug)}}" target="_blank" class="badge badge-light rounded ml-3 mt-2" role="button" style="color: black;">{{$related->nama_project}}</a>
                                                @endif
                                            @empty
                                                <a href="#" class="badge badge-light rounded ml-3 mt-2" role="button" style="color: black;">Tidak ada data</a>
                                            @endforelse
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                    <div class="d-flex" href="#drop" role="button" aria-expanded="false" aria-controls="drop">
                                        <div class="pr-2 text-center w-100">
                                            <span class="font-weight-bold">Tidak ada data.</span>
                                        </div>
                                    </div>
                                @endforelse
                            <!-- End Per Baris -->
                        </div>
                    </div>
                </div>
            <!-- End Most Keyword -->
        </div>
    </div>
</div>

@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/core.js')}}" ></script>
    <script src="{{asset_app('assets/js/charts.js')}}" ></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}" ></script>
    <script src="{{asset_app('assets/js/script/index.js')}}"></script>
@endpush
