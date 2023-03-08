@extends('layouts.master')
@section('title', 'BRIKNOW')
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

@section('breadcumb', 'Divisi')
@section('back', route('katalog.index'))
@section('id_consultant', $data->id)
@section('content')
<div class="row judul">
  <div class="col-md-12 px-0 header-detail">
    <div class="row">
      <div class="col-md-12 mb-2">
          <h2 class="d-block">{{$data->divisi}}</h2>
        <div class="row">
          <div class="col-md-12">
              <span class="d-block">
                <strong>Direktorat : </strong>
                {{$data->direktorat == NULL ? 'Lainnya' : $data->direktorat}}
              </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row judul">
  <hr width="100%">
</div>
<div class="row judul">
  <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
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
  <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify">
    <div>
      <h6>Project</h6>
      <div class="row mb-2 px-2">
        <div class="col-md-12 col-sm-12">
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
      </div>
      <div class="row" id="lst_content">
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
</div>
@endsection
@push('page-script')
  <script src="{{asset_app('assets/js/page/divisi.js')}}"></script>
@endpush