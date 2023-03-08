@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/profile.css')}}">
@endpush

@section('breadcumb', 'Profile')
@section('back', route('home'))

@section('content') 
    <div class="row judul">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 text-center d-flex justify-content-center">
                    <div>
                        <div class="relative top-min-20"> 
                            @isset($level)
                                @if($level <> 1)
                                    <img draggable='false' alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $data->avatar_id.png")}}" class="rounded-circle ava-frame ava-profile position-absolute">
                                    <img draggable='false' alt="image" src="{{asset_app("assets/img/frame/".$level.".png")}}" class="ava-profile position-relative">
                                @else
                                    <img draggable='false' alt="image" src="{{asset_app("assets/img/gamification/avatar/avatar $data->avatar_id.png")}}" class="rounded-circle ava-frame ava-profile">
                                @endif
                            @endisset
                            @if($data->id == session('id'))
                                <a href="{{route('home.achievement')}}" class="pop-edit text-decoration-none">
                                    <i class="fas fa-pencil-alt text-dark edit-profile-icon"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-10 d-flex align-items-center px-1">
                    <div>
                        <div>
                            <h3 id="nama-kanan">{{$data->name}}</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="pb-2">
                                <span class="font-weight-bold text-black header-direktorat">{{$data->divisis->direktorat == NULL ? 'Lainnya' : $data->divisis->direktorat}}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="pb-2">
                                <img draggable='false' alt="image" src="{{asset_app('assets/img/Group.png')}}" class="img-fluid pr-2">
                                <span><a href="{{url('/')}}/divisi/{{$data->divisis->id}}" id="divisi-kanan" style="text-decoration: none;">{{$data->divisis->divisi}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="w-100 pb-2">

        <div class="col-md-12 p-0">

            <div>
                <div class="card shadow">
                    <div class="card-body px-4">
                        <div class="d-flex justify-content-between">
                            <h6>Projects</h6>
                            @if ($data->id <> session('id'))
                                <a href="#" data-toggle="modal" data-target="#projectModal" style="text-decoration: none;">View All</a>
                            @else
                                <a href="{{route('myproject')}}" target="_blank" style="text-decoration: none;">View All</a>
                            @endif
                        </div>
                        <div class="row">
                            @php $pointer=0; @endphp
                            @forelse ($dataPrj as $prj)
                                @php $pointer++ @endphp
                                <div class="col-md-6 py-1">
                                    @if($prj->flag_mcs == 5)
                                        <a href="{{route('project.index', $prj->slug)}}" target="_blank" class="text-decoration-none text-dark">
                                    @endif
                                        <div class="card-body py-0 px-3 border rounded d-flex" style="cursor: pointer;">
                                            <div class="p-auto d-flex align-items-center">
                                                <img draggable='false' alt="image" src="{{asset_app('assets/img/icon.png')}}" class="img-fluid badge-logo">
                                            </div>
                                            <div class="pl-2 py-3 text-left flex-column align-items-center">
                                                <div>
                                                    <span id="badge-title"><b>{{$prj->nama}}</b></span>
                                                </div>
                                                <div>
                                                    <small id="badge-desc"><i>
                                                        @php $last = end($prj->consultant); @endphp
                                                        @forelse ($prj->consultant as $consultant)
                                                            @if ($consultant == $last)
                                                            {{$consultant->nama}}
                                                            @else 
                                                            {{$consultant->nama}},
                                                            @endif
                                                        @empty
                                                            <span>Internal</span>
                                                        @endforelse
                                                    </i></small>
                                                </div>
                                            </div>
                                        </div>
                                    @if($prj->flag_mcs == 5)
                                        </a>
                                    @endif
                                </div>
                                @if($pointer == 4)
                                    @break
                                @endif
                            @empty
                                <div class="col-md-12 py-1">
                                    <div class="card-body d-flex justify-content-center">
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center">
                                                <img draggable='false' alt="image" src="{{asset_app('assets/img/clarity_folder-open-line.png')}}" class="img-fluid badge-logo mr-2">
                                            </div>
                                            <div class="text-black-50">
                                                <div><b><i>No Projects</i></b></div>
                                                <span><i>You haven't uploaded any projects yet</i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="card shadow">
                    <div class="card-body px-4">
                        <h6>Activities</h6>
                        <div class="card-body py-0 px-3 border rounded">
                            <div class="row d-flex justify-content-between">
                                <div class="px-3 py-0 pt-2 text-left d-flex align-items-center">
                                    <div class="px-2">
                                        <h1>{{$dataAct->uploaded}}</h1>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>Projects Uploaded</span>
                                    </div>
                                </div>
                                <div class="px-3 py-0 pt-2 text-left d-flex align-items-center">
                                    <div class="px-2">
                                        <h1>{{$dataAct->published}}</h1>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>Projects Published</span>
                                    </div>
                                </div>
                                <div class="px-3 py-0 pt-2 text-left d-flex align-items-center">
                                    <div class="px-2">
                                        <h1>{{isset($data->achievement) ? count($data->achievement) : '0'}}</h1>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>Achievements</span>
                                    </div>
                                </div>
                                <div class="px-3 py-0 pt-2 text-left d-flex align-items-center">
                                    <div class="px-2">
                                        <h1>{{$count_avatar}}</h1>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>Avatar Unlocked</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex px-2 pt-2">
                            <div class="col-md-3 flex-column py-2">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center">
                                        <a href="#" data-toggle="modal" data-target="#modalhistory" style="text-decoration: none;">
                                            <img draggable='false' alt="image" src="{{asset_app($level_user->badge)}}" class="img pr-2">
                                        </a>
                                    </div>
                                    {{-- Menentukan nama ini belom, harus direlasiin kayanya di DB biar otomatis --}}
                                    <div>
                                        <a href="#" data-toggle="modal" data-target="#modalhistory" style="text-decoration: none;">
                                            <div id="grade-desc">{{$level_user->name}}</div>
                                            <span>{{$data->xp}} XP</span>
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <span class="fs-10">How can i collect XP and increase my level? <a href="{{route('home.game')}}" target="_blank"><u>Learn more</u></a> </span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="px-1">
                                    <div class="d-flex justify-content-start progress my-3 py-1">
                                        <div class="latar-progress" style="max-width: 35%;">
                                            <div class="progress-bar" role="progressbar" style="width: 0%" id="level1">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="latar-progress" style="max-width:35%;">
                                            <div class="progress-bar" role="progressbar" style="width: 0%" id="level2">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="latar-progress" style="max-width:30%;">
                                            <div class="progress-bar" role="progressbar" style="width: 0%" id="level3">
                                                &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-column align-items-center justify-content-start text-left">
                                            <img draggable='false' src="{{asset_app('assets/img/circle-xp.png')}}" alt="O" class="img-fluid circle-xp" id="junior">
                                        </div>
                                        <div class="flex-column align-items-center text-center">
                                            <img draggable='false' src="{{asset_app('assets/img/circle-xp.png')}}" alt="O" class="img-fluid circle-xp" id="master">
                                        </div>
                                        <div class="flex-column align-items-center text-left">
                                            <img draggable='false' src="{{asset_app('assets/img/circle-xp.png')}}" alt="O" class="img-fluid circle-xp" id="grandmaster">
                                        </div>
                                        <div class="flex-column align-items-center text-right">
                                            <img draggable='false' src="{{asset_app('assets/img/circle-xp.png')}}" alt="O" class="img-fluid circle-xp" id="legendary">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between content-levelling">
                                    @php
                                        $first = reset($dataLevel);
                                        $last = end($dataLevel);
                                        $i = 0;
                                        $tampung_max_level = [];
                                    @endphp
                                    @forelse ($dataLevel as $level)
                                        @php
                                            $tampung_max_level[$i]  =   $level->xp;
                                        @endphp

                                        @if($dataLevel == $first)
                                            <div class="flex-column align-items-center text-left" id="level_item{{$i++}}">
                                                <div>{{$level->name}}</div>
                                                <span>{{$level->xp}} XP</span>
                                            </div>
                                        @elseif($dataLevel == $last)
                                            <div class="flex-column align-items-center text-right" id="level_item{{$i++}}">
                                                <div>{{$level->name}}</div>
                                                <span>{{$level->xp}} XP</span>
                                            </div>
                                        @else
                                            <div class="flex-column align-items-center text-center" id="level_item{{$i++}}">
                                                <div>{{$level->name}}</div>
                                                <span>{{$level->xp}} XP</span>
                                            </div>
                                        @endif
                                    @empty
                                        @php
                                            $tampung_max_level[$i]  =   $level->xp;
                                        @endphp
                                        <div class="flex-column align-items-center text-left">
                                            <div>Levels not set</div>
                                            <span>0 XP</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACHIEVEMENTS -->
            <div>
                <div class="card shadow">
                    <div class="card-body px-4">
                        <div class="d-flex justify-content-between">
                            <h6>Achievements</h6>
                            <a href="#" data-toggle="modal" data-target="#exampleModal" style="text-decoration: none;">View All</a>
                        </div>
                        <div class="row">
                            @php $pointer=0; @endphp
                            @forelse ($data->achievement as $item)
                                @php $pointer++ @endphp
                                    <div class="col-md-6 py-1">
                                        <div class="card-body py-0 px-3 border rounded d-flex">
                                            <div class="p-auto d-flex align-items-center">
                                                <img draggable='false' alt="image" src="{{asset_app($item->achievement->badge)}}" class="img-fluid badge-logo">
                                            </div>
                                            <div class="pl-2 py-3 text-left flex-column align-items-center">
                                                <div>
                                                    <span id="badge-title"><b>{{$item->achievement->name}}</b></span>
                                                </div>
                                                <div>
                                                    <small id="badge-desc"><i>{{$item->achievement->activity->name}} Sebanyak {{$item->achievement->value}} Kali</i></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @if($pointer == 4)
                                    @break
                                @endif
                            @empty
                                <div class="card-body d-flex justify-content-center">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center">
                                            <img draggable='false' alt="image" src="{{asset_app('assets/img/bx_bxs-trophy.png')}}" class="img-fluid badge-logo mr-2">
                                        </div>
                                        <div class="text-black-50">
                                            <div><b><i>No Achievements</i></b></div>
                                            <span><i>You don't have any achievement yet</i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Achievements</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @forelse ($data->achievement as $item)
                                    <div class="col-md-6 py-1">
                                        <div class="card-body py-0 px-3 border rounded d-flex">
                                            <div class="p-auto d-flex align-items-center">
                                                <img draggable='false' alt="image" src="{{asset_app($item->achievement->badge)}}" class="img-fluid badge-logo">
                                            </div>
                                            <div class="pl-2 py-3 text-left flex-column align-items-center">
                                                <div>
                                                    <span id="badge-title"><b>{{$item->achievement->name}}</b></span>
                                                </div>
                                                <div>
                                                    <small id="badge-desc"><i>{{$item->achievement->activity->name}} Sebanyak {{$item->achievement->value}} Kali</i></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="card-body d-flex justify-content-center">
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center">
                                                <img draggable='false' alt="image" src="{{asset_app('assets/img/bx_bxs-trophy.png')}}" class="img-fluid badge-logo mr-2">
                                            </div>
                                            <div class="text-black-50">
                                                <div><b><i>No Achievements</i></b></div>
                                                <span><i>You don't have any achievement yet</i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalhistory" tabindex="-1" aria-labelledby="modalhistory" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">History Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @forelse ($history_activity as $item)
                                    <div class="col-lg-4 col-md-6 py-1">
                                        <div class="card-body py-0 px-3 border rounded d-flex">
                                            <div class="p-auto d-flex align-items-center mr-2">
                                                <img draggable='false' alt="image" src="{{asset_app('assets\img\circle-xp.png')}}" class="img-fluid badge-logo">
                                            </div>
                                            <div class="pl-2 py-3 text-left flex-column align-items-center">
                                                <div>
                                                    <span id="badge-title"><b>{{$item->activity->name}}</b></span>
                                                </div>
                                                <div>
                                                    <small id="badge-desc"><i>{{$item->activity->xp}} Poin</i></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="card-body d-flex justify-content-center">
                                        <div class="d-flex">
                                            <div class="text-black-50">
                                                <div><b><i>No Activity</i></b></div>
                                                <span><i>You don't have any activity yet</i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @if ($data->id <> session('id'))
                @include('profile-project')
            @endif
        </div>
    </div>
@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/page/profile.js')}}"></script>
    <script>
        // .::progresss BARR::.
        var userXP  = {!! json_encode($data->xp) !!};
        var level   = [];
        level[1]    = {!! json_encode($tampung_max_level[1]) !!};
        //level[2]    = {!! json_encode($tampung_max_level[2]) !!};
        level[2]    = {!! json_encode($tampung_max_level[2]) !!};
        level[3]    = {!! json_encode($tampung_max_level[3]) !!};

        //siap kan pembagian ke orang2
        var total_tampung   = userXP;
        var save            = [];
        save[1]             = 0;
        save[2]             = 0;
        save[3]             = 0;
        
        //pembagian
        var teko         = total_tampung;
        var cangkir      = 0;
        for(var pointer = 1;pointer <= 3;pointer++){
            //cek apakah xp nya sudah melebihi level[pointer] ?
            if(total_tampung > level[pointer]){
                save[pointer] = level[pointer] - cangkir;
                teko = total_tampung - level[pointer];
            }else{
                save[pointer] = teko;
                break;
            }
            cangkir          += level[pointer];
            //console.log(`level ${pointer} = ${level[pointer]}`);
        }

        //console.log(`save 1 = ${save[1]}`);
        //console.log(`save 2 = ${save[2]}`);
        //console.log(`save 3 = ${save[3]}`);

        //console.log(`level 1 = ${level[1]}`);
        //console.log(`level 2 = ${level[2]}`);
        //console.log(`level 3 = ${level[3]}`);

        //perhitungkan
        var persentase            = [];
        persentase[1]             = 0;
        persentase[2]             = 0;
        persentase[3]             = 0;

        var cangkir               = 0;
        var sisateko              = 0;
        var totalperlevel         = 0;
        for(var pointer = 1;pointer <= 3;pointer++){
            //cek apakah xp nya sudah melebihi level[pointer] ?
            if(save[pointer] !== 0){
                //cek sudah sejauh apa kita lalui
                if(cangkir  !== 0){
                    totalperlevel   =   level[pointer] - cangkir;
                }else{
                    totalperlevel   =   level[pointer];
                }

                //olah
                var temp                        = (save[pointer] / totalperlevel) * 100;
                persentase[pointer]             = Math.round(temp.toFixed(2));
                //console.log(`totallevel ${pointer} adalah ${save[pointer]} / ${totalperlevel} * 100 = ${persentase[pointer]}`);
                cangkir                        += level[pointer];
                //console.log(`level ${pointer} = ${persentase[pointer]}`);
                $(`#level${pointer}`).attr('style',`width: ${persentase[pointer]}%`);
            }else{
                persentase[pointer]             =   0;
                $(`#level${pointer}`).attr('style',`width: ${persentase[pointer]}%`);
            }
        }
    </script>
@endpush