@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/my_implementation.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}"> --}}

@endpush

{{-- @push('page-script')
    <script src="{{asset_app('assets/js/page/mproject.js')}}"></script>
@endpush --}}

@section('breadcumb', 'My Implementation')
@section('back', route('home'))

@section('content')
  <div class="row judul">
    <div class="col-md-12 px-0 header-detail">
      <div class="row px-2">
        <div class="col md-12">
          @if (session('role') != 0)
            <h3>Pending Request</h3>
          @else
            <h3>My Implementation</h3>
          @endif
        </div>
      </div>
    </div>
    @if (Session::has('success'))
                    <div class="col-md-12">            
                        <div class="alert alert-success alert-dismissible show fade pb-1">
                            <div class="alert-body mb-2">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                <small>
                                    {!!session()->get('success')!!}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible show fade pb-1">
                            <div class="alert-body mb-2">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                <small>
                                    {!!session()->get('error')!!}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($data))                
                    <div class="table-responsive">
                        <table class="table table-main">
                            <thead class="thead-light">
                            <tr>
                                <th style="border-left: 1px solid rgb(245 245 245); border-top-left-radius: 12px;">No</th>
                                <th style="width: 200px;">title Proyek</th>
                                <th>Direktorat</th>
                                <th>Pemilik Proyek</th>
                                <th>Tahun Proyek</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Restricted</th>
                                <th style="border-right: 1px solid rgb(245 245 245); border-top-right-radius: 12px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = ($data->currentPage() * 10)-9;
                            @endphp
                            @forelse ($data as $item)     
                                @php
                                    if ($item->tanggal_selesai) {
                                        $tanggal_selesai = strtotime($item->tanggal_selesai);
                                        $tahun_selesai = date('Y', $tanggal_selesai);
                                    } else {
                                        $tahun_selesai = "On Going";
                                    }

                                    $created_at = strtotime($item->created_at);
                                    $tgl_mulai = date('d/m/Y', $created_at);

                                    if ($item->status == "draft") {
                                        $status = "Draft";
                                    }elseif ($item->status == "review") {
                                        $status = "Pending Checker";
                                    }elseif ($item->status == "checked") {
                                        $status = "Pending Signer";
                                    }elseif ($item->status == "approve") {
                                        $status = "Pending Admin";
                                    }elseif ($item->status == "publish") {
                                        $status = "Published";
                                    }elseif ($item->status == "unpublish") {
                                        $status = "Unpublished";
                                    }elseif ($item->status == "reject") {
                                        $status = "Rejected";
                                    }

                                    if ($item->is_restricted == 1) {
                                        $is_restricted = "Ya";
                                    } else {
                                        $is_restricted = "Tidak";
                                    }
                                @endphp
                                <tr class="py-2">   
                                    <td class="corner-left">{{$i++}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->project->divisi->direktorat}}</td>
                                    <td>{{$item->project->divisi->divisi}}</td>
                                    <td>{{$tahun_selesai}}</td>
                                    <td>{{$status}}</td>
                                    <td class="text-primary">{{$tgl_mulai}}</td>
                                    <td>{{$is_restricted}}</td>
                                    @if(session::get('role') == 0)
                                        @if($item->status == 'reject')
                                        {{-- MODAL CATATAN REJECT --}}
                                        <div class="modal fade" id="modal_note" tabindex="-1" aria-labelledby="note" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        @if ($item->r_note1)
                                                            <h5 class="modal-title" id="note_title">Catatan Checker</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{$item->r_note1}}
                                                            </div>
                                                        @elseif($item->r_note2)
                                                            <h5 class="modal-title" id="note_title">Catatan Signer</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{$item->r_note2}}
                                                            </div>
                                                        @else
                                                            <h5 class="modal-title" id="note_title">Catatan</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                Tidak ada catatan.
                                                            </div>
                                                        @endif
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <td class="corner-right">
                                            <div class="d-flex">
                                                <a class="btn btn-primary btn-sm text-small text-white mr-1" data-toggle="modal" data-target="#modal_note" role="button"><small class="d-flex align-items-center" style="cursor: pointer;"><i class="fas fa-sticky-note pr-1"></i>NOTE</small></a>
                                                <a class="btn btn-primary btn-sm text-small text-white" onclick="views({{$item->id}})" role="button"><small class="d-flex align-items-center" style="cursor: pointer;"><i class="fas fa-eye pr-1"></i>VIEW</small></a>
                                            </div>
                                        </td>
                                        @else
                                            <td class="corner-right"><a class="btn btn-primary btn-sm text-small text-white" onclick="views({{$item->id}})" role="button"><small class="d-flex align-items-center" style="cursor: pointer;"><i class="fas fa-eye pr-1"></i>VIEW</small></a></td>
                                        @endif
                                    @else
                                        <td class="corner-right">
                                            <a href="#" id="dropdownMenuLink" style="text-decoration: none; color: black;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                •••
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <button class="btn dropdown-item" onclick="views({{$item->id}})">
                                                    <i class="fas fa-eye mr-2"></i>View
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty                        
                                <tr class="py-2">
                                    <td class="corner-left corner-right" colspan="9">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <div>
                            {{$data->links()}}
                        </div>
                    </div>
                @elseif(!Session::has('error'))
                    <div class="col-md-12 pt-2">
                        <span>Anda belum memiliki project.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg modal-preview" id="modalpreview" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
            <div class="modal-content content-preview bg-transparent" style="z-index: -1">
                <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                    <div class="bg-white bg-white w-100 content-preview">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
      {{-- {{ dd($data) }} --}}
      
      {{-- <div class="table-responsive" id="review">
        <table class="table" id="table-init">
          <thead class="thead-light text-left justify-content-start align-content-start">
            <tr>
              <th class="text-center" id="th-line">Judul</th>
              <th class="text-center" id="th-line">Direktorat</th>
              <th class="text-center" id="th-line">Divisi</th>
              <th class="text-center" id="th-line">Tanggal</th>
              <th class="text-center" id="th-line">Status</th>
              <th class="text-center" id="th-line">Action</th>
            </tr>
          </thead>
          @if(session('role') == 0)
          <tbody class="text-left justify-content-start align-content-start" id="content-table-body">
          </tbody>
          @else
          <tbody class="text-left justify-content-start align-content-start" id="table-body-user">
          </tbody>
          @endif
        </table>
        <div class="d-flex justify-content-sm-end content-pagination" id="pag">
        </div>
      </div> --}}

    </div>
  </div>
@endsection
@section('popup')
<div class="modal fade bd-example-modal-lg modal-preview" id="modal-preview-1" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100" id="content-preview-desc">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-script')
    <script>
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    </script>
    <script src="{{ asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset_app('assets/js/page/myimplementation.js') }}"></script>
@endpush
