<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="pages" content="{{ url('') }}">
    <meta name="csrf" content="@yield('csrf',csrf_token())">
    <title>BRIKNOW</title>
    <link rel="icon" type="image/png" href="{{asset_app('assets/img/logo/Logo BRI.png')}}"/>
    <!-- page CSS -->
    <link rel="stylesheet" href="{{asset_app('assets/css/plugin/bs/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/plugin/bs/all.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/components.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/home.css')}}">
    <link rel="stylesheet" href="{{asset_app('css/app.css')}}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset_app('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/components.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset_app('assets/css/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset_app('assets/css/slick/slick-theme.css') }}"/>

    @if($congrats <> [])
        {{-- congrats --}}
        <link rel="stylesheet" href="{{asset_app('assets/css/congrats.css')}}">
    @endif

    {{-- ch --}}
    <script src="{{asset_app('js/app.js')}}"></script>
    <script src="{{asset_app('assets/js/core.js')}}"></script>
    <script src="{{asset_app('assets/js/charts.js')}}"></script>
    <script src="{{asset_app('assets/js/themes/animated.js')}}"></script>

    <script>
        if (jQuery().select2) {
            $(".select2").select2();
        }
        jQuery(document).ready(function ($) {
            $('.owl-carousel').owlCarousel({
                loop: false,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3.4
                    },
                    1000: {
                        items: 5.4
                    }
                }
            })
        })
    </script>
</head>
<body>
<div class="senddataloader">
    <div class="loading">
        <div class="spinner-border" role="status">
        </div>
    </div>
</div>
@if($congrats <> [])
    <div class="layar-back">
        <div id="tsparticles"></div>
        <div class="congrats">
            <h1>Congratulations!</h1>
        </div>
        <div class="message-congrats">
            <div class="d-flex justify-content-center">
                <img src="{{asset_app($congrats->achievement->badge)}}" width="120px" style="z-index: 999;" alt="">
            </div>
            <h3 class="name-badge mb-0">{{$congrats->achievement->name}}</h3>
            <h6 class="task-badge mb-3">{{$congrats->achievement->activity->name}}
                Sebanyak {{$congrats->achievement->value}} Kali</h6>
            <div class="d-flex justify-content-center">
                <button class="btn btn-warning btn-continue">Continue</button>
            </div>
        </div>
    </div>
@endif

