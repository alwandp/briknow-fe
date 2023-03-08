@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <style>
        .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            padding: 0 20px;
            background: white;
        }

        .table:not(.table-sm) thead th {
            background-color: rgba(240, 242, 245, 1);
            color: black;
            border: none;
        }

        td>div {
            padding-top: 12px;
            padding-bottom: 12px;
        }
        
        table {
            border-collapse: separate;
            border-spacing:0;
        }

        #btn-view {
            border-radius: 8px;
            font-size: 12px;
            font-weight: normal;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        #th-line {
            border-top: 1px solid rgba(214, 214, 214, 1);
            border-bottom: 1px solid rgba(214, 214, 214, 1);
        }

        .table>tbody>tr>td, 
        .table>tbody>tr>th, 
        .table>tfoot>tr>td, 
        .table>tfoot>tr>th, 
        .table>thead>tr>td, 
        .table>thead>tr>th {
            border-bottom: 1px solid rgba(214, 214, 214, 1);
            text-align: center;
        }

        .select2-container--bootstrap .select2-selection--single{
            line-height: 2;
        }

        #search, .form-control:not(.form-control-sm):not(.form-control-lg) {
            height: 30px;
        }
    </style>
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')
    <div class="row">
        <div class="col-md-12" id="konten">
            <div class="d-flex bd-highlight mt-3">
                <div class="mr-auto p-2 bd-highlight">
                    <h3>Manage Admin</h3>
                </div>
            </div>

            <!-- NAVIGASI -->
            <div class="d-flex bd-highlight mb-1 justify-content-end">
                <div class="mr-auto p-2 bd-highlight">
                    <button type="button" class="btn btn-success btn-sm" id="btn-add-user" data-toggle="modal" data-target="#modal-add-user"><i class="fas fa-plus px-1"></i><span class="px-1">Tambah Admin</span></button>
                </div>

                <div class="p-2 bd-highlight">
                    <form action="#" class="w-100" id="search">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search">
                                    <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search user..." aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </form>
                </div>
            </div>
            <!-- NAVIGASI -->

            @include('layouts.alert')
            
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th id="th-line" style="width: 20px; border-left: 1px solid rgba(214, 214, 214, 1); border-top-left-radius: 12px; "></th>
                        <th id="th-line" style="width: 200px;">Nama User</th>
                        <th id="th-line">Jenis User</th>
                        <th id="th-line">Hak Akses</th>
                        <th id="th-line">Email</th>
                        <th id="th-line">Divisi</th>
                        <th id="th-line" style="border-right: 1px solid rgba(214, 214, 214, 1); border-top-right-radius: 12px;">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center justify-content-center align-content-center" id="content-list-user">
                    </tbody>
                </table>
            </div>
            <div class="w-100 d-flex justify-content-end" id="pag">
            </div>
        </div>
    </div>
@endsection
@section('popup')
    <!-- MODAL TAMBAH USER -->
    <div class="modal fade" id="modal-add-user" data-keyboard="true" tabindex="-1" aria-labelledby="modal-add-rekomendasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-body">
                <h5>Tambah Admin</h5>
                <hr>
                <form id="form-rekomendasi" action="{{ route('admin_create') }}" method="POST">
                    @csrf
                    <div class="row d-flex">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <select name="pn" id="pn" class="pn select2 form-control @error('pn') is-invalid @enderror" placeholder='Masukan Personal Number'></select>
                                <small class='text-black font-italic'>* Pastikan <b>Personal Number</b> yang di Isi Merupakan Role User</small>
                                @error('pn')
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
    <!-- MODAL TAMBAH USER -->


    <!-- Modal -->
    {{-- <div class="modal fade" id="staticBackdrop" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('editmu', 1) }}" id="form-id" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="selectrole" class="col-sm-3 col-form-label col-form-label-sm text-dark">Jenis User</label>
                            <div class="col-sm-9">
                                <select name="role[]" id="roles" class="selectrole select2 form-control @error('role') is-invalid @enderror" placeholder='-- Pilih Jenis User --'>
                                    <option selected disabled>-- Pilih Jenis User --</option>
                                    <option value="0" data-value='Maker'>Maker</option>
                                    <option value="1" data-value='Checker'>Checker</option>
                                    <option value="2" data-value='Signer'>Signer</option>
                                    <option value="3" data-value='Admin'>Super Admin</option>
                                </select>
                                @error('role')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection
@push('page-script')
    <script>
        localStorage.clear();
    </script>
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/manageuser.js')}}"></script>
    <script>      
        function hapus(a){
            let t = "{{$token_auth}}";
            swal.fire({ title: "Yakin Melepas User Ini Dari Role Admin?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageuser/destroy/' }}" + a,
                        type: "post",
                        data: { _method: "DELETE"},
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN",csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            swal.fire({ title: "User Berhasil Di Hapus!", text: "", icon: "success",confirmButtonColor: "#3085d6", confirmButtonText: "Ok"}).then((i) => {
                                if(i.isConfirmed){
                                    location.reload();
                                }else{
                                    location.reload();
                                }});
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Swal.fire({ icon: "error", title: "Oops...", text: "User Gagal Di Hapus!" });
                        },
                    })
                }else{
                }
            });
        };

        // meta url
        const meta = document.getElementsByTagName('meta');
        for (let i = 0; i < meta.length; i++) {
            if (meta[i].getAttribute('name') === "pages") {
                uri = meta[i].getAttribute('content');
            }
            if (meta[i].getAttribute('name') === "BE") {
                be = meta[i].getAttribute('content');
            }
            if (meta[i].getAttribute('name') === "csrf") {
                csrf = meta[i].getAttribute('content');
            }
        }

        $('#btn-add-user').on('click',function(){
            $(".pn").select2({
                minimumInputLength: 8,
                maximumInputLength: 8,
                placeholder: 'Masukan Personal Number',
                dropdownParent: $('#modal-add-user'),
                ajax: {
                    url: `${uri}/searchuser`,
                    type: "get",
                    headers: {'X-CSRF-TOKEN': csrf},
                    data: function (params) {
                        var query = {
                            pn: params.term,
                            mode: 33
                        }
                        // Query parameters will be ?pn=[term]
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    }
                }
            });

            $(document).on('keypress', '.select2-search__field', function () {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
        })
    </script>
@endpush
