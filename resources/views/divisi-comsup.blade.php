@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
  <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/plugin/load/sklt-load.css')}}">
  <link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
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
    <div class="senddataloader">
        <div class="loading">
            <img src="{{asset_app('assets/img/senddataloader.gif')}}" style="width:50px;height:50px">
        </div>
    </div>
<div class="row judul">
  <div class="col-md-12 px-0 header-detail">
    <div class="row">
      <div class="col-md-12 mb-2">
          <h2 class="d-block">{{$data->divisi}}</h2>
        <div class="row">
          <div class="col-md-12">
              <span class="d-block">
                <strong >Direktorat : </strong >
                <a href="{{route('direktorat.comsup',[$data->direktorat, 'cominit'])}}">
                    {{$data->direktorat == NULL ? 'Lainnya' : $data->direktorat}}
                </a>
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
    <div class="col-lg-12 col-md-8 col-sm-12 px-0 text-justify">
        <div>
            <div class="mt-4 mb-2 d-flex mx-auto flex-wrap">
                <a onclick="getDataComsupDiv()" id="btn-dir-init" role="button"
                   class="btn-com mt-2 mr-3 ">Communication Initiative</a>
                <a onclick="getDataStraDiv()"  id="btn-dir-stra" role="button"
                   class="btn-com mt-2 mr-3 ">Strategic Initiative</a>
                <a onclick="getDataImpl()"  id="btn-dir-impl" role="button"
                   class="btn-com mt-2 mr-3 ">Implementation</a>
            </div>
        </div>
        <div>
            <div class="input-group mb-2 h-100">
                <input type="text" style="width:20rem; border-radius: 8px 0 0 8px; border-color: #f0f0f0; border-style: solid;padding-left: 12px;border-right: none"
                       id="searchCominitDir" placeholder="Cari...">
                <div class="input-group-prepend">
                    <div onclick="searchCominitDir()" class="d-flex align-items-center justify-content-center" style="cursor:pointer;width:2rem; background: #f0f0f0; border-radius: 0 8px 8px 0;">
                        <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
        <div>
	    <div class="mt-3">
	        <div id="row-empty"></div>
	    </div>
            <div class="mt-3">
                <div id="title-artikel-dir"></div>
                <div class="row" id="row-artikel-div"></div>
            </div>
            <div class="mt-2">
                <div id="title-video-dir"></div>
                <div class="row" id="row-video-div"></div>
            </div>
            <div class="mt-2">
                <div id="title-logo-dir"></div>
                <div class="row" id="row-logo-div"></div>
            </div>
            <div class="mt-2">
                <div id="title-infographics-dir"></div>
                <div class="row" id="row-infographics-div"></div>
            </div>
            <div class="mt-2">
                <div id="title-transformation-dir"></div>
                <div class="row" id="row-transformation-div"></div>
            </div>
            <div class="mt-2">
                <div id="title-podcast-dir"></div>
                <div class="row" id="row-podcast-div"></div>
            </div>
            <div class="mt-2">
                <div id="title-instagram-dir"></div>
                <div class="row" id="row-instagram-div"></div>
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
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/page/divisis-comsup.js')}}"></script>
@endpush
