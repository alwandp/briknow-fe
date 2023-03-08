<?php $urut = 0;?>
@forelse ($data as $favc)
    <div class="col-md-4 col-sm-12 rowdoc">
        <div class="card border control list-project mb-2">
            <div class="row px-3">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 p-0 d-flex align-items-center">
                    <a href="{{route('consultant.index', $favc->id)}}" target="_blank" style="text-decoration: none;">
                        <div class="row d-flex justify-content-center">
                            <img src="{{asset_app('assets/img/boxdefault.svg')}}" width="60%" class="card-img-left border-0">
                        </div>
                    </a>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-7 col-lg-8 pl-1">
                    <a href="{{route('consultant.index', $favc->id)}}" target="_blank" style="text-decoration: none;">
                        <div class="card-body content-project">
                            <span class="d-block text-dark header-list-project">{{!empty($favc->nama)?$favc->nama:"-"}}</span>
                            <p class="ven-proj">{{!empty($favc->bidang)?\Str::limit($favc->bidang,22 ,'..'):"-"}}</p>
                            <p class="d-block ven-proj">{{!empty($favc->website)?\Str::limit($favc->website,22 ,'..'):"-"}}</p>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 px-0">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div id="panel_favorite">
                            <i class="fas fa-star mr-1 gold" onclick="saveFavCons({{$favc->id}})" id="star"></i>
                            <i class="fas fa-share-alt mr-1" data-toggle="modal" data-target="#berbagi" onclick="migrasi('Eh, liat konsultan ini deh. {{$favc->nama}} di BRIKNOW. &nbsp;{{route('consultant.index', $favc->id)}}')"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $urut++;?>
@empty
    <div class="col-md-12 col-sm-12 rowdoc d-flex justify-content-center">
        Belum Memiliki Favorite Consultant
    </div>
@endforelse