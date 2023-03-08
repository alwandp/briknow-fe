@foreach ($data->project as $project)
    <div class="col-md-6 col-sm-12 rowdoc">
        <a href="{{route('project.index', $project->slug)}}" style="text-decoration: none">
            <div class="card border control list-project mb-2">
                <div class="row px-3">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-center thumb-katalog">
                    <div class="row d-flex justify-content-center">
                        <img src="{{config('app.url').'storage/'.$project->thumbnail??asset_app('assets/img/boxdefault.svg')}}" width="120%" class="thumb card-img-left border-0">
                    </div>
                    </div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-0">
                        <div class="card-body content-project">
                            <span class="d-block text-dark header-list-project mb-1">{{$project->nama}}</span>
                            <small>
                                @php $last = end($project->consultant); @endphp
                                <?php $u = 0; ?>
                                @forelse ($project->consultant as $consultant)
                                    @if ($consultant == $last)
                                        {{$consultant->nama}}
                                    @else 
                                        {{$consultant->nama}},
                                    @endif
                                    <?php $u++; ?>
                                    @if($u == 2)
                                        @break
                                    @endif
                                @empty
                                    Internal
                                @endforelse
                            </small>  
                            <small class="d-block">{{\Str::limit($project->project_managers->nama,22,'..')??'-'}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach