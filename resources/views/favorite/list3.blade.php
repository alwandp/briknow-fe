<?php $urut = 0;?>
@php $type_list  = [
                            "article" => "Articles",
                            "logo" => "Icon, Logo, Maskot BRIVO",
                            "infographics" => "Infographics",
                            "transformation" => "Transformation Journey",
                            "podcast" => "Podcast",
                            "video" => "Video Content",
                            "instagram" => "Instagram Content"]; @endphp

@forelse ($data as $fav)
@if (isset($fav->type_file))
    <div class="col-md-4 col-sm-12 rowdoc">
        <div class="card border control list-project mb-2">
            <div class="row px-3">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 p-0 d-flex align-items-center">
                    <a href="{{route('project.index', $fav->id)}}" target="_blank" style="text-decoration: none;">
                        <div class="row d-flex justify-content-center">
                            <img src="{{!empty($fav->thumbnail)?config('app.url').'storage/'.$fav->thumbnail:asset_app('assets/img/boxdefault.svg')}}" width="60%" class="card-img-left border-0">
                        </div>
                    </a>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-7 col-lg-8 pl-1">
                    <a href="{{route('mycomsupport.initiative.type', [$fav->type_file, 'slug' => $fav->slug])}}" target="_blank" style="text-decoration: none;">
                        <div class="card-body content-project">
                            <span class="d-block text-dark header-list-project">{{!empty($fav->title)?$fav->title:"-"}}</span>
                            <p class="ven-proj">{{!empty($fav->type_file)?\Str::limit($type_list[$fav->type_file],22 ,'..'):"-"}}</p>
                            <p class="d-block ven-proj">{{!empty($fav->project)?\Str::limit($fav->project->nama,22 ,'..'):"-"}}</p>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 px-0">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div id="panel_favorite">
                            <i class="fas fa-star mr-1 gold" onclick="saveFavCom({{$fav->id}})" id="star"></i>
                            <i class="fas fa-share-alt mr-1" data-toggle="modal" data-target="#berbagi" onclick="migrasi('Eh, liat Konten ini deh. {{$fav->title}} di BRIKNOW. &nbsp;{{route('mycomsupport.initiative.type', [$fav->type_file, 'slug' => $fav->slug])}}')"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="col-md-4 col-sm-12 rowdoc">
        <div class="card border control list-project mb-2">
            <div class="row px-3">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 p-0 d-flex align-items-center">
                    <a href="{{route('project.index', $fav->id)}}" target="_blank" style="text-decoration: none;">
                        <div class="row d-flex justify-content-center">
                            <img src="{{!empty($fav->thumbnail)?config('app.url').'storage/'.$fav->thumbnail:asset_app('assets/img/boxdefault.svg')}}" width="60%" class="card-img-left border-0">
                        </div>
                    </a>
                </div>
                <div class="col-xs-9 col-sm-9 col-md-7 col-lg-8 pl-1">
                    <a href="{{route('mycomsupport.implementation', [$fav->slug])}}" target="_blank" style="text-decoration: none;">
                        <div class="card-body content-project">
                            <span class="d-block text-dark header-list-project">{{!empty($fav->title)?$fav->title:"-"}}</span>
                            <p class="ven-proj">{{!empty($fav->type_file)?\Str::limit($type_list[$fav->type_file],22 ,'..'):"-"}}</p>
                            <p class="d-block ven-proj">{{!empty($fav->project)?\Str::limit($fav->project->nama,22 ,'..'):"-"}}</p>
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 px-0">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                        <div id="panel_favorite">
                            <i class="fas fa-star mr-1 gold" onclick="saveFavCom({{$fav->id}})" id="star"></i>
                            <i class="fas fa-share-alt mr-1" data-toggle="modal" data-target="#berbagi" onclick="migrasi('Eh, liat Konten ini deh. {{$fav->title}} di BRIKNOW. &nbsp;{{route('mycomsupport.initiative.type', [$fav->type_file, 'slug' => $fav->slug])}}')"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
    <?php $urut++;?>
@empty
    <div class="col-md-12 col-sm-12 rowdoc d-flex justify-content-center">
        Belum Memiliki Favorite Communication Support
    </div>
@endforelse