<div class="main-wrapper master">
    <div class="navbar-bg">
        <img src="{{asset_app('assets/img/bg/jumbotron-bg.png')}}" class="bg-ornament" alt="">
        <div class="d-flex justify-content-start scaffold">
            <div>
                <img src="{{asset_app('assets/img/logo/bri know white.png')}}" class="mt-3 ml-3" alt="">
            </div>
            <div class="d-flex mr-auto p-2 pl-4 align-items-center">
                <a href="{{route('mycomsupport.initiative')}}" class="btn btn-sm btn-link btn-link-com text-white mr-2">Communication
                    Support</a>
            </div>
            <div class="d-flex p-2 align-items-end">
                <nav class="navbar navbar-expand-lg main-navbar">
                    <a href="{{asset_app('briknow-addins.zip')}}" target="_blank"
                       class="btn btn-sm btn-warning addin mr-2">Download Add-in</a>
                    <ul class="navbar-nav navbar-right">
                        <a href="{{route('kontribusi')}}" class="btn bg-white addin btn-sm" role="button"
                           aria-pressed="true"><i class="fas fa-upload mr-1"></i>Upload Project</a>
                    </ul>
                    <ul class="navbar-nav navbar-right">
                        @include('layouts.notifikasi')
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"
                               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <img alt="image"
                                     src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}"
                                     draggable="false" class="rounded-circle mr-1">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @php
                                    if (session('role') == 3) {
                                        $role = 'Admin';
                                    } else {
                                        $role = 'User';
                                    }
                                @endphp
                                <div class="dropdown-item">
                                    <a style="text-decoration: none;" href="{{route('home.profile')}}"
                                       class="d-flex justify-content-left align-items-center w-100 text-decoration-none">
                                        <div class="d-flex align-items-center mr-2">
                                            <img alt="image"
                                                 src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}"
                                                 draggable="false" width="30px"
                                                 class="rounded-circle icon-user-navbar mr-1">
                                        </div>
                                        <div>
                                            <div>
                                                <small class="d-block lh-10 text-dark">{{\Str::limit(session('username'),15)}}</small>
                                            </div>
                                            <div class="lh-20 d-flex align-items-center mt-1">
                                                <span class="badge badge-info px-1 py-0"><small>{{$role}}</small></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-divider my-1"></div>
                                <a href="#" data-toggle='modal' data-target='#editprofil' class="dropdown-item">Edit
                                    Profile</a>
                                <a href="{{ route('myproject') }}" class="dropdown-item">My Project</a>
                                <a href="{{ route('mycomsupport.myimplementation') }}" class="dropdown-item">My Implementation</a>
                                <a href="{{ route('myfavorite') }}" class="dropdown-item">My Favorite</a>
                                <a href="{{ route('mylesson') }}" class="dropdown-item">My Lesson Learned</a>
                               {{-- <a href="{{ route('lessonlearned') }}" class="dropdown-item">Lesson Learned</a> --}}
                                <a href="{{ route('forum.index') }}" class="dropdown-item">Forum</a>
                                @if(session('role') == 3)
                                    <a href="{{ route('dashboard.performance') }}" class="dropdown-item">Dashboard
                                        Admin</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="mb-4 px-4 h-75 d-flex justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="row">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" name="search" class="form-control main-cari-2iaef" id="search-form"
                                placeholder="Search Project ...">
                        <div class="dropdown-menu dropdown-menu-right w-100" id="searchResult">
                        </div>
                        <div class="input-group-append">
                            <a class="btn btn-primary text-white" onclick="searchKatalog()" oncontextmenu="searchKatalog()"
                            onmousedown="searchKatalog()">Terapkan</a>    
                        </div>
                    </div>
                </div>
                <div class="row px-2">
                    <div class="row px-2 d-block w-100 my-1">
                        <span class="text-white">Suggestion :</span>
                    </div>
                    <div class="w-100 row d-flex justify-content-center">
                        @isset($suggest)
                            @forelse($suggest as $item)
                                <a href="{{route('katalog.pencarian',$item->nama)}}" class="text-decoration-none"><span
                                            class="badge bg-white btn-sm mx-2 my-1 text-black">{{$item->nama}}</span></a>
                            @empty
                                <small class="text-white">Belum Ada Keyword Yang Terdaftar</small>
                            @endforelse
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 rekomendasi">
                    <h5 class="text-warning m-0">Communication</h5>
                    <h2 class="font-weight-bolder">Support</h2>
                </div>
            </div>
            <div class="rekomendasi mx-2 mt-4">
                @empty($recominitiative)
                    <div class="col-sm-12 d-flex justify-content-center">
                        <span class="text-black-50 font-italic">Tidak Ada Data Rekomendasi Communication</span>
                    </div>
                @else
                    <div id="slider-com" class="slider-cus">
                        @foreach($recominitiative as $item)
                            <div class="item py-1">

                                <div class="card bg-6sa6ss sh-a22l" style="height: 400px; border-radius: 8px">
                                   @if ($item->type_file !== "")
                                   	 <a href="{{route('mycomsupport.initiative.type', [$item->type_file, 'slug' => $item->slug])}}"
                                      		 class="text-decoration-none text-dark" style="margin-top: 1px">
                                       		 <img class="card-img-up-2" src="{{ asset('storage/'.$item->thumbnail)}}"
                                            		 alt="Card image cap">
                                    	</a>
                                   @else
					 <a href="{{route('view.implement', [$item->slug])}}"
                                      		 class="text-decoration-none text-dark" style="margin-top: 1px">
                                       		 <img class="card-img-up-2" src="{{ asset('storage/'.$item->thumbnail)}}"
                                            		 alt="Card image cap">
                                    	</a>
                                   @endif
                                 <div class="card-body pt-2 pb-3 px-4">
                                   @if ($item->type_file !== "")
               				 <a href="{{route('mycomsupport.initiative.type', [$item->type_file, 'slug' => $item->slug])}}"
                                           class="text-decoration-none text-dark card-title d-inline-block mb-1"
                                           style="font-size: 1rem; height: 50px; width: fit-content;font-weight: 700">
                                            {{$item->nama}}
                                        </a>
                                   @else
					<a href="{{route('view.implement', [$item->slug])}}"
                                           class="text-decoration-none text-dark card-title d-inline-block mb-1"
                                           style="font-size: 1rem; height: 50px; width: fit-content;font-weight: 700">
                                            {{$item->nama}}
                                        </a>
                                   @endif

                                        <div class="card-desc implementation-desc">{!! $item->desc !!}</div>
                                        {{--                                              {!! \Illuminate\Support\Str::limit($item->desc, 20, ' ...') !!}--}}
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <i class="mr-auto pl-2 fas fa-eye grey">
                                            <span>{{$item->view}}</span>
                                        </i>
                                        <small class="text-time d-block"
                                               style="margin-bottom: 0;margin-right: 4px">{{\Carbon\Carbon::create($item->created_at)->diffForHumans()}}</small>
                                        <button class="btn p-1 grey" style="font-size: 20px;margin-right: 4px"
                                                onclick="download({{$item->id}})">
                                            <img src="{{asset_app('assets/img/logo/download_ic.png')}}"/>
                                        </button>
                                        <button class="btn p-1 grey" style="font-size: 20px;margin-right: 4px"
                                                data-toggle="modal" data-target="#berbagi"
                                                onclick="migrasi('Eh, liat Konten ini deh. {{$item->nama}} di BRIKNOW. &nbsp;{{ isset($item->type_file) ? route('mycomsupport.initiative.type', [$item->type_file, 'slug' => $item->slug]) : route('view.implement', [$item->slug]) }}')">
                                            <img src="{{asset_app('assets/img/logo/share_ic.png')}}"/>
                                        </button>
                                        @if ($item->type_file !== "")
                                            <button class="btn p-1 grey" style="font-size: 20px;"
                                                    onclick="saveFavCom(this, {{$item->id}})">
                                                @if($item->favInit == 1)
                                                    <img src="{{asset_app('assets/img/logo/ic_favorited.png')}}"/>
                                                   @else
                                                    <img src="{{asset_app('assets/img/logo/favoriite_ic.png')}}"/>
                                                   @endif
                                            </button>
                                        @else
                                            <button class="btn p-1 grey" style="font-size: 20px;"
                                                    onclick="saveFavCom(this, {{$item->id}})">
                                                @if($item->favImpl == 1)
                                                    <img src="{{asset_app('assets/img/logo/ic_favorited.png')}}"/>
                                                   @else
                                                    <img src="{{asset_app('assets/img/logo/favoriite_ic.png')}}"/>
                                                   @endif
                                            </button>
                                      @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="w-100 d-flex justify-content-center mt-4">
                        <button class="btn btn-primary"
                                onclick="location.href='{{ route('mycomsupport.initiative') }}'">Lihat Semua
                        </button>
                    </div>
                @endempty
            </div>
        </div>
    </div>
    <div class="px-4 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 rekomendasi">
                    <h5 class="text-warning m-0">Unggahan</h5>
                    <h2 class="font-weight-bolder">Rekomendasi</h2>
                </div>
            </div>
            <div class="rekomendasi mx-2 mt-4">
                @empty($rekomendasi)
                    <div class="col-sm-12 d-flex justify-content-center">
                        <span class="text-black-50 font-italic">Tidak Ada Data Unggahan Rekomendasi</span>
                    </div>
                @else
                    <div id="slider-rec" class="slider-cus">
                        @foreach($rekomendasi as $item)
                            <div class="item py-1">
                                <a href="{{route('project.index',$item->slug)}}" class="text-decoration-none text-dark">
                                    <div class="card bg-6sa6ss sh-a22l d-flex justify-content-center align-items-center o-hidden">
                                        <?php
                                        if (file_exists(public_path('storage/' . $item->thumbnail))) {
                                            $item->thumbnail = config('app.url') . 'storage/' . $item->thumbnail;
                                        } else {
                                            $item->thumbnail = config('app.url') . 'assets/img/boxdefault.svg';
                                        }
                                        ?>
                                        <img class="card-img-top" src="{{$item->thumbnail}}" alt="Card image cap">
                                        <div class="card-body p-2 w-100">
                                            <small class="text-dark">{{\Str::limit($item->divisi->divisi,25)}}</small>
                                            <strong class="d-block">{{$item->nama}}</strong>
                                            <small class="text-time d-block">{{\Carbon\Carbon::create($item->updated_at)->diffForHumans()}}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endempty
            </div>
        </div>
    </div>
    <div class="px-4 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 rekomendasi">
                    <h5 class="text-warning m-0">Filter</h5>
                    <h2 class="font-weight-bolder">Project</h2>
                </div>
            </div>
            <div class="row rekomendasi mt-4">
                <div class="card bg-whitesmoke d-flex w-100" style="border-radius: 16px">
                    <div class="card-body">
                        <div class="mt-3">
                            <div class="d-flex justify-content-start">
                                <h5 class="p-2 col-lg-6">Direktorat</h5>
                                <h5 class="p-2 col-lg-6">Konsultan/Vendor</h5>
                            </div>
                            <div class="d-flex justify-content-start">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                                </span>
                                </div>
                                <select name="direktorat" id="direktorat"
                                        class="mr-auto p-2 form-control text-black select2"
                                        value="{{old('direktorat')}}" multiple>
                                    {{--                                      <option value="" disabled selected>Pilih Direktorat</option>--}}
                                    @foreach ($direk == NULL ? 'Lainnya' : $direk as $item)
                                        @isset($divisi)
                                            @if($divisi == $item->direktorat)
                                                <option value="{{$item->direktorat }}"
                                                        data-value="{{ $item->direktorat }}"
                                                        selected>{{ $item->direktorat }}</option>
                                            @else
                                                <option value="{{$item->direktorat }}"
                                                        data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                                            @endif
                                        @elseif(old('direktorat') <> null)
                                            @if(old('direktorat') == $item->direktorat)
                                                <option value="{{$item->direktorat }}"
                                                        data-value="{{ $item->direktorat }}"
                                                        selected>{{ $item->direktorat }}</option>
                                            @else
                                                <option value="{{$item->direktorat }}"
                                                        data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                                            @endif
                                        @else
                                            <option value="{{$item->direktorat }}"
                                                    data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                                        @endisset
                                    @endforeach
                                    <option value="NULL">Lainnya</option>
                                </select>
                                <div class="input-group-prepend ml-3">
                                <span class="input-group-text"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                                </span>
                                </div>
                                <select id="consultant" class="mr-auto p-2 form-control select2"
                                        value="{{old('consultant')}}" name="consultant" multiple>
                                    @foreach ($consultant_filter == NULL ? 'Lainnya' : $consultant_filter as $item)
                                        <option value="{{$item->id }}"
                                                data-value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                {{--<input type="text" name="search" class="mr-auto p-2 form-control main-cari-2iaef"
                                       id="searchCons" placeholder="Konsultan...">--}}
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-start">
                                <h5 class="p-2 col-lg-6">Divisi</h5>
                                <h5 class="p-2 col-lg-6">Lesson Learned</h5>
                            </div>
                            <div class="d-flex justify-content-start">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                                </span>
                                </div>
                                <select id="divisi" class="mr-auto p-2 form-control select2" value="{{old('divisi')}}"
                                        name="divisi[]" multiple>
                                    {{--                                      <option value="" selected disabled>Pilih Unit Kerja</option>--}}
                                </select>
                                <div class="input-group-prepend ml-3">
                                <span class="input-group-text"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                                </span>
                                </div>
                                    {{--<select id="lessonLearn" class="mr-auto p-2 form-control select2"
                                            value="{{old('lessonlearn')}}" name="lessonlearn">
					    <option value="" selected disabled>Pilih Tahap</option>
                                        @foreach ($lessonlearn == NULL ? 'Lainnya' : $lessonlearn as $item)
                                            <option value="{{$item->tahap }}"
                                                    data-value="{{ $item->tahap }}">{{ $item->tahap }}</option>
                                        @endforeach
                                    </select>--}}
                                <select id="lessonLearn" class="mr-auto p-2 form-control select2" value="{{old('lessonlearn')}}"
                                        name="lessonlearn">
                                    <option value="" selected disabled>Pilih Tahap</option>
				                    <option value="all" data-value="all">All Tahap Proyek</option>
                                    <option value="Plan" data-value="Plan">Plan</option>
                                    <option value="Procurement" data-value="Procurement">Procurement</option>
                                    <option value="Development" data-value="Development">Development</option>
                                    <option value="Pilot Run" data-value="Pilot Run">Pilot Run</option>
                                    <option value="Implementation" data-value="Implementation">Implementation</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 w-50">
                            <div class="d-flex justify-content-start">
                                <h5 class="p-2 col-lg-6">Tahun</h5>
                            </div>
                            <div class="d-flex justify-content-start">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-search fa-lg"
                                                                        aria-hidden="true"></i></span>
                                </div>
                                {{--                                  <input type="date" name="search" class="col-lg-6 mr-3 form-control main-cari-2iaef"--}}
                                {{--                                         id="search" placeholder="Search Project, Consultant, And More...">--}}
                                <select id="selectYear" class="mr-auto p-2 form-control select2" name="selectYear">
                                    <option value="" selected disabled>Pilih Tahun</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-100 d-flex mt-4 justify-content-center">
                            <a class="btn btn-primary text-white" onclick="toKatalog()" oncontextmenu="toKatalog()"
                               onmousedown="toKatalog()">Terapkan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 rekomendasi">
                    <h5 class="text-warning m-0">TOP</h5>
                    <h2 class="font-weight-800">Data</h2>
                </div>
            </div>
            <div class="row rekomendasi mt-2">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body p-1 px-2 card-chart">
                            <div class="row p-2 px-4 mt-2 pb-0 d-flex justify-content-between">
                                <span class="font-weight-bold d-block label_grap">Proyek Paling Banyak Dicari</span>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink"
                                       style="text-decoration: none; color: black;"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"
                                         style="width:160px !important;">
                                        <a href="{{route('laporan.proyektop5')}}" target="_blank"
                                           class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('laporan.proyektop5pdf')}}" target="_blank"
                                           class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                            </div>
                            <div id="graph2" class="d-flex align-items-center justify-content-center"
                                 style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body p-1 px-2 card-chart">
                            <div class="row p-2 px-4 mt-2 pb-0 d-flex justify-content-between">
                                <span class="font-weight-bold d-block label_grap">Konsultant/Vendor Paling Banyak Dicari</span>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink"
                                       style="text-decoration: none; color: black;"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"
                                         style="width:160px !important;">
                                        <a href="{{route('laporan.vendortop5')}}" target="_blank"
                                           class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('laporan.vendortop5pdf')}}" target="_blank"
                                           class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                            </div>
                            <div id="graph" class="d-flex align-items-center justify-content-center"
                                 style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row rekomendasi mt-2">
                <div class="col-lg-3 col-md-12 col-sm-12">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body p-1 px-2 card-chart">
                            <div class="row p-2 px-4 mt-2 pb-0 d-flex justify-content-between">
                                <span class="font-weight-bold d-block label_grap">Lesson Learned per Tahap Project</span>
                                <div>
                                    <a href="#" class="btn btn-light bg-white" id="dropdownMenuLink"
                                       style="text-decoration: none; color: black;"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"
                                         style="width:160px !important;">
                                        <a href="{{route('laporan.lessontop5')}}" target="_blank"
                                           class="btn dropdown-item">
                                            <i class="far fa-file-excel mr-2"></i>Xlsx
                                        </a>
                                        <a href="{{route('laporan.lessontop5pdf')}}" target="_blank"
                                           class="btn dropdown-item">
                                            <i class="far fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-4">
                                <hr class="d-block mt-0 mb-2 w-25 m-0 garis-bawah">
                            </div>
                            <div id="graph3" class="d-flex align-items-center justify-content-center"
                                 style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12">
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 pt-5 pb-5">
        <div class="container-fluid">
            <div class="row p-3 rekomendasi h-100">
                <div class="col-md-4 d-flex align-items-center">
                    <div>
                        <h5 class="text-warning">BRIKNOW</h5>
                        <h4 style="color: #0a53be" class="font-weight-800 mb-2">LEADERBOARD</h4>
                        <p class="text-leaderboard-deskripsi">Jadi yang teratas dengan mengumpulkan Experience Point
                            terbanyak! Caranya? Cukup selesaikan aktivitas tugas dan tantangan yang ada. Papan peringkat
                            akan terus terupdate secara otomatis, ayo kumpulkan Experience Point kamu! <a
                                    style="text-decoration: none;" href="{{route('home.game')}}" target="_blank"
                                    class="text-decoration-none text-white">Learn More</a></p>
                    </div>
                </div>
                <div class="col-md-8  d-flex align-items-center">
                    <div class="card w-100 m-0 overflow-hidden">
                        <div class="card-header text-white"
                             style="background-color: #3d26ff;border-bottom: none;/* color: white; */">
                            <h4 class="text-white">Top 10 Leaderboard</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped bordered">
                                    <thead>
                                    <tr>
                                        <td class="text-dark font-weight-bold">No</td>
                                        <td class="text-dark font-weight-bold">Nama</td>
                                        <td class="text-dark font-weight-bold">Total Poin</td>
                                        <td class="text-dark font-weight-bold">Grade</td>
                                        <td class="text-dark font-weight-bold">No</td>
                                        <td class="text-dark font-weight-bold">Nama</td>
                                        <td class="text-dark font-weight-bold">Total Poin</td>
                                        <td class="text-dark font-weight-bold">Grade</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $urut = 1;
                                    @endphp
                                    @for($i = 0; $i <= 10; $i++)
                                        @php
                                            $leader_name[$urut]     =   $leaderboard[$i]->name??'-';
                                            $leader_xp[$urut]       =   $leaderboard[$i]->xp??0;
                                            $level_badge[$urut]     =   $leaderboard[$i]->badge??'-';
                                            $pn_user[$urut]         =   $leaderboard[$i]->personal_number??'-';
                                            $urut++;
                                        @endphp
                                    @endfor
                                    @for($i = 1; $i <= 5; $i++)
                                        <tr>
                                            @if(isset($leader_name[$i]))
                                                @if($i == 1)
                                                    <td class="bg-info text-white font-weight-bold">{{$i}}</td>
                                                    <td class="bg-info text-white"><a style="text-decoration: none;"
                                                                                      href="{{route('home.profileuser', $pn_user[$i])}}"
                                                                                      target="_blank">{{\Str::limit($leader_name[$i]??'-',20,'..')??'-'}}</a>
                                                    </td>
                                                    <td class="bg-info text-white"
                                                        style="text-align: center;vertical-align: middle;}">{!!"<span class='badge text-dark badge-warning'>".$leader_xp[$i]."</span>"??'-'!!}</td>
                                                    <td class="bg-info text-white">
                                                        <div class="d-flex align-items-center">
                                                            @if($level_badge[$i] == '-')
                                                                -
                                                            @else
                                                                <img draggable='false' alt="image"
                                                                     src="{{asset_app($level_badge[$i])}}"
                                                                     class="img pr-2">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-dark font-weight-bold ml-2">{{$i+5}}</td>
                                                    <td class=""><a style="text-decoration: none;"
                                                                    href="{{route('home.profileuser', $pn_user[$i+5])}}"
                                                                    target="_blank">{{\Str::limit($leader_name[$i+5]??'-',20,'..')??'-'}}
                                                    </td>
                                                    <td class=""
                                                        style="text-align: center;vertical-align: middle;}">{!!"<span class='badge badge-primary'>".$leader_xp[$i+5]??'-'."</span>"??'-'!!}</td>
                                                    <td class="">
                                                        <div class="d-flex align-items-center">
                                                            @if($level_badge[$i+5] == '-')
                                                                -
                                                            @else
                                                                <img draggable='false' alt="image"
                                                                     src="{{asset_app($level_badge[$i + 5])}}"
                                                                     class="img pr-2">
                                                            @endif
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class="text-dark font-weight-bold">{{$i}}</td>
                                                    <td><a style="text-decoration: none;"
                                                           href="{{route('home.profileuser', $pn_user[$i])}}"
                                                           target="_blank">{{\Str::limit($leader_name[$i],20,'..')??'-'}}
                                                    </td>
                                                    <td style="text-align: center;vertical-align: middle;}">{!!"<span class='badge badge-primary'>".$leader_xp[$i]??''."</span>"??'-'!!}</td>
                                                    <td class="">
                                                        <div class="d-flex align-items-center">
                                                            @if($level_badge[$i] == '-')
                                                                -
                                                            @else
                                                                <img draggable='false' alt="image"
                                                                     src="{{asset_app($level_badge[$i])}}"
                                                                     class="img pr-2">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-dark font-weight-bold ml-2">{{$i+5}}</td>
                                                    <td><a style="text-decoration: none;"
                                                           href="{{route('home.profileuser', $pn_user[$i+5])}}"
                                                           target="_blank">{{\Str::limit($leader_name[$i+5],20,'..')??'-'}}
                                                    </td>
                                                    <td style="text-align: center;vertical-align: middle;}">{!!"<span class='badge badge-primary'>".$leader_xp[$i+5]."</span>"??'-'!!}</td>
                                                    <td class="">
                                                        <div class="d-flex align-items-center">
                                                            @if($level_badge[$i+5] == '-')
                                                                -
                                                            @else
                                                                <img draggable='false' alt="image"
                                                                     src="{{asset_app($level_badge[$i + 5])}}"
                                                                     class="img pr-2">
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            @else
                                                <td class="text-dark font-weight-bold">{{$i}}</td>
                                                <td>{{'-'}}</td>
                                                <td>{!!'-'!!}</td>
                                                <td>{!!'-'!!}</td>
                                                <td class="text-dark font-weight-bold ml-2">{{$i+5}}</td>
                                                <td>{{'-'}}</td>
                                                <td>{!!'-'!!}</td>
                                                <td>{!!'-'!!}</td>
                                            @endif
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Pemberitahuan</h5>
                    </div>
                    <div class="modal-body text-justify">
                        Dengan melakukan Login pada aplikasi ini, maka anda menyetujui bahwa seluruh Informasi dalam
                        aplikasi ini bersifat <span class="bg-warning text-dark font-weight-bold">rahasia</span> dan
                        merupakan <span class="bg-warning text-dark font-weight-bold">hak cipta milik BRI</span>, hanya
                        boleh digunakan untuk <span class="bg-warning text-dark font-weight-bold">kepentingan internal BRI</span>,
                        dilarang menyalahgunakan dan menyebarluaskan kepada pihak eksternal manapun. Pelaku pembocoran
                        informasi kepada pihak eksternal manapun akan menerima <span
                                class="bg-warning text-dark font-weight-bold">sanksi sesuai perundang-undangan dan ketentuan yang berlaku.</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('logout') }}'">
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" data-toggle="modal">Setuju
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <svg id="bot" width="677" height="804" viewBox="0 0 677 804" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path opacity="0.2"
              d="M254.176 586.981C-8.18269 644.209 -8.49086 827.079 16.1758 885.445H1392.18V0C1383.51 20.5609 1304.18 70.4377 1056.18 105.458C808.176 140.477 674.176 281.883 638.176 348.209C602.176 414.534 500.469 533.257 254.176 586.981Z"
              fill="#ED832F"/>
        <path opacity="0.2"
              d="M248.176 659.981C-14.1827 717.209 -14.4909 900.079 10.1758 958.445H1386.18V73C1377.51 93.5609 1298.18 143.438 1050.18 178.458C802.176 213.477 668.176 354.883 632.176 421.209C596.176 487.534 494.469 606.257 248.176 659.981Z"
              fill="#ED832F"/>
    </svg>
    <div class="navbar-bg leaderboard">
        <img src="{{asset_app('assets/img/bg/jumbotron-bg.png')}}" class="bg-ornament-footer bg-footer-ornament" alt="">
        <div class="row">
            <div class="col-lg-1 col-md-12 col-sm-12 pt-5" style="padding-left: 2rem">
                <h5 class="text-warning m-0">About</h5>
                <h2 class="font-weight-800 mb-2 text-white">BRIKNOW</h2>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12 rekomendasi pt-5 pr-3">
                <p class="text-white pl-3">
                    Data dan informasi merupakan denyut nadi perekonomian abad 21. Dalam era informasi data dikenal sebagai aset perusahaan yang vital. Salah satu data yang penting untuk dikelola oleh BRI adalah data terkait proyek.<br>
                </p>
                <p class="text-white pl-3">
                    Kini telah hadir BRIKNOW sebagai repository project deliverables untuk mendokumentasikan proyek BRI.<br>
                </p>
                <p class="text-white pl-3">
                    BRIKNOW diharapkan dapat menambah pengetahuan bagi unit kerja yang akan menginisiasi project. Melalui BRIKNOW user dapat melakukan review dan memanfaatkan metodologi, lesson learned, aktivitas komunikasi project, dan success story implementasi  atas project yang pernah ada untuk menunjang kemampuan internal BRI menciptakan inisiatif strategis secara independent.<br>
                </p>
                <p class="text-white mb-2 pl-3">
                    Jika butuh informasi lebih lengkap user juga dapat mendownload berbagai dokumen proyeknya.<br><br>
                </p>
                <p class="text-white pl-3" style="line-height: 2.2">
                    Sekarang aktivitas inisiasi proyek jadi lebih mudah.<br>
                    Selamat berinovasi Insan BRILiaN!<br>
                    BRIKNOW siap mendampingi<br>

                    #PMOAllAroundYou
                </p>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
                <img src="{{asset_app('assets/img/default/about.png')}}" width="100%" class="img_about" alt="">
            </div>
        </div>
    </div>
    <footer class="main-footer bg-bri text-white" style="position: absolute;bottom: 0px;">
        <small class="footer-left">
            Copyright &copy; 2021 BRIKNOW
        </small>
        <small class="footer-right">
            1.0.0
        </small>
    </footer>
    @include('layouts.edit_profile')
    <div class="modal fade" id="berbagi" tabindex="-1" role="dialog" aria-labelledby="berbagi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bolder" id="exampleModalLongTitle">Bagikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group form-bagikan">
                                <input type="text" class="form-control form-link-bagikan" id="link" readonly="">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn copy-link" onclick="kopas()">
                                        Salin
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- General JS Scripts -->

