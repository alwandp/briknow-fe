@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('back', route('katalog.index'))
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
        .align-link{
          word-wrap: break-word;
        }
    </style>
@endpush

@section('breadcumb', 'Consultant')
@section('id_consultant', $data->id)
@section('content')
<div class="row judul">
    <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-4">
        <img src="{{asset_app('assets/img/boxdefault.svg')}}" alt="" class="img-detail2">
    </div>
    <div class="col-md-10 col-sm-12 pr-0 header-detail">
      <div class="row">
        <div class="col-md-8 col-sm-12 mb-2">
          <div class="col-sm-12 px-0">
            <h2 class="d-block">{{!empty($data->nama)?$data->nama:"-"}}</h2>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <i class="fas fa-map-marker-alt mr-2"></i>{{!empty($data->lokasi)?$data->lokasi:"-"}}
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 d-flex justify-content-end">
          <div>
            @if ($is_favorit)
              <button class="btn btn-sm px-2 control rounded font-weight-normal aktip" id="btn-favoritcons"><i class="fas fa-star mr-1 gold" id="star"></i> Simpan</button>
            @else
              <button class="btn btn-sm px-2 control rounded font-weight-normal" id="btn-favoritcons"><i class="far fa-star mr-1" id="star"></i> Simpan</button>
            @endif
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row judul mt-0">
  <hr width="100%" class="mt-0">
</div>
<div class="row judul">
  <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
    <div class="row">
      <h6 class="font-weight-bolder">Detail</h6>
    </div>
    <div class="row mb-4">
      <div class="row col-md-12 mt-2 pr-0">
        <div class="col-md-12 px-0 font-weight-bold">Industry</div>
        <div class="col-md-12 px-0">{{!empty($data->bidang)?$data->bidang:"-"}}</div>
      </div>
      <div class="row col-md-12 mt-2">
        <div class="col-md-12 px-0 font-weight-bold">Website</div>
        <div class="col-md-12 px-0"><a href="{{!empty($data->website)?"https://".$data->website:"#"}}" target="_blank">{{!empty($data->website)?\Str::limit($data->website,30):"-"}}</a></div>
      </div>
      <div class="row col-md-12 mt-2">
        <div class="col-md-12 px-0 font-weight-bold mb-1 pt-2">Contact</div>
        <div class="col-md-4 px-0">Phone</div>
        <div class="col-md-8 px-0">{{!empty($data->telepon)?phone($data->telepon):"-"}}</div>
        <div class="col-md-4 px-0">Email</div>
        <div class="col-md-8 px-0 text-wrap">
          @if(!empty($data->email))
            @php
              $email = Str::limit($data->email, 20, '...');
            @endphp
          @endif
          <a href="{{!empty($data->email)?"mailto:".$data->email:"#"}}">{{!empty($email)?$email:"-"}}</a>
        </div>
        <div class="col-md-4 px-0">Facebook</div>
        <div class="col-md-8 px-0 text-wrap"><a class="align-link" href="{{!empty($data->facebook)?"https://".$data->facebook:"#"}}" target="_blank">{{!empty($data->facebook)?$data->facebook:"-"}}</a></div>
        <div class="col-md-4 px-0">Instagram</div>
        <div class="col-md-8 px-0 text-wrap"><a class="align-link" href="{{!empty($data->instagram)?"https://".$data->instagram:"#"}}" target="_blank">{{!empty($data->instagram)?$data->instagram:"-"}}</a></div>
      </div>
    </div>
    <div class="row">
        <h6 class="font-weight-bolder">Riwayat Proyek perTahun</h6>
    </div>
    <div class="row">
        <div class="row col-md-12 mt-2">
          @foreach ($tahun as $tahun => $project)
            <div class="col-md-4 col-sm-6 pl-0 font-weight-bolder">
              <a href="#" class="decoration-none riwayat_tahun" data-value="{{$tahun}}">
                {{$tahun}}
              </a>
            </div>
            <div class="col-md-6 col-sm-6 text-right px-0"> {{$project}} Project</div>
          @endforeach
    </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-8 col-sm-12 px-0">
    <div class="mb-4">
      <h6>Tentang Perusahaan</h6>
      <span>{{!empty($data->tentang)?$data->tentang:"-"}}</span>
    </div>
    <div>
      <h6>Project</h6>
      <div class="row mb-2">
        <div class="w-100">
            <div class="align-items-center">
              <div class="row px-2">
                <div class="col-md-11 col-sm-12">
                    <form action="#" class="w-100" id="search">
                        <label class="sr-only" for="inlineFormInputGroup">Search</label>
                        <div class="input-group search-list-proj mb-2">
                            <div class="input-group-prepend border-0 pretel-search-list-proj h-100">
                                <div class="input-group-text icon-search-list"><i class="fas fa-search"></i></div>
                            </div>
                            <input type="text" class="form-control border-0 pretel-search-list-proj"placeholder="Search Projects...">
                        </div>
                    </form>
                </div>
                <div class="col-md-1 col-sm-12">
                    <div class="dropdown show d-inline">
                        <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <button type="button" class="btn dropdown-item" id="baru"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Terbaru</button>
                            <button type="button" class="btn dropdown-item" id="lama"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Terlama</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="row" id="list_project">
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
      </div>
    </div>
  </div>
</div>
@endsection
{{-- persiapan integrasi search --}}
@push('page-script')
  <script src="{{asset_app('assets/js/page/consultant.js')}}"></script>
@endpush