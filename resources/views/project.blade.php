@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())
@push('style')
  <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/plugin/emoji/emojionearea.min.css')}}">
  <link rel="stylesheet" href="{{asset_app('assets/css/plugin/emoji/emojione-sprite-32.css')}}">
  <script type="text/javascript" src="{{asset_app('assets/js/plugin/emoji/emojione.min-3.1.js')}}"></script>
@endpush

@section('breadcumb', 'Project')
@section('back', route('katalog.index'))
@section('id_project', $data->id )

@section('content')
<div class="row judul">
    <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
        <?php
          if (file_exists(public_path('storage/'.$data->thumbnail))) {
              $data->thumbnail = config('app.url').'storage/'.$data->thumbnail;
          }else{
              $data->thumbnail = config('app.url').'assets/img/boxdefault.svg';
          }
        ?>
        <img src="{{$data->thumbnail}}" alt="" class="img-detail thumb">
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
                  <a href="#"><span>Internal</span></a>
                @endforelse
            </div>
            <div class="col-md-5 col-sm-6 text-right justify-content-end">
              <span class="d-block font-weight-bold">Project Manager</span>
              <span>{{!empty($data->project_managers->nama)?$data->project_managers->nama:"(Tidak ada data)"}}</span>
              <small class="d-block">
                <i class="far fa-envelope"></i>
                <a href="{{!empty($data->project_managers->email)?"mailto:".$data->project_managers->email:"#"}}">{{!empty($data->project_managers->email)?\Str::limit($data->project_managers->email,20,'..'):"(Tidak ada data)"}}</a>
              </small>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 d-flex justify-content-end">
          <div>
            <button class="btn btn-sm px-2 control rounded font-weight-normal m-1" data-toggle="modal" data-target="#berbagi"><i class="fas fa-share-alt mr-1"></i> Bagikan</button>
            @if ($is_favorit)
              <button class="btn btn-sm px-2 control rounded font-weight-normal m-1 aktip" id="btn-favoritproj"><i class="fas fa-star mr-1 gold" id="star"></i> Simpan</button>
            @else
              <button class="btn btn-sm px-2 control rounded font-weight-normal m-1" id="btn-favoritproj"><i class="far fa-star mr-1" id="star"></i> Simpan</button>
            @endif
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
        <div class="col-md-6 px-0">Pemilik Proyek</div>
        <div class="col-md-6 px-0  d-min"><a class="font-weight-bold" href="{{route('divisi',$data->divisi->id)}}">{{$data->divisi->divisi}}</a></div>
      </div>
      <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
        <div class="col-md-6 px-0">Tanggal Mulai</div>
        <div class="col-md-6 px-0  d-min font-weight-bold">@php  echo date('d F Y', strtotime($tgl_mulai)); @endphp</div>
      </div>
      <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
        <div class="col-md-6 px-0">Tanggal Selesai</div>
        <div class="col-md-6 px-0  d-min font-weight-bold">
          @if($data->status_finish == 0)
            -
          @else
            @php  echo date('d F Y', strtotime($tgl_selesai)); @endphp
          @endif
        </div>
      </div>
      <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
        <div class="col-md-6 px-0">Status</div>
        <div class="col-md-6 px-0  d-min font-weight-bold">
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
    <div class="row col-md-12 px-0 font-weight-normal mb-2">
      @if($data->keywords)
        @foreach ($data->keywords as $tag)
        <a href="{{route('katalog.pencarian',$tag->nama)}}">
          <span class="badge badge-cyan-light text-dark mr-1 mb-2">{{$tag->nama}}</span>
        </a>  
        @endforeach
      @else
        <span class="badge badge-cyan-light text-dark mr-1">-</span>
      @endif
    </div>
    <div class="row btn-comment col-md-12 px-0 mb-4">
      <div class="w-100">
        <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#staticBackdrop"><i class="far fa-comment-alt"></i> Comment</button>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify metodologi">
    <div class="row">
      <div class="col-md-12 d-block w-100 mb-4 metodologi-content">
        <h6>Deskripsi</h6>
        {!! !empty($data->deskripsi)?$data->deskripsi:"-"!!}
      </div>
      <div class="col-md-12 d-block w-100 mb-4 metodologi-content">
        <h6>Metodologi</h6>
        {!! !empty($data->metodologi)?$data->metodologi:'-' !!}
      </div>
      <div class="col-md-12 d-block w-100 mb-4">
        <h6>Lesson Learned</h6>
        <div class="table-responsive" id="table-responsive-metodologi">
          <table class="table table-bordered">
              <thead class="text-center">
                  <th id="th-metodologi" style="min-width: 20px;">No</th>
                  <th id="th-metodologi" style="min-width: 400px;">Lesson Learned</th>
                  <th id="th-metodologi" style="min-width: 400px;">Tahap Proyek</th>
                  <th id="th-metodologi" style="min-width: 400px;">Detail Keterangan</th>
              </thead>
              <tbody class="text-center">
                <?php $urut = 0; ?>
                @forelse($data->lesson_learned as $value)
                <?php $urut++; ?>
                  <tr>
                    <td id="td-metodologi" style="text-align:center !important;"><span>{{$urut}}</span></td>
                    <td id="td-metodologi" style="text-align:center !important;"><span>{{$value->lesson_learned}}</span></td>
                    <td id="td-metodologi" style="text-align:center !important;"><span>{{$value->tahap}}</span></td>
                    <td id="td-metodologi" class="text-center"><span>{{$value->detail}}</span></td>
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
      <div class="col-md-12 d-block w-100">
        <h6>Attachment</h6>
        @if($is_allowed == 0)
          <div class="row text-center h-100">
            <div class="col-md-12 text-center my-auto">
              <div class="card card-block d-flex restricted mt-2">
                <div class="col">
                  <i class="fas fa-eye-slash fa-flip-horizontal"></i>
                </div>
                <div class="card-body align-items-center d-flex justify-content-center">
                    <span>Files can not be viewed<br/>
                    Because the project is restricted.</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        @else
        <div class="card-body p-0 mt-2">
          <div class="row">
              <div class="col-md-10">
                <form action="#" class="w-100" id="search">
                  <div class="input-group input-group-sm mb-2">
                      <div class="input-group-prepend">
                          <span class="input-group-text">
                              <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                          </span>
                      </div>
                      <input type="text" class="form-control" placeholder="Search files..." aria-describedby="inputGroup-sizing-sm">
                  </div>
                </form>
              </div>
            <div class="col-md-2 text-right mb-2">
                <button class="btn btn-sm btn-secondary d-inline" id="btn-archive" disabled><i class="fa fa-download" aria-hidden="true"></i></button>
                <div class="dropdown show d-inline">
                    <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <button class="btn dropdown-item" id="baru"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Terbaru</button>
                      <button class="btn dropdown-item" id="lama"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Terlama</button>
                    </div>
                </div>
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
            </tbody>
          </table>
          </div>
        </div>
        <div id="prev"></div>
        @endif
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
                    <input type="hidden" class="form-control" style="border: none;" value="Eh, liat ini deh. {{!empty($data->nama)?$data->nama:"-"}} di BRIKNOW. &nbsp;{{URL::current()}}" id="generate">
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

  <!-- Modal -->
  <div class="modal fade m-comment" id="staticBackdrop" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable m-comment-dialog">
      <div class="modal-content m-comment-content">
        <div class="loadercomment">
          <div class="loading">
            <svg xmlns="http://www.w3.org/2000/svg" width="60px" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
              <rect x="17.5" y="30" width="15" height="40" fill="#1d3f72">
                <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="18;30;30" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.2s"></animate>
                <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="64;40;40" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.2s"></animate>
              </rect>
              <rect x="42.5" y="30" width="15" height="40" fill="#5699d2">
                <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="20.999999999999996;30;30" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.1s"></animate>
                <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="58.00000000000001;40;40" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.1s"></animate>
              </rect>
              <rect x="67.5" y="30" width="15" height="40" fill="#d8ebf9">
                <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="20.999999999999996;30;30" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate>
                <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="58.00000000000001;40;40" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate>
              </rect>
            </svg>
          </div>
        </div>
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-3 pb-5 comment-area">
          <div class="card shadow">
            <form action="#" class="form" onsubmit="komen(event,this,'',{{$data->id}},'');">
              <div class="card-header d-flex">
                <div>
                  <img alt="image" src="{{asset_app('assets/img/gamification/avatar/avatar '.session('avatar_id').'.png')}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                </div>
                <div class="pl-2">
                  <b>{{session('name')}}</b>
                </div>
              </div>
              <div class="px-3 pt-3">
                <textarea class="px-0 w-100 commentform" name="komentar" placeholder="Tulis komentar" data-emoji-input="unicode" data-emojiable="true" required></textarea>
              </div>
              <div class="d-flex justify-content-end px-3 py-2">
                <button type="submit" class="btn btn-primary btn-sm">Comment</button>
              </div>
            </form>
          </div>
          <hr>
          <?php $urut = 0; ?>
          @forelse($data->comment as $value)
            <?php $urut++; ?>
            <div id="comment-{{$urut}}">
              <div class="border-bottom pb-3">
                <a href="{{route('home.profileuser',$value->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                  <div class="d-flex px-0" id="header-comment">
                    <div>
                      @php $tempava = $value->user->avatar_id; @endphp
                      <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                    </div>
                    <div class="pl-2">
                      <b>{{$value->user->name??'-'}}</b>
                    </div>
                  </div>
                </a>
                <div class="px-0 pt-2">
                  @empty($value->reply_user)
                    <p id="comment-x">{!!$value->comment??'-'!!}</p>
                  @else
                    <p id="comment-x">{!!"<h6><span class='badge badge-secondary p-1 mr-1'>".$value->reply_user->name."</span></h6>"??''!!}{!!$value->comment??'-'!!}</p>
                  @endempty
                </div>
                <div class="px-0 w-100 d-flex justify-content-between reply-{{$urut}}">
                  <div>
                    @if(count($value->child) > 0)
                      <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut}}" onclick="showc('comment-{{$urut}}');">
                        <span class="label-handle-comment-{{$urut}}">
                          <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value->child)??0}} Replies
                        </span>
                      </button>
                    @endif
                  </div>
                  <button class="btn bg-white px-0 reply{{$urut}}" onclick="reply(this);" id="{{$urut}}" data-parent="{{$value->id}}" data-prj="{{$data->id}}" data-reply="{{$value->user->personal_number}}" style="text-decoration: none;">Reply</button>
                </div>
                <?php $urut2 = $urut; ?>
                @forelse($value->child as $value2)
                  <?php $urut2++; ?>
                  <div class="sub sub-comment-{{$urut}} comment-{{$urut2}} d-n">
                    <a href="{{route('home.profileuser',$value2->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                      <div class="d-flex px-0 pl-1" id="header-comment">
                        <div>
                          @php $tempava = $value2->user->avatar_id; @endphp
                          <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                        </div>
                        <div class="pl-2">
                          <b>{{$value2->user->name??'-'}}</b>
                        </div>
                      </div>
                    </a>
                    <div class="px-0 pl-1">
                      @empty($value2->reply_user)
                        <p id="comment-x">{!!$value2->comment??'-'!!}</p>
                      @else
                        <p id="comment-x">{!!"<span class='badge badge-secondary p-1 mr-1'>".$value2->reply_user->name."</span>"??''!!}{!!$value2->comment??'-'!!}</p>
                      @endempty
                    </div>
                    <div class="px-0 pl-1 w-100 d-flex justify-content-between reply-{{$urut2}}">
                      <div>
                        @if(count($value2->child) > 0)
                          <button class="btn bg-white px-0" type="button" id="handle-comment-{{$urut2}}" onclick="showc('comment-{{$urut2}}');">
                            <span class="label-handle-comment-{{$urut2}}">
                              <svg class="w-6 h-6" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{count($value2->child)??0}} Replies
                            </span>
                          </button>
                        @endif
                      </div>
                      <button class="btn bg-white reply{{$urut2}} px-0" onclick="reply(this);" id="{{$urut2}}" data-parent="{{$value2->id}}" data-prj="{{$data->id}}" data-reply="{{$value2->user->personal_number}}" style="text-decoration: none;">Reply</button>
                    </div>
                    <?php $urut3 = $urut2; ?>
                    @forelse($value2->child as $value3)
                      <?php $urut3++; ?>
                      <div class="sub sub-comment-{{$urut2}} comment-{{$urut3}} d-n">
                        <a href="{{route('home.profileuser',$value3->user->personal_number)}}" target="_blank" class="w-100 text-decoration-none text-dark">
                          <div class="d-flex px-0 pl-1" id="header-comment">
                            <div>
                              @php $tempava = $value3->user->avatar_id; @endphp
                              <img alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $tempava.png")}}" draggable="false" width="30px" class="rounded-circle icon-user-navbar mr-1">
                            </div>
                            <div class="pl-2">
                              <b>{{$value3->user->name??'-'}}</b>
                            </div>
                          </div>
                        </a>
                        <div class="px-0 pl-1">
                          @empty($value3->reply_user)
                            <p id="comment-x">{!!$value3->comment??'-'!!}</p>
                          @else
                            <p id="comment-x">{!!"<span class='badge badge-secondary p-1 mr-1'>".$value3->reply_user->name."</span>"??''!!}{!!$value3->comment??'-'!!}</p>
                          @endempty
                        </div>
                        <div class="px-0 pl-1 w-100 d-flex justify-content-between reply-{{$urut3}}">
                          <div></div>
                          <div></div>
                        </div>
                      </div>
                    @empty
                    @endforelse
                    <?php $urut2 = $urut3; ?>
                  </div>
                @empty
                @endforelse
              </div>
            </div>
            <?php $urut = $urut2; ?>
          @empty
            <div class="w-100 d-flex justify-content-center text-secondary">
              Belum Ada Komentar
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection

@push('page-script')
  <script>
    //CKEDITOR.replace( 'editor' );
    let a = document.getElementById("generate");
    var b = document.getElementById("link");
    b.value = a.value;

    function kopas() {
        var kopi = document.getElementById("link");
        kopi.select();
        kopi.setSelectionRange(0, 99999);
        document.execCommand("copy");
    }
  </script>
  <script src="{{asset_app('assets/js/page/project.js')}}"></script>
  <script type="text/javascript" src="{{asset_app('assets/js/plugin/emoji/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{asset_app('assets/js/plugin/emoji/jquery.textcomplete.js')}}"></script>
  <script type="text/javascript" src="{{asset_app('assets/js/plugin/emoji/emojionearea.min.js')}}"></script>
  <script>
    $(document).ready(function() {
        $(".commentform").emojioneArea({
          emojiPlaceholder: ":smile_cat:",
          searchPlaceholder: "Pencarian",
          buttonTitle: "Use your TAB key to insert emoji faster",
          searchPosition: "bottom",
          pickerPosition: "bottom",
          tonesStyle: "bullet"
        });
    })
  </script>
@endpush
