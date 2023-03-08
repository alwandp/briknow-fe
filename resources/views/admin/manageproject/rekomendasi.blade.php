@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    
    <link rel="stylesheet" href="{{ asset_app('assets/css/rekomendasi.css') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Project</h3>

        <!-- NAVIGASI -->
            <div class="d-flex bd-highlight mb-3">
                <div class="mr-auto p-2 bd-highlight">
                    <a class="btn btn-light btn-sm" href="{{ route('manage_project.review') }}" role="button">Review</a>
                    <a class="btn btn-light btn-sm active" href="{{ route('manage_project.rekomendasi') }}" role="button">Rekomendasi</a>
                </div>
                
                <!-- Button -->
                    <div class="p-2 bd-highlight">
                        <button type="button" class="btn btn-success btn-sm" id="btn-add-rekomendasi" data-toggle="modal" data-target="#modal-add-rekomendasi"><i class="fas fa-plus px-1"></i><span class="px-1">Tambah Rekomendasi</span></button>
                    </div>
                <!-- Button -->
            </div>
        <!-- NAVIGASI -->

        @include('layouts.alert')

        <!-- REKOMENDASI ATAS -->
            <div class="table-responsive" id="rekomendasi">
                <table class="table">
                    <thead class="thead-light text-left justify-content-start align-content-start">
                        <tr>
                            <th id="th-line"
                                style="border-left: 1px solid rgba(214, 214, 214, 1); border-top-left-radius: 12px;">Nama
                                Proyek</th>
                            <th id="th-line">Direktorat</th>
                            <th id="th-line">Pemilik Proyek</th>
                            <th id="th-line">Tanggal</th>
                            <th id="th-line"
                                style="border-right: 1px solid rgba(214, 214, 214, 1); border-top-right-radius: 12px;"></th>
                        </tr>
                    </thead>
                    @php
                        $i = 0;
                    @endphp
                    <tbody class="text-left justify-content-start align-content-start">
                        @forelse($data as $proj)
                            @php
                                $i++;
                                $tanggal_mulai = strtotime($proj->tanggal_mulai);
                                $tgl = date('d/m/Y', $tanggal_mulai);
                            @endphp
                            @if($data->total() > 1 && $i == 1)
                                <tr class="py-2">
                                    <td style="width: 250px; border-left: 1px solid rgba(214, 214, 214, 1);">
                                        <div>
                                            @php
                                                $nama = strip_tags($proj->nama);
                                                if (strlen($nama) > 44) {
                                                $stringCut = substr($nama, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $nama = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $nama .= '...';
                                                }
                                            @endphp
                                            {{ $nama }}
                                        </div>
                                    </td>
                                    <td style="width: 300px;">
                                        <div>
                                            @php
                                                $direktorat = strip_tags($proj->divisi->direktorat);
                                                if (strlen($direktorat) > 44) {
                                                $stringCut = substr($direktorat, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $direktorat = $endPoint? substr($stringCut, 0, $endPoint) :
                                                substr($stringCut, 0);
                                                $direktorat .= '...';
                                                }
                                            @endphp
                                            {{ $direktorat }}
                                        </div>
                                    </td>
                                    <td style="width: 300px;">
                                        <div>
                                            @php
                                                $divisi = strip_tags($proj->divisi->divisi);
                                                if (strlen($divisi) > 43) {
                                                $stringCut = substr($divisi, 0, 43);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $divisi = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut,
                                                0);
                                                $divisi .= '...';
                                                }
                                            @endphp
                                            {{ $divisi }}
                                        </div>
                                    </td>
                                    <td style="width: 110px; padding-right: 0 !important;">
                                        <div>{{ $tgl }}</div>
                                    </td>
                                    <td style="width: 40px; padding-left: 0 !important; border-right: 1px solid rgba(214, 214, 214, 1);">
                                        <a href="#" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            •••
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <button class="btn dropdown-item" onclick="views('{{$proj->slug}}')">
                                                <i class="fas fa-eye mr-2"></i>View
                                            </button>
                                            <hr class="m-1">
                                            <button class="btn dropdown-item" onclick="hapus('{{$proj->id}}')">
                                                <i class="fas fa-trash mr-2"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @elseif($i==$data->perPage())
                                <tr class="py-2">
                                    <td
                                        style="border-left: 1px solid rgba(214, 214, 214, 1); border-end-start-radius: 12px;">
                                        <div>
                                            @php
                                                $nama = strip_tags($proj->nama);
                                                if (strlen($nama) > 44) {
                                                $stringCut = substr($nama, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $nama = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $nama .= '...';
                                                }
                                            @endphp
                                            {{ $nama }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @php
                                                $direktorat = strip_tags($proj->divisi->direktorat);
                                                if (strlen($direktorat) > 44) {
                                                $stringCut = substr($direktorat, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $direktorat = $endPoint? substr($stringCut, 0, $endPoint) :
                                                substr($stringCut, 0);
                                                $direktorat .= '...';
                                                }
                                            @endphp
                                            {{ $direktorat }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @php
                                                $divisi = strip_tags($proj->divisi->divisi);
                                                if (strlen($divisi) > 43) {
                                                $stringCut = substr($divisi, 0, 43);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $divisi = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut,
                                                0);
                                                $divisi .= '...';
                                                }
                                            @endphp
                                            {{ $divisi }}
                                        </div>
                                    </td>
                                    <td style="padding-right: 0 !important;">
                                        <div>{{ $tgl }}</div>
                                    </td>
                                    <td style="padding-left: 0 !important; border-right: 1px solid rgba(214, 214, 214, 1); border-end-end-radius: 12px;">
                                        <a href="#" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            •••
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <button class="btn dropdown-item" onclick="views('{{$proj->slug}}')">
                                                <i class="fas fa-eye mr-2"></i>View
                                            </button>
                                            <hr class="m-1">
                                            <button class="btn dropdown-item" onclick="hapus('{{$proj->id}}')">
                                                <i class="fas fa-trash mr-2"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @elseif($data->total() == 1 && $i == 1)
                                <tr class="py-2">
                                    <td
                                        style="border-left: 1px solid rgba(214, 214, 214, 1); border-end-start-radius: 12px;">
                                        <div>
                                            @php
                                                $nama = strip_tags($proj->nama);
                                                if (strlen($nama) > 44) {
                                                $stringCut = substr($nama, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $nama = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $nama .= '...';
                                                }
                                            @endphp
                                            {{ $nama }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @php
                                                $direktorat = strip_tags($proj->divisi->direktorat);
                                                if (strlen($direktorat) > 44) {
                                                $stringCut = substr($direktorat, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $direktorat = $endPoint? substr($stringCut, 0, $endPoint) :
                                                substr($stringCut, 0);
                                                $direktorat .= '...';
                                                }
                                            @endphp
                                            {{ $direktorat }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @php
                                                $divisi = strip_tags($proj->divisi->divisi);
                                                if (strlen($divisi) > 43) {
                                                $stringCut = substr($divisi, 0, 43);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $divisi = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut,
                                                0);
                                                $divisi .= '...';
                                                }
                                            @endphp
                                            {{ $divisi }}
                                        </div>
                                    </td>
                                    <td style="padding-right: 0 !important;">
                                        <div>{{ $tgl }}</div>
                                    </td>
                                    <td style="padding-left: 0 !important; border-right: 1px solid rgba(214, 214, 214, 1); border-end-end-radius: 12px;">
                                        <a href="#" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            •••
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <button class="btn dropdown-item" onclick="views('{{$proj->slug}}')">
                                                <i class="fas fa-eye mr-2"></i>View
                                            </button>
                                            <hr class="m-1">
                                            <button class="btn dropdown-item" onclick="hapus('{{$proj->id}}')">
                                                <i class="fas fa-trash mr-2"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <tr class="py-2">
                                    <td style="border-left: 1px solid rgba(214, 214, 214, 1);">
                                        <div>
                                            @php
                                                $nama = strip_tags($proj->nama);
                                                if (strlen($nama) > 44) {
                                                $stringCut = substr($nama, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $nama = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $nama .= '...';
                                                }
                                            @endphp
                                            {{ $nama }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @php
                                                $direktorat = strip_tags($proj->divisi->direktorat);
                                                if (strlen($direktorat) > 44) {
                                                $stringCut = substr($direktorat, 0, 44);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $direktorat = $endPoint? substr($stringCut, 0, $endPoint) :
                                                substr($stringCut, 0);
                                                $direktorat .= '...';
                                                }
                                            @endphp
                                            {{ $direktorat }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @php
                                                $divisi = strip_tags($proj->divisi->divisi);
                                                if (strlen($divisi) > 43) {
                                                $stringCut = substr($divisi, 0, 43);
                                                $endPoint = strrpos($stringCut, ' ');
                                                $divisi = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut,
                                                0);
                                                $divisi .= '...';
                                                }
                                            @endphp
                                            {{ $divisi }}
                                        </div>
                                    </td>
                                    <td style="padding-right: 0 !important;">
                                        <div>{{ $tgl }}</div>
                                    </td>
                                    <td style="padding-left: 0 !important; border-right: 1px solid rgba(214, 214, 214, 1);">
                                        <a href="#" id="dropdownMenuLink" style="text-decoration: none; color: black;"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            •••
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <button class="btn dropdown-item" onclick="views('{{$proj->slug}}')">
                                                <i class="fas fa-eye mr-2"></i>View
                                            </button>
                                            <hr class="m-1">
                                            <button class="btn dropdown-item" onclick="hapus('{{$proj->id}}')">
                                                <i class="fas fa-trash mr-2"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr class="py-2">
                                <td style="text-align: center; border-left: 1px solid rgba(214, 214, 214, 1); border-end-start-radius: 12px;" colspan="4">
                                    <i>Tidak ada data.</i>
                                </td>
                                <td style="border-right: 1px solid rgba(214, 214, 214, 1); border-end-end-radius: 12px;"></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-sm-end">
                    {{ $data->links() }}
                </div>
            </div>
        <!-- REKOMENDASI ATAS -->
    </div>
</div>
@endsection
@section('popup')
{{-- preview --}}
<div class="modal fade bd-example-modal-lg modal-preview" id="modalpreview" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100 content-preview">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL TAMBAH REKOMENDASI -->
<div class="modal fade" id="modal-add-rekomendasi" data-keyboard="true" tabindex="-1" aria-labelledby="modal-add-rekomendasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="card-body">
            <h5>Tambah Proyek Rekomendasi</h5>
            <hr>
            <form id="form-rekomendasi">
                <div class="row d-flex">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select name="project[]" id="projects" class="select2-rekomendasi select2 form-control @error('project') is-invalid @enderror" placeholder='-- Pilih Proyek --' style="color: black;">
                                <option selected disabled>-- Pilih Proyek --</option>
                                @foreach ($data_ as $proj)
                                    <option style="color: black;" value="{{$proj->id}}" data-value='{{$proj->nama}}'>{{$proj->nama}}</option>
                                @endforeach
                            </select>
                            @error('project')
                                {{$message}}
                            @enderror
                        </div>
                        <button class="btn btn-success btn-sm float-right" type="submit" id="btn-cari-proyek">Tambahkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<!-- MODAL TAMBAH REKOMENDASI -->
@endsection
@push('page-script')
    <script>
        localStorage.clear();
    </script>
    <script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/rekomendasi.js')}}"></script>
    <script>
        var $eventSelect = $(".select2-rekomendasi");
        let id = "";
        $( document ).ready(function() {
            $("#projects").select2({
                dropdownParent: $('#modal-add-rekomendasi')
            });
            $eventSelect.select2();
            $eventSelect.change(function() {
                id = this.value;
                console.log(id);
            });
        });
        
        $('#btn-cari-proyek').on('click', function(e){
            e.preventDefault();
            let t = "{{$token_auth}}";
            swal.fire({ title: "Yakin ingin direkomendasikan?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageproject/rekomendasi/add/' }}" + id,
                        type: "post",
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            swal.fire({ title: "Project berhasil direkomendasikan!", text: "", icon: "success",confirmButtonColor: "#3085d6", confirmButtonText: "Ok"}).then((i) => {
                                if(i.isConfirmed){
                                    $('#modal-add-rekomendasi').modal('hide')
                                    location.reload();
                                }else{
                                    location.reload();
                                }});
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Swal.fire({ icon: "error", title: "Oops...", text: "Project gagal direkomendasikan!" });
                        },
                    })
                }else{
                    swal.fire("Rekomendasi dibatalkan!");
                }
            });
        });
        
        function hapus(id){
            let t = "{{$token_auth}}";
            swal.fire({ title: "Yakin ingin menghapus project dari rekomendasi?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageproject/rekomendasi/remove/' }}" + id,
                        type: "post",
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            swal.fire({ title: "Project berhasil dihapus dari rekomendasi!", text: "", icon: "success",confirmButtonColor: "#3085d6", confirmButtonText: "Ok"}).then((i) => {
                                if(i.isConfirmed){
                                    location.reload();
                                }else{
                                    location.reload();
                                }});
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Swal.fire({ icon: "error", title: "Oops...", text: "Project gagal dihapus dari rekomendasi!" });
                        },
                    })
                }else{
                    swal.fire("Rekomendasi tidak jadi dihapus!");
                }
            });
        };

    </script>
@endpush
