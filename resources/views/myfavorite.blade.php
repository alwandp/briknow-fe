@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
  <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
@endpush

@section('breadcumb', 'My Favorite')

@section('breadcumb', 'My Favorite')
@section('back', route('home'))

@section('content')
<div class="row judul">
    <div class="col-md-12 px-0 header-detail">
        <div class="row px-2">
            <div class="col-md-10 col-sm-10 col-xs-10 px-0">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" onclick="getData()" id="project-tab" data-toggle="tab" href="#project" role="tab" aria-controls="project" aria-selected="true">Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="getData2()" id="consultant-tab" data-toggle="tab" href="#consultant" role="tab" aria-controls="consultant" aria-selected="false">Consultant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="getData3()" id="comsupport-tab" data-toggle="tab" href="#comsupport" role="tab" aria-controls="comsupport" aria-selected="false">Communication Support</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 pl-0 border-bottom d-flex justify-content-end align-items-center">
                <div class="dropdown show">
                    <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Urutkan
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <button class="btn dropdown-item" id="az"><svg class="w-6 h-6 mr-2 centang2 float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>A - Z</button>
                        <button class="btn dropdown-item" id="za">
                            <svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path></svg>
                            Z - A
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="project" role="tabpanel" aria-labelledby="project-tab">
                <div class="row" id="list">
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
@endsection

@push('page-script')
  <script src="{{asset_app('assets/js/page/favorite.js')}}"></script>
@endpush