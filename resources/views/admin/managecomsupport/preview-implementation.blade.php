<div class="navbar-bg sticky-top navbar-gray bg-gray pr-0 mr-0" style="height: 80px">
    <div class="d-flex justify-content-between header-nav">
        <div class="d-flex align-items-center px-4">
            <button type="button" class="close d-inline bg-tranparent text-light" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div>
            <nav class="prev-navbar navbar navbar-expand-lg main-navbar">
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="cardbg-white bg-white w-100 px-3 pb-5">
    @if ($data->project)
        @php $project = $data->project; @endphp
    @endif
    <div class="row judul mt-4" style="min-height: 185px;">
        <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
            <img src="{{Config::get('app.url').'storage/'.$project->thumbnail}}" alt="" onerror="imgError(this)" id="prev_thumbnail" class="img-detail">
        </div>
        <div class="col-md-10 col-sm-12 pr-0 header-detail">
            <div class="row mt-4">
                <div class="col-md-8 col-sm-12 mb-2">
                    <div class="col-sm-12 px-0">
                        <a href="{{route('project.index',$project->slug)}}" class="d-block font-weight-bold" style="font-size: 1.8rem; width: fit-content;margin-bottom: 0.5rem;line-height: 1.2;" id="prev_namaproject">{{!empty($project->nama)?$project->nama:"-"}}</a>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6" id="prev_const">
                            <span class="d-block font-weight-bold">Konsultan</span>
                            @if ($project->consultant)
                                @php $consultants = $project->consultant; @endphp
                                @php $last = end($consultants); @endphp
                                @forelse ($consultants as $consultant)
                                    @if ($consultant == $last)
                                        <a href="{{route('consultant.index',$consultant->id)}}" class="fs-10"><span>{{$consultant->nama}}</span></a>
                                    @else
                                        <a href="{{route('consultant.index',$consultant->id)}}" class="fs-10"><span>{{$consultant->nama}},</span></a>
                                    @endif
                                @empty
                                    <div><span>-</span></div>
                                @endforelse
                            @else
                                <div class="konsultan"><span>-</span></div>
                            @endif
                        </div>
                        <div class="col-md-5 col-sm-6 justify-content-end">
                            <span class="d-block font-weight-bold">Project Manager</span>
                            <span id="prev_pm"><span>{{!empty($data->project_managers->nama)?$data->project_managers->nama:"(Tidak ada data)"}}</span></span>
                            <small class="d-block fs-12">
                                <i class="far fa-envelope"></i>
                                <a href="{{!empty($data->project_managers->email)?"mailto:".$data->project_managers->email:"#"}}" id="prev_emailpm">{{!empty($data->project->project_managers->email)?\Str::limit($data->project_managers->email,20,'..'):"(Tidak ada data)"}}</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row judul">
        <hr width="100%"/>
    </div>

    <div class="row judul">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="row">
                <h6 class="font-weight-bolder">Detail</h6>
            </div>
            <div class="row">
                @php $divisi = $project->divisi; @endphp
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Direktorat</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min" id="prev_direktorat">
                        <a class="font-weight-bold" href="{{route('divisi',$divisi->id)}}">
                            {{$divisi->direktorat}}
                        </a>
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Pemilik Proyek</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min" id="prev_divisi">
                        <a class="font-weight-bold" href="{{route('divisi',$divisi->id)}}">
                            {{$divisi->divisi}}
                        </a>
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Tanggal Mulai</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_tglmulai">
                        {{date('d F Y', strtotime($data->tanggal_mulai))}}
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Tanggal Selesai</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_tglselesai">
                        @if ($data->tanggal_selesai)
                            {{date('d F Y', strtotime($data->tanggal_selesai))}}
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Status</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_status">
                        @if ($data->tanggal_selesai)
                            Selesai
                        @else
                            On Progress
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <h6 class="font-weight-bolder">Tags</h6>
            </div>
            <div class="row col-md-12 px-0 font-weight-normal mb-4" id="prev_tag">
                @if($project->keywords)
                    @foreach ($project->keywords as $tag)
                        <a href="{{route('katalog.pencarian',$tag->nama)}}">
                            <span class="badge badge-cyan-light text-dark mr-1 mb-2">{{$tag->nama}}</span>
                        </a>
                    @endforeach
                @else
                    <span class="badge badge-cyan-light text-dark mr-1">-</span>
                @endif
            </div>

        </div>
        <input type="hidden" id="id_project" value="{{$data->id}}">
        <div class="col-lg-9 col-md-8 col-sm-12 pr-0 pl-4 text-justify">
            <div class="row" id="desc-preview">
                @if($data->desc_piloting)
                    <div class="col-md-12 d-block w-100 mb-4 mt-2">
                        <div class="preview-desc-head">Piloting</div>
                        <div class="metodologi-isi wrap" id="prev_deskripsi">{{strip_tags($data->desc_piloting)}}</div>
                    </div>
                    <div class="col-md-12 d-block w-100">
                        <h6>Attachment</h6>
                    </div>
                    <div class="col-md-12 d-block w-100" style="margin-bottom: 4rem">
                        <div class="row">
                            <div class="col-md-9">
                                <form action="" class="w-100" id="search-pilot">
                                    <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text border-0" style="height: 30px"><i class="fa fa-search" aria-hidden="true"></i>
                                        </span>
                                        </div>
                                        <input type="text" style="border: none;height: 30px" class="form-control" id="inlineFormInput-search-pilot" placeholder="Search files..">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                                <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive-piloting" onclick="archive('piloting', {{$data->id}})" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                                <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file-pilot">
                                    <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                    <option value="nama">Nama</option>
                                    <option value="created_at">Date Modified</option>
                                    <option value="size">Size</option>
                                </select>
                                <div class="cur-point" id="sort-pilot"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-sm" id="table-attachment" style="table-layout: fixed; border-radius: 8px">
                                    <thead>
                                    <tr>
                                        <th id="th-attachment" style="font-size: 14px; width: 70%;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;"><input type="checkbox" class="mr-2" onchange='allCheckChange(`piloting`);' id="allcheck-piloting">Files</th>
                                        <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Date Modified</th>
                                        <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Size</th>
                                    </tr>
                                    </thead>
                                    <tbody id="coloumnrow-piloting">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if($data->desc_roll_out)
                        <div class="col-md-12 d-block w-100 mb-4 mt-2">
                            <div class="preview-desc-head">Roll-Out</div>
                            <div class="metodologi-isi wrap" id="prev_deskripsi">{{strip_tags($data->desc_roll_out)}}</div>
                        </div>
                        <div class="col-md-12 d-block w-100">
                            <h6>Attachment</h6>
                        </div>
                        <div class="col-md-12 d-block w-100" style="margin-bottom: 4rem">
                            <div class="row">
                                <div class="col-md-9">
                                    <form action="" class="w-100" id="search-roll">
                                        <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text border-0" style="height: 30px"><i class="fa fa-search" aria-hidden="true"></i>
                                        </span>
                                            </div>
                                            <input type="text" style="border: none;height: 30px" class="form-control" id="inlineFormInput-search-roll" placeholder="Search files..">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                                    <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive-rollout" onclick="archive('rollout', {{$data->id}})" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                                    <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file-roll">
                                        <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                        <option value="nama">Nama</option>
                                        <option value="created_at">Date Modified</option>
                                        <option value="size">Size</option>
                                    </select>
                                    <div class="cur-point" id="sort-roll"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-sm" id="table-attachment" style="table-layout: fixed; border-radius: 8px">
                                        <thead>
                                        <tr>
                                            <th id="th-attachment" style="font-size: 14px; width: 70%;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;"><input type="checkbox" class="mr-2" onchange='allCheckChange(`rollout`);' id="allcheck-rollout">Files</th>
                                            <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Date Modified</th>
                                            <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Size</th>
                                        </tr>
                                        </thead>
                                        <tbody id="coloumnrow-rollout">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                @endif

                @if($data->desc_sosialisasi)
                        <div class="col-md-12 d-block w-100 mb-4 mt-2">
                            <div class="preview-desc-head">Sosialisasi</div>
                            <div class="metodologi-isi wrap" id="prev_deskripsi">{{strip_tags($data->desc_sosialisasi)}}</div>
                        </div>
                        <div class="col-md-12 d-block w-100">
                            <h6>Attachment</h6>
                        </div>
                        <div class="col-md-12 d-block w-100" style="margin-bottom: 4rem">
                            <div class="row">
                                <div class="col-md-9">
                                    <form action="" class="w-100" id="search-sos">
                                        <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text border-0" style="height: 30px"><i class="fa fa-search" aria-hidden="true"></i>
                                        </span>
                                            </div>
                                            <input type="text" style="border: none;height: 30px" class="form-control" id="inlineFormInput-search-sos" placeholder="Search files..">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                                    <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive-sosialisasi" onclick="archive('sosialisasi', {{$data->id}})" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                                    <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file-sos">
                                        <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                        <option value="nama">Nama</option>
                                        <option value="created_at">Date Modified</option>
                                        <option value="size">Size</option>
                                    </select>
                                    <div class="cur-point" id="sort-sos"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-sm" id="table-attachment" style="table-layout: fixed; border-radius: 8px">
                                        <thead>
                                        <tr>
                                            <th id="th-attachment" style="font-size: 14px; width: 70%;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;"><input type="checkbox" class="mr-2" onchange='allCheckChange(`sosialisasi`);' id="allcheck-sosialisasi">Files</th>
                                            <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Date Modified</th>
                                            <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Size</th>
                                        </tr>
                                        </thead>
                                        <tbody id="coloumnrow-sosialisasi">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                @endif
            </div>
        </div>
    </div>

</div>
<script src="{{asset_app('assets/js/script/document-imp.js')}}"></script>
