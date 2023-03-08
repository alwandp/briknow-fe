@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('kunci', isset($kunci) ? $kunci : '*')
@section('csrf',csrf_token())

@push('style')

    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">   
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/plugin/load/sklt-load.css')}}">
    <style>
        .kaki{
            bottom: 0px;
            position: fixed;
            display: block;
            width: 100%;
        }
        table{
            border-collapse:separate !important;
            border : solid rgba(0, 0, 0, 0.2) 1px;
            border-radius : 6px;
            -moz-border-radius : 6px;
            width:100%;
        }
        
        th{
            padding:0px;
            border-color: inherit;
            border-style: none !important;
            border-width: 0;
            border-bottom-width: 1px !important;
            font-weight : 500 !important;
        }
        td{
            padding:0px;
            border-bottom-width: 0px !important;
            border-top-width: 1px !important;
            color : #2F80ED;
            font-size : 13px;
            border: rgba(0, 0, 0, 0.2) solid 1px !important;
            border-right: none !important;
            border-left: none !important;
            border-bottom: none !important;
        }
    </style>
@endpush

@section('breadcumb', 'Katalog')

@section('content')
<div class="row judul mb-4">
    <div class="col-md-12 px-0">
        <form style="width: 100%" action="#" id="search-form">
            <label class="sr-only" for="inlineFormInputGroup">Search</label>
            <div class="input-group control border-1 pencarian mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control main-cari-2iaef input-search border-0" value="{{isset($kunci) ? $kunci : ''}}" placeholder="Search Project, Consultant, And More...">
                <div class="input-group-append">
                    <button class="btn btn-primary px-3 border-0 btn-search" type="submit" id="button-addon2">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row judul">
  <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
    <div class="row">
        <i class="fa fa-filter filter-search" aria-hidden="true"></i>
        <h5 class="font-weight-bolder">Filter</h5>
    </div>
    <div class="row mb-4">
      <div class="row col-md-12 mx-0 mb-2">
        <div class="col-md-12 px-0 font-weight-bold dropdown show">Pemilik Proyek</div>
        <?php $urut=0; ?>
        @forelse($divisi as $value)
            <?php $urut++; ?>
            @if(!empty($value->divisi))
                <a class="text-decoration-none my-1 w-100" data-toggle="collapse" href="#collapse{{$urut}}" role="button" aria-expanded="false" aria-controls="collapseExample">
            @endif
                <div class="row col-md-12 px-2 mx-0">
                        <div class="col-md-10 col-sm-10 px-0 d-flex align-items-center text-dark fs-10">{{$value->direktorat}}</div>
                        @if(!empty($value->divisi))
                            <div class="col-md-2 col-sm-2 text-dark text-center">
                                <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        @endif
                </div>
            @if(!empty($value->divisi))
                </a>
            @endif

            @if(!empty($value->divisi))
                <div class="w-100 collapse" id="collapse{{$urut}}">
                    @forelse($value->divisi as $value2)
                        <div class="col-md-12 mx-0 fs-10 my-1 d-flex align-items-center">
                            <input type="checkbox" class="check-filter mr-1 fil_div_d" name="" value="{{$value2->shortname}}" id=""/>
                            <label class="m-0">{{$value2->shortname}}</label>
                        </div>
                    @empty
                    @endforelse
                </div>
            @endif  

            @if ($urut == 3)
                @break
            @endif
        @empty
            <div class="row col-md-12 px-2 mx-0">
                <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
            </div>
        @endforelse
        {{-- other --}}
        <div class="row col-md-12 px-2 mx-0 d-flex justify-content-center lainnya">
            <a class="w-100 text-center text-decoration-none text-dark dropdown-toggle" href="#" role="button" id="direktoratsection" data-toggle="dropdown">
                Lainnya
            </a>
            <div class="dropdown-menu py-0 filter-popup" aria-labelledby="direktoratsection">
                <div class="card mb-0">
                    <div class="card-header border-bottom px-3 py-1" style="min-height:50px;">
                        <div class="w-100">
                            <div class="font-weight-bolder">Pemilik Proyek</div>
                        </div>
                    </div>
                    <div class="card-body filter-pop-content px-0 py-1">
                        <?php $urut=0; ?>
                        @forelse($divisi as $value)
                            <?php $urut++; ?>
                            @if(!empty($value->direktorat))
                                <div class="w-100">
                                    <div class="text-dark px-2 font-weight-bolder">{{$value->direktorat}}</div>
                                </div>
                            @else
                                <div class="w-100">
                                    <div class="text-dark px-2 font-weight-bolder">Lainnya</div>
                                </div>
                            @endif

                            @if(!empty($value->divisi))
                                <div class="w-100 mt-1 mb-2">
                                    <div class="row mx-0 mx-0">
                                        @forelse($value->divisi as $value2)
                                            <div class="col-md-6 mx-0 d-flex align-items-center">
                                                <input type="checkbox" class="check-filter fil_div mr-1" name="" value="{{$value2->shortname}}" id="">
                                                {{$value2->shortname}}
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            @endif  
                        @empty
                            <div class="row col-md-12 px-2 mx-0">
                                <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="card-footer border-top p-2" style="min-height:50px !important;">
                        <div class="row mx-0 d-flex justify-content-end">
                            <div>
                                <button class="btn fil-div-res btn-outline-primary btn-sm" type="button">Reset</button>
                                <button class="btn fil-div-app btn-primary btn-sm" type="button">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row col-md-12 mx-0 mb-2">
        <div class="col-md-12 px-0 font-weight-bold dropdown show">Konsultan</div>
        <?php $urut=0; ?>
        @forelse($consultant as $value)
            <?php $urut++; ?>
            <div class="row col-md-12 px-2 py-1 mx-0 d-flex align-items-center fs-10">
                 @if(!empty($value->nama))
                    <input type="checkbox" class="check-filter mr-1 fil_kon_d" name="" value="{{$value->nama}}" id=""/>{{\Str::limit($value->nama,25,'..')}}
                @endif  
            </div>
            @if ($urut == 3)
                @break
            @endif
        @empty
            <div class="row col-md-12 px-2 mx-0">
                <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
            </div>
        @endforelse
        {{-- other --}}
        <div class="row col-md-12 px-2 mx-0 d-flex justify-content-center lainnya">
            <a class="w-100 text-center text-decoration-none text-dark dropdown-toggle" href="#" role="button" id="konsultantsection" data-toggle="dropdown">
                Lainnya
            </a>
            <div class="dropdown-menu py-0 filter-popup" aria-labelledby="konsultantsection">
                <div class="card mb-0">
                    <div class="card-header border-bottom px-3 py-1" style="min-height:50px;">
                        <div class="w-100">
                            <div class="font-weight-bolder">Konsultant</div>
                        </div>
                    </div>
                    <div class="card-body filter-pop-content px-0 py-1">
                        <?php $urut=0; ?>
                        <div class="row mx-0">
                            @forelse($consultant as $value)
                                <?php $urut++; ?>
                                <div class="col-md-6 py-1 mx-0">
                                    <small class="d-flex align-items-center fs-10">
                                        <input type="checkbox" class="check-filter fil_kon mr-1" name="" value="{{$value->nama}}" id="">
                                        {{$value->nama}}
                                    </small>
                                </div>
                            @empty
                                <div class="row col-md-12 px-2 mx-0">
                                    <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer border-top p-2" style="min-height:50px !important;">
                        <div class="row mx-0 d-flex justify-content-end">
                            <div>
                                <button class="btn fil-kon-res btn-outline-primary btn-sm" type="button">Reset</button>
                                <button class="btn fil-kon-app btn-primary btn-sm" type="button">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row col-md-12 mx-0 mb-2">
        <div class="col-md-12 px-0 font-weight-bold dropdown show">Tahun</div>
        <?php $urut=0; ?>
        @forelse($tahun as $item => $value)
            <?php $urut++; ?>
            @if(!empty($item))
                <a class="text-decoration-none my-1 w-100" data-toggle="collapse" href="#collapset{{$urut}}" role="button" aria-expanded="false" aria-controls="collapseExample">
            @endif
                <div class="row col-md-12 px-2 mx-0">
                        <div class="col-md-10 col-sm-10 px-0 text-dark">{{$item}}</div>
                        @if(!empty($item))
                            <div class="col-md-2 col-sm-2 text-dark text-center">
                                <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        @endif
                </div>
            @if(!empty($item))
                </a>
            @endif

            @if(!empty($value))
                <div class="w-100 collapse" id="collapset{{$urut}}">
                    @forelse($value as $value2)
                        <div class="col-md-12 mx-0 fs-10 d-flex align-items-center my-1">
                            <input type="checkbox" class="check-filter mr-1 fil_thn_d" name="" value="{{$item}}-{{$value2->bulan}}" id=""/>
                            <label class="m-0">{{$value2->bulan_name}}</label>
                        </div>
                    @empty
                    @endforelse
                </div>
            @endif  

            @if ($urut == 3)
                @break
            @endif
        @empty
            <div class="row col-md-12 px-2 mx-0">
                <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
            </div>
        @endforelse
        {{-- other --}}
        <div class="row col-md-12 px-2 mx-0 d-flex justify-content-center lainnya">
            <a class="w-100 text-center text-decoration-none text-dark dropdown-toggle" href="#" role="button" id="tahunsection" data-toggle="dropdown">
                Lainnya
            </a>
            <div class="dropdown-menu py-0 filter-popup" aria-labelledby="tahunsection">
                <div class="card mb-0">
                    <div class="card-header border-bottom px-3 py-1" style="min-height:50px;">
                        <div class="w-100">
                            <div class="font-weight-bolder">Tahun</div>
                        </div>
                    </div>
                    <div class="card-body filter-pop-content px-0 py-1">
                        <?php $urut=0; ?>
                        @forelse($tahun as $item => $value)
                            <?php $urut++; ?>
                            <div class="w-100">
                                <div class="text-dark px-2 font-weight-bolder">{{$item}}</div>
                            </div>

                            @if(!empty($value))
                                <div class="w-100 mt-1 mb-2">
                                    <div class="row mx-0 mx-0">
                                        @forelse($value as $value2)
                                            <div class="col-md-6 mx-0 fs-10 d-flex align-items-center my-1">
                                                <input type="checkbox" class="check-filter fil_thn mx-1" name="" value="{{$item}}-{{$value2->bulan}}" id="">
                                                {{$value2->bulan_name}}
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            @endif  
                        @empty
                            <div class="row col-md-12 px-2 mx-0">
                                <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="card-footer border-top p-2" style="min-height:50px !important;">    
                        <div class="row mx-0 d-flex justify-content-end">
                            <div>
                                <button class="btn fil-thn-res btn-outline-primary btn-sm" type="button">Reset</button>
                                <button class="btn fil-thn-app btn-primary btn-sm" type="button">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row col-md-12 mx-0 mb-2">
        <div class="col-md-12 px-0 font-weight-bold dropdown show">Lesson Learned</div>
        <?php $urut=0; ?>
        @forelse($lessonlearn as $value)
            <?php $urut++; ?>
            <div class="row col-md-12 px-2 py-1 mx-0 d-flex align-items-center fs-10">
                 @if(!empty($value->tahap))
                    <input type="checkbox" class="check-filter mr-1 fil_les_d" name="" value="{{$value->tahap}}" id=""/>{{\Str::limit($value->tahap,25,'..')}}
                @endif  
            </div>
            @if ($urut == 3)
                @break
            @endif
        @empty
            <div class="row col-md-12 px-2 mx-0">
                <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
            </div>
        @endforelse
        {{-- other --}}
        <div class="row col-md-12 px-2 mx-0 d-flex justify-content-center lainnya">
            <a class="w-100 text-center text-decoration-none text-dark dropdown-toggle" href="#" role="button" id="lessonlearnsection" data-toggle="dropdown">
                Lainnya
            </a>
            <div class="dropdown-menu py-0 filter-popup" aria-labelledby="lessonlearnsection">
                <div class="card mb-0">
                    <div class="card-header border-bottom px-3 py-1" style="min-height:50px;">
                        <div class="w-100">
                            <div class="font-weight-bolder">Lesson Learned</div>
                        </div>
                    </div>
                    <div class="card-body filter-pop-content px-0 py-1">
                        <?php $urut=0; ?>
                        <div class="row mx-0">
                            @forelse($lessonlearn as $value)
                                <?php $urut++; ?>
                                <div class="col-md-6 py-1 mx-0">
                                    <small class="d-flex align-items-center fs-10">
                                        <input type="checkbox" class="check-filter fil_les mr-1" name="" value="{{$value->tahap}}" id="">
                                        {{$value->tahap}}
                                    </small>
                                </div>
                            @empty
                                <div class="row col-md-12 px-2 mx-0">
                                    <div class="col-md-12 col-sm-12 px-0 text-dark">-</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer border-top p-2" style="min-height:50px !important;">
                        <div class="row mx-0 d-flex justify-content-end">
                            <div>
                                <button class="btn fil-les-res btn-outline-primary btn-sm" type="button">Reset</button>
                                <button class="btn fil-les-app btn-primary btn-sm" type="button">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-8 col-sm-12 px-2">
    <div class="row d-flex justify-content-end mx-0 mb-4 mt-2">
        <div>
            <div class="dropdown show">
                <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Urutkan
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <button class="btn dropdown-item" id="baru"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Terbaru</button>
                    <button class="btn dropdown-item" id="lama"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Terlama</button>
                    <hr class="w-100 my-0"/>
                    <button class="btn dropdown-item" id="az"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>A - Z</button>
                    <button class="btn dropdown-item" id="za">
                        <svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path></svg>
                        Z - A
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="result">
        <div class="col-md-6 sklt mt-2">
            <div class="ph-item border control list-project mb-2">
                <div class="ph-col-4 mb-0">
                    <div class="ph-picture"></div>
                </div>
                <div class="mb-0">
                    <div class="ph-row">
                        <div class="ph-col-12 big mb-3"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 sklt mt-2">
            <div class="ph-item border control list-project mb-2">
                <div class="ph-col-4 mb-0">
                    <div class="ph-picture"></div>
                </div>
                <div class="mb-0">
                    <div class="ph-row">
                        <div class="ph-col-12 big mb-3"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 sklt">
            <div class="ph-item border control list-project mb-2">
                <div class="ph-col-4 mb-0">
                    <div class="ph-picture"></div>
                </div>
                <div class="mb-0">
                    <div class="ph-row">
                        <div class="ph-col-12 big mb-3"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 sklt">
            <div class="ph-item border control list-project mb-2">
                <div class="ph-col-4 mb-0">
                    <div class="ph-picture"></div>
                </div>
                <div class="mb-0">
                    <div class="ph-row">
                        <div class="ph-col-12 big mb-3"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 sklt">
            <div class="ph-item border control list-project mb-2">
                <div class="ph-col-4 mb-0">
                    <div class="ph-picture"></div>
                </div>
                <div class="mb-0">
                    <div class="ph-row">
                        <div class="ph-col-12 big mb-3"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 sklt">
            <div class="ph-item border control list-project mb-2">
                <div class="ph-col-4 mb-0">
                    <div class="ph-picture"></div>
                </div>
                <div class="mb-0">
                    <div class="ph-row">
                        <div class="ph-col-12 big mb-3"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

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
                    <input type="hidden" class="form-control" style="border: none;" value="Eh, liat ini deh. {{!empty($data->nama)?$data->nama:"-"}} di BRIKNOW. &nbsp;{{URL::current()}}" id="generate">
                    <input type="text" class="form-control form-link-bagikan" id="link" readonly="">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn copy-link" onclick="kopas()">Salin</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/script/katalog.js')}}"></script>
@endpush