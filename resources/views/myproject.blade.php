@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/my_project.css')}}">

@endpush

@push('page-script')
    <script src="{{asset_app('assets/js/page/mproject.js')}}"></script>
@endpush

@section('breadcumb', 'My Project')
@section('back', route('home'))

@section('content')
    <div class="row judul">
        <div class="col-md-12 px-0 header-detail">
            <div class="row px-2">
                <div class="col md-12">
                    @if (session('role') != 0)
                        <h3>Pending Request</h3>
                    @else
                        <h3>My Project</h3>
                    @endif
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
                                <th style="width: 200px;">Nama Proyek</th>
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

                                    if ($item->flag_mcs == 0) {
                                        $status = "Draft";
                                    }elseif ($item->flag_mcs == 1) {
                                        $status = "Pending Checker";
                                    }elseif ($item->flag_mcs == 2) {
                                        $status = "Pending Signer";
                                    }elseif ($item->flag_mcs == 3) {
                                        $status = "Pending Admin";
                                    }elseif ($item->flag_mcs == 4) {
                                        $status = "Review Admin";
                                    }elseif ($item->flag_mcs == 5) {
                                        $status = "Published";
                                    }elseif ($item->flag_mcs == 6) {
                                        $status = "Unpublished";
                                    }elseif ($item->flag_mcs == 7) {
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
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->divisi->direktorat}}</td>
                                    <td>{{$item->divisi->divisi}}</td>
                                    <td>{{$tahun_selesai}}</td>
                                    <td>{{$status}}</td>
                                    <td class="text-primary">{{$tgl_mulai}}</td>
                                    <td>{{$is_restricted}}</td>
                                    @if(session::get('role') == 0)
                                        @if($item->flag_mcs == 7)
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
                                                <a class="btn btn-primary btn-sm text-small text-white" onclick="views('{{$item->slug}}')" role="button"><small class="d-flex align-items-center" style="cursor: pointer;"><i class="fas fa-eye pr-1"></i>VIEW</small></a>
                                            </div>
                                        </td>
                                        @else
                                            <td class="corner-right"><a class="btn btn-primary btn-sm text-small text-white" onclick="views('{{$item->slug}}')" role="button"><small class="d-flex align-items-center" style="cursor: pointer;"><i class="fas fa-eye pr-1"></i>VIEW</small></a></td>
                                        @endif
                                    @else
                                        <td class="corner-right">
                                            <a href="#" id="dropdownMenuLink" style="text-decoration: none; color: black;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                •••
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <button class="btn dropdown-item" onclick="views('{{$item->slug}}')">
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
            <div class="modal-content content-preview bg-transparent">
                <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                    <div class="bg-white bg-white w-100 content-preview">
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
@endpush
