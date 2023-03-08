@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/my_project.css')}}">

    <style>
        .btn-outline-secondary:focus, .btn-outline-secondary:active {
            background-color: transparent;
            color: #6c757d;
            border-color: #6c757d;
        }
        .btn-outline-secondary.aktip:focus, .btn-outline-secondary.aktip:active {
            background-color: #0e3984!important;
            color: #FFFFFF;
            border-color: #6c757d;
        }
    </style>

@endpush

@push('page-script')
    <script src="{{asset_app('assets/js/page/view-implementation.js')}}"></script>
    <script src="{{asset_app('assets/js/script/document-imp.js')}}"></script>
@endpush

@section('breadcumb', 'Implementation')
@section('back', route('mycomsupport.implementation'))

@section('content')
    <input type="hidden" id="id_project" value="{{$data->id}}">
    <div class="row judul mt-4">
        <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
            <img src="{{asset('storage/'.$data->thumbnail)}}" alt="" id="prev_thumbnail" class="img-detail">
        </div>
        <div class="col-md-10 col-sm-12 pr-0 header-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 mb-2">
                    <div class="row d-flex justify-content-between">
                        <div class="mr-auto p-2">
                            <div class="px-0  d-min">
                                <a class="font-weight-bold" href="{{route('project.view',$data->project->slug)}}">
                                    <h2>{{!empty($data->title)?$data->title:"-"}}</h2>
                                </a>
                            </div>
                        </div>
                        <div class="p-2">
                            <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#berbagi">
                                <i class="fas fa-share-alt mr-1"></i> Berbagi
                            </button>
                        </div>
                        <div class="p-2">
                            <button class="btn btn-outline-secondary {{$favorite == 1 ? 'aktip' : ''}}" onclick="saveFavCom(this, {{$data->id}})"><i class="fas fa-star mr-1 {{$favorite == 1 ? 'gold' : ''}}" id="star"></i>Simpan</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <span class="d-block font-weight-bold">Konsultan</span>
                            @php $last = end($data->consultant); @endphp
                            @forelse ($data->project->consultant as $consultant)
                                @if ($consultant == $last)
                                    <a href="{{route('consultant.index',$consultant->id)}}" class="fs-10"><span>{{$consultant->nama}}</span></a>
                                @else
                                    <a href="{{route('consultant.index',$consultant->id)}}" class="fs-10"><span>{{$consultant->nama}},</span></a>
                                @endif
                            @empty
                                <a href="#"><span>-</span></a>
                            @endforelse
                        </div>
                        <div class="col-md-5 col-sm-6 justify-content-end">
                            <span class="d-block font-weight-bold">Project Manager</span>
                            <span>{{!empty($data->project_managers->nama)?$data->project_managers->nama:"(Tidak ada data)"}}</span>
                            <small class="d-block">
                                <i class="far fa-envelope"></i>
                                <a href="{{!empty($data->project_managers->email)?"mailto:".$data->project_managers->email:"#"}}">{{!empty($data->project_managers->email)?\Str::limit($data->project_managers->email,20):"(Tidak ada data)"}}</a>
                            </small>
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
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="row">
                <h6 class="font-weight-bolder">Detail</h6>
            </div>
            <div class="row">
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Direktorat</div>
                    <div class="col-md-8 px-0  d-min"><a class="font-weight-bold" href="{{route('direktorat.comsup',[$data->project->divisi->direktorat, 'implementation'])}}">{{$data->project->divisi->direktorat}}</a></div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Pemilik Proyek</div>
                    <div class="col-md-8 px-0  d-min"><a class="font-weight-bold" href="{{route('divisi.comsup',['implementation', $data->project->divisi->id])}}">{{$data->project->divisi->divisi}}</a></div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Tanggal Mulai</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">{{date('d F Y', strtotime($data->tanggal_mulai))}}</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Tanggal Selesai</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">
                        @if($data->project->status_finish == 0)
                            -
                        @else
                            {{date('d F Y', strtotime($data->tanggal_selesai))}}
                        @endif
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Status</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">
                        @if($data->project->status_finish == 0)
                            On Progress
                        @else
                            Selesai
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <h6 class="font-weight-bolder">Tags</h6>
            </div>
            <div class="row col-md-12 px-0 font-weight-normal mb-4">
                @if($data->project->keywords)
                    @foreach ($data->project->keywords as $tag)
                        <span class="badge badge-cyan-light text-dark mr-1 mb-2">{{$tag->nama}}</span>
                    @endforeach
                @else
                    <span class="badge badge-cyan-light text-dark mr-1">-</span>
                @endif
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify metodologi">
            <br/>
            <div class="row">
                @if($data->desc_piloting && $data->status_piloting == 'publish')
                    <div class="col-md-12 d-block w-100 mb-4 mt-2">
                        <div style="background-color: #0a53be; border-radius: 5px; padding: 8px;">
                            <h6 class="text-white" style="margin: auto 0">Piloting</h6>
                        </div>
                        <div class="metodologi-isi wrap"><p>{!! !empty($data->desc_piloting)?$data->desc_piloting:"-"!!}</p></div>
                    </div>
                    <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-9">
                                <form action="" class="w-100" id="search-pilot">
                                    <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text border-0"><i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                        </div>
                                        <input type="text" style="border: none;" class="form-control" id="inlineFormInput-search-pilot" placeholder="Search files..">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                                <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive-piloting" onclick="archive('piloting')" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                                <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file-pilot">
                                    <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                    <option value="nama">Nama</option>
                                    <option value="created_at">Date Modified</option>
                                    <option value="size">Size</option>
                                </select>
                                <div class="cur-point" id="sort-pilot"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-2" onchange='allCheckChange(`piloting`);' id="allcheck-piloting">Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow-piloting">
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @if($data->desc_roll_out && $data->status_roll_out == 'publish')
                    <div class="col-md-12 d-block w-100 mb-4 mt-2">
                        <div style="background-color: #0a53be; border-radius: 5px; padding: 8px;">
                            <h6 class="text-white" style="margin: auto 0">Roll-Out</h6>
                        </div>
                        <div class="metodologi-isi wrap"><p>{!! !empty($data->desc_roll_out)?$data->desc_roll_out:'-' !!}</p></div>
                    </div>
                    <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-9">
                                <form action="" class="w-100" id="search-roll">
                                    <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text border-0"><i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                        </div>
                                        <input type="text" style="border: none;" class="form-control" id="inlineFormInput-search-roll" placeholder="Search files..">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                                <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive-rollout" onclick="archive('rollout')" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                                <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file-roll">
                                    <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                    <option value="nama">Nama</option>
                                    <option value="created_at">Date Modified</option>
                                    <option value="size">Size</option>
                                </select>
                                <div class="cur-point" id="sort-roll"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-2" onchange='allCheckChange(`rollout`);' id="allcheck-rollout">Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow-rollout">
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @if($data->desc_sosialisasi && $data->status_sosialisasi == 'publish')
                    <div class="col-md-12 d-block w-100 mb-4 mt-2">
                        <div style="background-color: #0a53be; border-radius: 5px; padding: 8px;">
                            <h6 class="text-white" style="margin: auto 0">Sosialisasi</h6>
                        </div>
                        <div class="metodologi-isi wrap"><p>{!! !empty($data->desc_sosialisasi)?$data->desc_sosialisasi:'-' !!}</p></div>
                    </div>
                    <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-9">
                                <form action="" class="w-100" id="search-sos">
                                    <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text border-0"><i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                                        </div>
                                        <input type="text" style="border: none;" class="form-control" id="inlineFormInput-search-sos" placeholder="Search files..">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                                <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive-sosialisasi" onclick="archive('sosialisasi')" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                                <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file-sos">
                                    <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                    <option value="nama">Nama</option>
                                    <option value="created_at">Date Modified</option>
                                    <option value="size">Size</option>
                                </select>
                                <div class="cur-point" id="sort-sos"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-2" onchange='allCheckChange(`sosialisasi`);' id="allcheck-sosialisasi">Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow-sosialisasi">
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="w-100" id="popupin">
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
                                    <input type="hidden" class="form-control" style="border: none;" value="Eh, liat ini deh. {{!empty($data->title)?$data->title:"-"}} di BRIKNOW. &nbsp;{{URL::current()}}" id="generate">
                                    <input type="text" class="form-control form-link-bagikan" id="link" readonly="">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn copy-link" onclick="kopas()">
                                            <i class="fas fa-paste"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('popup')
    </div>
@endsection