@if($congrats <> [])
    {{-- congrats --}}
    <script src="{{asset_app('assets/js/plugin/TweenMax.min.js')}}"></script>
    <script type="text/javascript" src="{{asset_app('assets/js/plugin/lodash.min.js')}}"></script>
    <script src="{{asset_app('assets/js/congrats.js')}}"></script>
    <script>
        $('.btn-continue').click(function () {
            var token_congrats = "{{session('token')}}";
            var id_congrats = "{{$congrats->id}}";
            var be_congrats = "{{config('app.url_be')}}";
            // update
            var url = `${be_congrats}api/congrats`;
            $.ajax({
                url: url,
                type: "post",
                data: {id: id_congrats},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token_congrats);
                    $('.layar-back').hide();
                },
                success: function (data) {
                    console.log(data.data.message);
                },
                error: function (e) {
                    console.log(data.data.message);
                }
            });
        });
    </script>
@endif

{{-- sweet --}}
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
@if (Session::has('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        var tampung = `{{ Session::get('error')}}`;
        Toast.fire({icon: 'error', title: tampung});
    </script>
@endif
@if (Session::has('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        var tampung = `{{ Session::get('success')}}`;
        Toast.fire({icon: 'success', title: tampung});
    </script>
@endif

<!-- Slick JS -->
<script type="text/javascript" src="{{ asset_app('assets/js/plugin/slick.min.js') }}"></script>
<script src="{{asset_app('assets/js/script/home.js')}}"></script>
<!-- Template JS File -->
<script src="{{asset_app('assets/js/select2.min.js')}}"></script>
<script src="{{asset_app('assets/js/temp/scripts.js')}}"></script>
<script src="{{asset_app('assets/js/temp/custom.js')}}"></script>
<script src="{{asset_app('assets/js/page/notification.js')}}"></script>
@if(Session::has('term'))
    <script>
        $('#myModal').modal({backdrop: 'static', keyboard: false})
    </script>
@endif
</body>
</html>
