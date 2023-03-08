
@if ($data)
    @php if (!empty($data)) $attach = $data->attach_file; @endphp
    <div class="modal-content content-preview bg-transparent">
        <div class="navbar-bg sticky-top navbar-gray bg-gray pr-0 mr-0 z-index-1 py-3" style="height: fit-content">
            <div class="d-flex justify-content-between header-nav">
                <div class="d-flex align-items-center pl-3 ml-2">
                    <button type="button" class="close d-inline bg-tranparent text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="d-flex"><i class="fas fa-arrow-left"></i></span>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <h3 style="margin-bottom: 0">{{$data->title}}</h3>
                </div>
                <div class="d-flex align-items-center pr-3">
                    <button data-toggle="modal" data-target="#berbagi" onclick="migrasi('Eh, liat Konten ini deh. {{$data->title}} di BRIKNOW. &nbsp;{{route('mycomsupport.initiative.type', [$data->type_file, 'slug' => $data->slug])}}')" class="mr-3" style="width: 33px;padding: 4px 8px; border-radius: 4px">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <button onclick="download({{$data->id}})" class="mr-3" style="width: 33px;padding: 4px 8px; border-radius: 4px">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="px-5">
            <div class="cardbg-white bg-white w-100 py-5" style="padding-left: 5rem; padding-right: 5rem">
                <div class="mb-4 text-center">
                    @foreach ($attach as $doc)
                        <div class="mySlides fades">
                        @if($doc->jenis_file == 'jpg' or $doc->jenis_file == 'jpeg' or $doc->jenis_file == 'png' or $doc->jenis_file == 'gif')
                            <div>
                                <img src="{{Config::get('app.url').'storage/'.$doc->url_file}}" class="max-600" width="100%" height="500px" alt="{{$doc->nama}}" style="border: 1px solid rgba(0, 0, 0, 0.2); width: fit-content">
                            </div>
                        @elseif($doc->jenis_file == 'mp4')
                            <video controls autoplay height="500" style="border-radius: 4px">
                                <source src="{{Config::get('app.url').'storage/'.$doc->url_file}}" type="video/mp4">
                            </video>
                        @elseif($doc->jenis_file == 'pdf' or $doc->jenis_file == 'txt')
                            <div>
                                <iframe src="{{Config::get('app.url').'storage/'.$doc->url_file}}" allow="fullscreen" height="495" style="width: 80%"></iframe>
                            </div>
                        @else
                            <div>
                                <img src="{{Config::get('app.url').'storage/'.$data->thumbnail}}" class="max-600" width="100%" height="500px" alt="{{$data->title}}" style="border: 1px solid rgba(0, 0, 0, 0.2);width: fit-content">
                            </div>
                        @endif
                        </div>
                    @endforeach

                    @if(count($attach) > 1)
                        <a class="prev" onclick="plusSlides(-1)">❮</a>
                        <a class="next" onclick="plusSlides(1)">❯</a>
                    @endif
                </div>

                <div class="px-5">
                    <div class="mb-3">
                        <h2 class="font-weight-bold" style="color: #313131">{{$data->title}}</h2>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="mr-2" style="width: 10%">Direktorat</div>
                            <div class="mr-2">:</div>
                            <div>
                                @if ($data->project)
                                    <a class="font-weight-bold" href="{{route('direktorat.comsup',[$data->project->divisi->direktorat, 'cominit'])}}">
                                        {{$data->project->divisi->direktorat}}
                                    </a>
                                @else
                                    <div style="font-weight: 500">General</div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="mr-2" style="width: 10%">Divisi</div>
                            <div class="mr-2">:</div>
                            <div>
                                @if ($data->project)
                                    <a class="font-weight-bold" href="{{route('divisi.comsup',['cominit', $data->project->divisi->id])}}">
                                        {{$data->project->divisi->divisi}}
                                    </a>
                                @else
                                    <div style="font-weight: 500">General</div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="mr-2" style="width: 10%">Waktu Upload</div>
                            <div class="mr-2">:</div>
                            <div style="font-weight: 500">{{date('M j, Y', strtotime($data->created_at))}}</div>
                        </div>
                    </div>
                    <div class="text-justify" style="font-size: 16px; line-height: 1.7">
                        <p>{!!  $data->desc !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
