@forelse ($data as $favp)
    <div class="col-md-4 col-sm-12 rowdoc">
        <div class="card border control list-project mb-2">
            <div class="row px-3">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 p-0 d-flex align-items-center">
                    <a href="{{route('project.index', $favp->slug)}}" target="_blank" style="text-decoration: none;">
                        <div class="row d-flex justify-content-center">
                            <img src="{{config('app.url').'storage/'.$favp->thumbnail??asset_app('assets/img/boxdefault.svg')}}" width="60%" class="card-img-left border-0">
                        </div>
                    </a>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-7 col-lg-8 pl-1">
                    <a href="{{route('project.index', $favp->slug)}}" target="_blank" style="text-decoration: none;" class="w-100">
                        <div class="card-body content-project">
                            <span class="d-block text-dark header-list-project mb-1">{{!empty($favp->nama)?$favp->nama:"-"}}</span>
                            @php 
                                $last = end($favp->consultant);
                                $only = count($favp->consultant);
                            @endphp
                            
                            <small>
                                <?php $u = 0; ?>
                                @forelse ($favp->consultant as $consultant)
                                    @if ($consultant == $last && $only > 1)
                                        {{!empty($consultant->nama)?\Str::limit($consultant->nama,22,'..'):"-"}}
                                    @elseif ($only == 1)
                                        {{!empty($consultant->nama)?\Str::limit($consultant->nama,22,'..'):"-"}}
                                    @else
                                        {{!empty($consultant->nama)?\Str::limit($consultant->nama,22,'..'):"-"}},
                                    @endif

                                    <?php $u++; ?>
                                    @if($u == 2)
                                        @break
                                    @endif
                                @empty
                                    Internal
                                @endforelse
                            </small>
                            <small class="d-block">{{!empty($favp->project_managers->nama)?$favp->project_managers->nama:"-"}}</small>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2s px-0">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div id="panel_favorite">
                            <i class="fas fa-star mr-1 gold" id="star" onclick="saveFavProj({{$favp->id}})"></i>
                            <i class="fas fa-share-alt mr-1" data-toggle="modal" data-target="#berbagi" onclick="migrasi('Eh, liat Project ini deh. {{$favp->nama}} di BRIKNOW. &nbsp;{{route('project.index', $favp->slug)}}')"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-md-12 col-sm-12 rowdoc d-flex justify-content-center">
        Belum Memiliki Favorite Project
    </div>
@endforelse