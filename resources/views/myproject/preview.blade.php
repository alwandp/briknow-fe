<div class="navbar-bg sticky-top navbar-gray bg-gray pr-0 mr-0 z-index-1 @isset($mode) py-3 @endisset">
  <div class="d-flex justify-content-between header-nav">
    <div class="d-flex align-items-center pl-3">
      <button type="button" class="close d-inline bg-tranparent text-light" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="control-preview">
        <input type="hidden" id="id_project" value="{{$data->id}}">
        <input type="hidden" id="project" value="project">
      @isset($mode)
      @else
        <nav class="w-100 navbar navbar-expand-lg main-navbar d-flex justify-content-end">
          <ul class="w-100 navbar-nav navbar-right">
            <li class="w-100 dropdown d-flex justify-content-end">
              @if($role == 0)
                @if($data->flag_mcs == 0 || $data->flag_mcs == null)
                  <a class="btn btn-light box-shadow-none btn-sm mx-1 text-decoration-none" onclick="urlSave()" href="{{route('kontribusi.edit',$data->slug)}}"><i class="fas fa-pencil-alt mr-1"></i>Edit</a>
                  <button class="btn btn-danger box-shadow-none btn-sm mx-1 text-decoration-none" onclick="hapus({{$data->id}})"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
                  <button class="btn btn-success box-shadow-none btn-sm mx-1 text-decoration-none" onclick="send({{$data->id}})"><i class="fas fa-paper-plane mr-1"></i> Send</button>
                @elseif ($data->flag_mcs == 7)
                  <button class="btn btn-danger box-shadow-none btn-sm mx-1 text-decoration-none" onclick="hapus({{$data->id}})"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
                  <a class="btn btn-light box-shadow-none btn-sm mx-1 text-decoration-none" onclick="urlSave()" href="{{route('kontribusi.edit',$data->slug)}}"><i class="fas fa-pencil-alt mr-1"></i>Edit</a>
                @else
                    <i class="fas fa-info-circle text-white information mr-1 m-2 float-right" id="information-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;"></i>
                    <div class="dropdown-menu w-100 px-2 table-responsive" aria-labelledby="information-dropdown">
                      <div class="stepwizard align-items-center">
                        @if($data->flag_mcs == 1)
                          <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step s2 stepwizard-step-garis">
                                <a href="#step-1" id="s-1" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Checker</p>
                            </div>
                            <div class="stepwizard-step s3 stepwizard-step-garis">
                                <a href="#step-2" id="s-2" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Signer</p>
                            </div>
                            <div class="stepwizard-step s4 stepwizard-step-garis">
                                <a href="#step-3" id="s-3" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Admin</p>
                            </div>
                            <div class="stepwizard-step s5">
                                <a href="#step-3" id="s-4" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Publish</p>
                            </div>
                          </div>
                        @elseif($data->flag_mcs == 2)
                          <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step s2 stepwizard-step-success">
                                <a href="#step-1" id="s-1" class="btn bunderan btn-success btn-circle reguler">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Checker</p>
                            </div>
                            <div class="stepwizard-step s3 stepwizard-step-garis">
                                <a href="#step-2" id="s-2" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Signer</p>
                            </div>
                            <div class="stepwizard-step s4 stepwizard-step-garis">
                                <a href="#step-3" id="s-3" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Admin</p>
                            </div>
                            <div class="stepwizard-step s5">
                                <a href="#step-3" id="s-4" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Publish</p>
                            </div>
                          </div>
                        @elseif($data->flag_mcs == 3)
                          <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step s2 stepwizard-step-success">
                                <a href="#step-1" id="s-1" class="btn bunderan btn-success btn-circle reguler">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Checker</p>
                            </div>
                            <div class="stepwizard-step s3 stepwizard-step-success">
                                <a href="#step-2" id="s-2" class="btn bunderan btn-success btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Signer</p>
                            </div>
                            <div class="stepwizard-step s4 stepwizard-step-garis">
                                <a href="#step-3" id="s-3" class="btn bunderan btn-default btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Admin</p>
                            </div>
                            <div class="stepwizard-step s5">
                                <a href="#step-3" id="s-4" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Publish</p>
                            </div>
                          </div>
                        @elseif($data->flag_mcs == 4)
                          <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step s2 stepwizard-step-success">
                                <a href="#step-1" id="s-1" class="btn bunderan btn-success btn-circle reguler">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Checker</p>
                            </div>
                            <div class="stepwizard-step s3 stepwizard-step-success">
                                <a href="#step-2" id="s-2" class="btn bunderan btn-success btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Signer</p>
                            </div>
                            <div class="stepwizard-step s4 stepwizard-step-success">
                                <a href="#step-3" id="s-3" class="btn bunderan btn-success btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Admin</p>
                            </div>
                            <div class="stepwizard-step s5">
                                <a href="#step-3" id="s-4" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Publish</p>
                            </div>
                          </div>
                        @elseif($data->flag_mcs == 5)
                          <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step s2 stepwizard-step-success">
                                <a href="#step-1" id="s-1" class="btn bunderan btn-success btn-circle reguler">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Checker</p>
                            </div>
                            <div class="stepwizard-step s3 stepwizard-step-success">
                                <a href="#step-2" id="s-2" class="btn bunderan btn-success btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Signer</p>
                            </div>
                            <div class="stepwizard-step s4 stepwizard-step-success">
                                <a href="#step-3" id="s-3" class="btn bunderan btn-success btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Admin</p>
                            </div>
                            <div class="stepwizard-step s5">
                                <a href="#step-3" id="s-4" class="btn bunderan btn-success btn-circle reguler" style="pointer-events: none">&nbsp;</a>
                                <p class="ket my-0 text-secondary">Publish</p>
                            </div>
                          </div>
                        @endif
                      </div>
                      <hr class="my-1">
                      <div class="d-flex justify-content-between">
                          <div class="f-60 text-secondary">
                            @if($data->flag_mcs == 2 || $data->flag_mcs == 3 || $data->flag_mcs == 4 || $data->flag_mcs == 5)
                              {{\Carbon\carbon::create($data->checker_at)->format('d F Y, H.i') ?? '-'}}
                            @else
                              {{"-"}}
                            @endif
                          </div>
                          <div class="font-weight-bolder f-60">
                            Checker
                          </div>
                      </div>
                      <hr class="my-1">
                      <div class="d-flex justify-content-between">
                          <div class="f-60 text-secondary">
                            @if($data->flag_mcs == 3 || $data->flag_mcs == 4 || $data->flag_mcs == 5)
                              {{\Carbon\carbon::create($data->signer_at)->format('d F Y, H.i') ?? '-'}}
                            @else
                              {{"-"}}
                            @endif
                          </div>
                          <div class="font-weight-bolder f-60">
                            Signer
                          </div>
                      </div>
                      <hr class="my-1">
                      <div class="d-flex justify-content-between">
                          <div class="f-60 text-secondary">
                            @if($data->flag_mcs == 4 || $data->flag_mcs == 5)
                              {{\Carbon\carbon::create($data->review_at)->format('d F Y, H.i') ?? '-'}}
                            @else
                              {{"-"}}
                            @endif
                          </div>
                          <div class="font-weight-bolder f-60">
                            Admin
                          </div>
                      </div>
                      <hr class="my-1">
                      <div class="d-flex justify-content-between">
                          <div class="f-60 text-secondary">
                            @if($data->flag_mcs == 5)
                              {{\Carbon\carbon::create($data->publish_at)->format('d F Y, H.i') ?? '-'}}
                            @else
                              {{"-"}}
                            @endif
                          </div>
                          <div class="font-weight-bolder f-60">
                            Publish
                          </div>
                      </div>
                    </div>
                @endif
              @elseif($role == 3)
                  @if($data->flag_mcs == 5)
                    <a class="btn btn-light box-shadow-none btn-sm mx-1 text-decoration-none" onclick="urlSave()" href="{{route('kontribusi.edit',$data->slug)}}"><i class="fas fa-pencil-alt mr-1"></i>Edit</a>
                  @elseif ($data->flag_mcs != 5)
                    <button class="btn btn-success box-shadow-none btn-sm mx-1 text-decoration-none" onclick="appr({{$data->id}}, 2)">Approve & Publish</button>
                    <a class="btn btn-light box-shadow-none btn-sm mx-1 text-decoration-none" onclick="urlSave()" href="{{route('kontribusi.edit',$data->slug)}}"><i class="fas fa-pencil-alt mr-1"></i>Edit</a>
                  @endif
              @elseif ($role == 1)
                <button class="btn btn-success box-shadow-none btn-sm mx-1 text-decoration-none" onclick="appr({{$data->id}}, 1)">Approve</button>
                <button class="btn btn-danger box-shadow-none btn-sm mx-1 text-decoration-none" onclick="reject({{$data->id}})">Reject</button>
              @elseif ($role == 2)
                <button class="btn btn-success box-shadow-none btn-sm mx-1 text-decoration-none" onclick="appr({{$data->id}}, 1)">Approve</button>
                <button class="btn btn-danger box-shadow-none btn-sm mx-1 text-decoration-none" onclick="reject({{$data->id}})">Reject</button>
              @else
                <button class="btn btn-success box-shadow-none btn-sm mx-1 text-decoration-none" onclick="appr({{$data->id}}, 1)">Approve</button>
                <button class="btn btn-danger box-shadow-none btn-sm mx-1 text-decoration-none" onclick="reject({{$data->id}})">Reject</button>
                <a class="btn btn-light box-shadow-none btn-sm mx-1 text-decoration-none" onclick="urlSave()" href="{{route('kontribusi.edit',$data->slug)}}"><i class="fas fa-pencil-alt mr-1"></i>Edit</a>
              @endif
            </li>
          </ul>
        </nav>
      @endisset
    </div>
  </div>
</div>
<div class="cardbg-white bg-white w-100 px-3 pb-5">
  <div class="row judul mt-4">
    <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
        <img src="{{Config::get('app.url').$data->thumbnail}}" alt="" id="prev_thumbnail" class="img-detail">
    </div>
    <div class="col-md-10 col-sm-12 pr-0 header-detail">
      <div class="row">
        <div class="col-md-8 col-sm-12 mb-2">
          <div class="col-sm-12 px-0">
            <h2 class="d-block">{{!empty($data->nama)?$data->nama:"-"}}</h2>
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

      {{-- Tags --}}
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
          <div class="metodologi-isi wrap"><p>{!! !empty($data->deskripsi)?strip_tags($data->deskripsi):"-"!!}</p></div>
        </div>
        <div class="col-md-12 d-block w-100 mb-4 mt-2">
          <h6>Metodologi</h6>
          <div class="metodologi-isi wrap"><p>{!! !empty($data->metodologi)?strip_tags($data->metodologi):'-' !!}</p></div>
        </div>
        <div class="col-md-12 d-block w-100 mb-4">
          <h6>Lesson Learned</h6>
          <div class="table-responsive" id="table-responsive-metodologi">
            <table class="table table-bordered">
                <thead class="text-center">
                    <th id="th-metodologi" style="min-width: 20px;">No</th>
                    <th id="th-metodologi" style="min-width: 400px;">Lesson Learned</th>
                    <th id="th-metodologi" style="min-width: 200px;">Tahap Proyek</th>
                    <th id="th-metodologi" style="min-width: 400px;">Detail Keterangan</th>
                </thead>
                <tbody class="text-center">
                  <?php $urut = 0; ?>
                  @forelse($data->lesson_learned as $value)
                  <?php $urut++; ?>
                    <tr>
                        <td id="td-metodologi" style="text-align:center !important;"><span>{{$urut}}</span></td>
                        <td id="td-metodologi"><span>{{$value->lesson_learned}}</span></td>
                        <td id="td-metodologi"><span>{{$value->tahap}}</span></td>
                        <td id="td-metodologi"><span>{{$value->detail}}</span></td>
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

              <div class="col-md-9">
                <form action="" class="w-100" id="search">
                    <div class="input-group control border-1 pencarian mb-3" style="border-radius: 8px">
                        <div class="input-group-prepend">
                                    <span class="input-group-text border-0"><i class="fa fa-search" aria-hidden="true"></i>
                                    </span>
                        </div>
                        <input type="text" style="border: none;" class="form-control" id="inlineFormInput-search" placeholder="Search files..">
                    </div>
                </form>
              </div>

              <div class="col-md-3 text-right mb-2 d-flex align-items-center">
                  <button class="btn btn-sm btn-secondary d-inline mr-2" id="btn-archive" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                  <select style="border-radius: 8px;padding: 4px 15px" class="form-control mr-2" id="select-file" name="select-file">
                      <option value="" selected disabled style="background-color: #CCCCCCCC">Sort by</option>
                      <option value="nama">Nama</option>
                      <option value="created_at">Date Modified</option>
                      <option value="size">Size</option>
                  </select>
                  <div id="sort" class="cur-point"><i class="fas fa-sort-amount-down-alt mr-2"></i></div>
              </div>

            </div>

            <table class="table table-sm" id="table-attachment" style="table-layout: fixed; border: solid rgba(0, 0, 0, 0.2) 2px">
              <thead>
                <tr>
                    <th id="th-attachment" style="font-size: 14px;width: 70%;border-bottom: solid rgba(0, 0, 0, 0.2) 1px !important;"><input type="checkbox" class="mr-1" id="allcheck"> Files</th>
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

<script src="{{asset_app('assets/js/script/document.js')}}"></script>
