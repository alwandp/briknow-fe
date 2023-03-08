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
    <div class="row judul mt-4" style="min-height: 185px;">
        <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
            <img src="{{Config::get('app.url').'storage/'.$data->thumbnail}}" alt="" onerror="imgError(this)" id="prev_thumbnail" class="img-detail">
        </div>
        <div class="col-md-10 col-sm-12 pr-0 header-detail">
            <div class="row mt-4">
                <div class="col-md-8 col-sm-12 mb-2">
                    <div class="col-sm-12 px-0">
                        <h2 class="d-block" id="prev_namaproject">{{!empty($data->title)?$data->title:"-"}}</h2>
                    </div>
                    @php $type_list  = [
                            "article"           => "Articles",
                            "logo"              => "Icon, Logo, Maskot BRIVO",
                            "infographics"      => "Infographics",
                            "transformation"    => "Transformation Journey",
                            "podcast"           => "Podcast",
                            "video"             => "Video Content",
                            "instagram"         => "Instagram Content"];
                          $status_list = [
                              "review"      => "Review",
                              "approve"     => "Approved",
                              "reject"      => "Rejected",
                              "publish"     => "Published",
                              "unpublish"   => "Unpublished",];@endphp
                    <div class="row">
                        <div class="col-6">
                            <span class="d-block font-weight-bold" id="prev_type">{{!empty($data->type_file)?$type_list[$data->type_file] : "-"}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" id="prev_project">
                            <span class="d-block font-weight-bold">Parent Project</span>
                            @if ($data->project)
                                <a class="font-weight-bold fs-18 parent-project-desc" href="{{route('project.index',$data->project->slug)}}">{{$data->project->nama}}</a>
                            @else
                                <span class="parent-project-desc">General</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row judul">
        <hr width="100%"/>
        <input type="hidden" id="id_project" value="{{$data->id}}">
        <input type="hidden" id="project" value="content">
    </div>

    <div class="row judul">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="row">
                <h6 class="font-weight-bolder">Detail</h6>
            </div>
            <div class="row">
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Direktorat</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min" id="prev_direktorat">
                        @if ($data->project)
                            <a class="font-weight-bold" href="{{route('divisi',$data->project->divisi->id)}}">
                                {{$data->project->divisi->direktorat}}
                            </a>
                        @else
                            General
                        @endif
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Pemilik Proyek</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min" id="prev_divisi">
                        @if ($data->project)
                            <a class="font-weight-bold" href="{{route('divisi',$data->project->divisi->id)}}">
                                {{$data->project->divisi->divisi}}
                            </a>
                        @else
                            General
                        @endif
                    </div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Tanggal Upload</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_tglmulai">{{date('d F Y', strtotime($data->tanggal_upload))}}</div>
                </div>
                <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
                    <div class="col-md-4 px-0">Status</div>
                    <div class="col-md-1 pr-0 pl-3">:</div>
                    <div class="col-md-7 px-0 d-min font-weight-bold" id="prev_status">{{$status_list[$data->status]}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 pr-0 pl-4 text-justify">
            <div class="row" id="desc-preview">
                <div class="col-md-12 d-block w-100 mb-4 mt-2">
                    <div class="preview-desc-head">Caption</div>
                    <div class="metodologi-isi wrap" id="prev_deskripsi">{!! $data->desc !!}</div>
                </div>
                <div class="col-md-12 d-block w-100">
                    <h6>Attachment</h6>
                </div>
                <div class="col-md-12 d-block w-100" style="margin-bottom: 4rem">
                    <div class="row">
                        <div class="col-md-9">
                            <form action="" class="w-100" id="search">
                                <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0" style="height: 30px"><i class="fa fa-search" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <input type="text" style="border: none;height: 30px" class="form-control" id="inlineFormInput-search" placeholder="Search files..">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3 text-right mb-3 d-flex align-items-center">
                            <button class="btn btn-sm btn-secondary d-inline mr-2" style="height: 30px" id="btn-archive" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                            <select style="border-radius: 8px;padding: 4px 15px;height: 30px" class="form-control mr-2" id="select-file" name="select-file">
                                <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                                <option value="nama">Nama</option>
                                <option value="created_at">Date Modified</option>
                                <option value="size">Size</option>
                            </select>
                            <div id="sort" class="cur-point"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-sm" id="table-attachment" style="table-layout: fixed; border-radius: 8px">
                                <thead>
                                <tr>
                                    <th id="th-attachment" style="font-size: 14px; width: 70%;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;"><input type="checkbox" class="mr-2" id="allcheck">Files</th>
                                    <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Date Modified</th>
                                    <th id="th-attachment" style="font-size: 14px;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;">Size</th>
                                </tr>
                                </thead>
                                <tbody id="coloumnrow">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{--
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>--}}
<script src="{{asset_app('assets/js/script/document.js')}}"></script>
