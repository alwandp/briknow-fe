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
                                <a class="font-weight-bold">
                                    <h2>{{!empty($data->nama)?$data->nama:"-"}}</h2>
                                </a>
                            </div>
                        </div>
                        <div class="p-2">
                            <button class="btn btn-outline-secondary fa fa-share-alt"><span> Berbagi</span></button>
                        </div>
                        <div class="p-2">
                            <button class="btn btn-outline-secondary fa fa-star"><span> Simpan</span></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <span class="d-block font-weight-bold">Konsultan</span>
                            @php $last = end($data->consultant); @endphp
                            @forelse ($data->consultant as $consultant)
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
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Direktorat</div>
                    <div class="col-md-8 px-0  d-min"><a class="font-weight-bold" href="{{route('divisi',$data->divisi->id)}}">{{$data->divisi->direktorat}}</a></div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Pemilik Proyek</div>
                    <div class="col-md-8 px-0  d-min"><a class="font-weight-bold" href="{{route('divisi',$data->divisi->id)}}">{{$data->divisi->divisi}}</a></div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Tanggal Mulai</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">{{date('d F Y', strtotime($data->tanggal_mulai))}}</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Tanggal Selesai</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">
                        @if($data->status_finish == 0)
                            -
                        @else
                            {{date('d F Y', strtotime($data->tanggal_selesai))}}
                        @endif
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="col-md-4 px-0">Status</div>
                    <div class="col-md-8 px-0  d-min font-weight-bold">
                        @if($data->status_finish == 0)
                            On Progress
                        @else
                            Selesai
                        @endif
                    </div>
                </div>
            </div>

            Tags
            <div class="row mt-4">
                <h6 class="font-weight-bolder">Tags</h6>
            </div>
            <div class="row col-md-12 px-0 font-weight-normal mb-4">
                @if($data->keywords)
                    @foreach ($data->keywords as $tag)
                        <span class="badge badge-cyan-light text-dark mr-1 mb-2">{{$tag->nama}}</span>
                    @endforeach
                @else
                    <span class="badge badge-cyan-light text-dark mr-1">-</span>
                @endif
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify metodologi">
            <div class="row">
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <h6>Deskripsi</h6>
                    <div class="metodologi-isi wrap"><p>{!! !empty($data->deskripsi)?$data->deskripsi:"-"!!}</p></div>
                </div>
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <h6>Metodologi</h6>
                    <div class="metodologi-isi wrap"><p>{!! !empty($data->metodologi)?$data->metodologi:'-' !!}</p></div>
                </div>
                <div class="col-md-12 d-block w-100 mb-4">
                    <h6>Lesson Learned</h6>
                    <div class="table-responsive" id="table-responsive-metodologi">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <th id="th-metodologi" style="min-width: 20px;">No</th>
                            <th id="th-metodologi" style="min-width: 150px;">Nama Project</th>
                            <th id="th-metodologi" style="min-width: 150px;">Tahap Project</th>
                            <th id="th-metodologi" style="min-width: 350px;">Lesson Learned</th>
                            <th id="th-metodologi" style="min-width: 400px;">Detail Keterangan</th>
                            <th id="th-metodologi" style="min-width: 150px;"></th>
                            </thead>
                            <tbody class="text-center">
                            <?php $urut = 0; ?>
                            @forelse($data->lesson_learned as $value)
                                <?php $urut++; ?>
                                <tr>
                                    <td id="td-metodologi" style="text-align:center !important;"><span>{{$urut}}</span></td>
                                    <td id="td-metodologi"><span>{{$data->nama}}</span></td>
                                    <td id="td-metodologi"><span>{{$value->tahap}}</span></td>
                                    <td id="td-metodologi"><span>{{$value->lesson_learned}}</span></td>
                                    <td id="td-metodologi"><span>{{$value->detail}}</span></td>
                                    <td id="td-metodologi">
                                        <span>
                                            <div class="row">
                                                <button class="btn fas fa-share-alt grey pr-2"
                                                        style="font-size: 20px"></button>
                                                <button class="btn fas fa-star gold" style="font-size: 20px"></button>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td id="td-metodologi"><span>-</span></td>
                                    <td id="td-metodologi"><span>-</span></td>
                                    <td id="td-metodologi"><span>-</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <h6>Attachment</h6>
                    <div class="card-body p-0 mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="#" class="w-100" id="search">
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend">
                      <span class="input-group-text search-sm attr_input">
                          <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                      </span>
                                        </div>
                                        <input type="text" class="form-control search-sm" placeholder="Search files..." aria-describedby="inputGroup-sizing-sm" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-sm" id="table-attachment">
                            <thead>
                            <tr>
                                <th id="th-attachment"><input type="checkbox" class="mr-1" id="allcheck"> Files</th>
                                <th id="th-attachment">Date Modified</th>
                                <th id="th-attachment">Size</th>
                            </tr>
                            </thead>
                            <tbody id="coloumnrow">
                            @forelse($data->document as $value)
                                <tr class="rowdoc">
                                    <td id="td-attachment"><span>{{$value->nama}}</span></td>
                                    <td id="td-attachment"><span>{{\Carbon\carbon::create($value->updated_at)->format('d F Y')}}</span></td>
                                    <td id="td-attachment"><span>{{formatBytes($value->size)}}</span></td>
                                </tr>
                            @empty
                                <tr class="rowdoc">
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                    <td id="td-attachment"><span>-</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
