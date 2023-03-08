<div class="modal fade" id="editprofil" tabindex="-1" role="dialog" aria-labelledby="editprofil" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="post" id="form-edit-prof">
                {{csrf_field()}}{{method_field('POST')}}
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="mb-2" for="">Personal Number</label>
                        <input type="number" id="personal_number" name="personal_number" value="{{session('personal_number')}}" class="form-control" disabled>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2" for="">Nama</label>
                        <input type="text" id="name" name="name" value="{{session('name')}}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="mb-2" for="">Nama Panggilan</label>
                        <input type="text" id="username" name="nickname" class="form-control" value="{{session('username')}}">
                    </div>
                    <div class="mb-2">
                        <label class="mb-2" for="">Email</label>
                        <input type="email" id="email" name="email" value="{{session('email')}}" class="form-control">
                    </div>
                    @php
                        foreach($divisi_edit_profile as $item){
                            if($item->id === session('direktorat')){
                                $direktorat = $item->direktorat;
                            }
                        }
                    @endphp
                    <div class="mb-2">
                        <label class="mb-2" for="">Direktorat</label>
                        <select id="direktorat_edit_profile" name="direktorat" class="form-control combo" style="height:38px !important" required>
                            <option value="" disabled selected>Pilih Direktorat</option>
                            @forelse($direktorat_edit_profile as $item)
                                @if($item->direktorat !== NULL)
                                    @if($item->direktorat == $direktorat)
                                        <option value="{{$item->direktorat}}" selected>{{$item->direktorat}}</option>
                                    @else
                                        <option value="{{$item->direktorat}}">{{$item->direktorat}}</option>
                                    @endif
                                @endif
                            @empty
                            @endforelse
                            <option value="NULL">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="mb-2" for="">Divisi</label>
                        <select id="divisi_edit_profile" name="divisi" class="form-control combo" style="height:38px !important" required>
                            <option value="" disabled selected>Pilih Divisi</option>
                            @forelse($divisi_edit_profile as $item)
                                @if($item->direktorat == $direktorat)
                                    @if($item->id == session('divisi'))
                                        <option value="{{$item->id}}" selected>{{$item->divisi}}</option>
                                    @else
                                        <option value="{{$item->id}}">{{$item->divisi}}</option>
                                    @endif
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="mx-2 mt-4">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-pencil-alt mr-1"></i>Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>