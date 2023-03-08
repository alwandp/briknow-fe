<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Projects</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @forelse ($dataPrj as $prj)
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
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>