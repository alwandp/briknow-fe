@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
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

        .direktorat_uker{
            height: 33px !important;
            padding: 5px !important;
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
                <div class="mr-auto pt-2 bd-highlight">
                    <h3>Manage Uker</h3>
                </div>
            </div>

            <!-- NAVIGASI -->
                <div class="d-flex bd-highlight mb-1 justify-content-end">
                    <div class="mr-auto p-2 bd-highlight">
                        <button type="button" class="btn btn-success btn-sm" id="btn-add-uker" data-toggle="modal" data-target="#modal-add-uker"><i class="fas fa-plus px-1"></i><span class="px-1">Tambah Uker</span></button>
                    </div>
                    <!-- Dropdowns -->
                    <div class="p-2 bd-highlight" id="drop-nama-proyek">
                        <div class="dropdown show">
                            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <button class="btn dropdown-item" id="baru"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Terbaru</button>
                                <button class="btn dropdown-item" id="lama"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Terlama</button>
                                <hr class="w-100 my-0"/>
                                <button class="btn dropdown-item" id="az"><svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>A - Z</button>
                                <button class="btn dropdown-item" id="za">
                                    <svg class="w-6 h-6 mr-1" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path></svg>
                                    Z - A
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Dropdowns -->

                    <!-- Search -->
                    <div class="p-2 bd-highlight" id="search">
                        <form action="#" class="w-100" id="search">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="search">
                                        <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control form-control-sm" placeholder="Cari Divisi" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </form>
                    </div>
                    <!-- Search -->
                </div>
            <!-- NAVIGASI -->

            @include('layouts.alert')

            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        {{-- <th id="th-line" style="width: 20px; border-left: 1px solid rgba(214, 214, 214, 1); border-top-left-radius: 12px; "></th> --}}
                        <th id="th-line" style="width: 150px; border-left: 1px solid rgba(214, 214, 214, 1); border-top-left-radius: 12px;">Cost Center</th>
                        <th id="th-line" style="width: 300px;">Nama Direktorat</th>
                        <th id="th-line" style="width: 300px;">Nama Divisi</th>
                        <th id="th-line">Shortname Divisi</th>
                        <th id="th-line" style="border-right: 1px solid rgba(214, 214, 214, 1); border-top-right-radius: 12px;">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center justify-content-center align-content-center" id="content-table-body">
                    </tbody>
                </table>
            </div>
            <div class="w-100 d-flex justify-content-end" id="pag">
            </div>
        </div>
    </div>
@endsection
@section('popup')
    <!-- Modal Edit -->
        <div class="modal fade" id="modal-update-uker" data-keyboard="true" aria-labelledby="modal-update-ukerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card-body">
                    <h5>Update Unit Kerja</h5>
                    <hr>
                    <form id="form-update-uker"  method="post" class="w-100">
                        @csrf
                        <div class="row d-flex">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <label for="cost_center" class="col-sm-4 col-form-label">Cost Center<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="cost_center" name="cost_center_edit" placeholder="Cost Center" value='{{@old('cost_center_edit')}}' maxlength="7" required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="direktorat" class="col-sm-4 col-form-label">Nama Direktorat</label>
                                    <div class="col-sm-8">
                                        <select class="form-control direktorat_uker select2" id="direktorat" name="direktorat_edit">
                                            <option value="" name="direktorat" data-value=""></option>
                                            <option value="" {{@old('direktorat') <> null ? '' : 'selected'}} disabled>Direktorat</option>
                                            @forelse($direktorat_edit_profile as $item)
                                                @if($item->direktorat <> NULL)
                                                    <option value="{{$item->direktorat}}"  data-value="{{$item->direktorat}}" {{@old('direktorat') <> null ? 'selected' : ''}}>{{$item->direktorat}}</option>
                                                @endif
                                            @empty
                                            @endforelse
                                        </select>
                                        <small class="text-dark font-italic">Bila Direktorat kosong Maka Dikategorikan "Lainnya"</small>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="divisi" class="col-sm-4 col-form-label">Nama Divisi<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="divisi" name="divisi_edit" placeholder="Divisi" value='{{@old('divisi_edit')}}' required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="shortname" class="col-sm-4 col-form-label">Shortname<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="shortname" name="shortname_edit" placeholder="Shortname" maxlength="4" value='{{@old('shortname_edit')}}' required>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm float-right" type="submit" id="btn-update-uker">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    <!-- Modal Edit -->

    <!-- MODAL TAMBAH REKOMENDASI -->
        <div class="modal fade" id="modal-add-uker" data-keyboard="true" aria-labelledby="modal-add-ukerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card-body">
                    <h5>Tambah Unit Kerja</h5>
                    <hr>
                    <form action="{{route('manage_uker.create_proses')}}" id="form-uker"  method="post" class="w-100">
                        @csrf
                        <div class="row d-flex">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <label for="cost_center" class="col-sm-4 col-form-label">Cost Center<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('cost_center') is-invalid @enderror" id="cost_center" name="cost_center" placeholder="Cost Center" value='{{@old('cost_center')}}' maxlength="7" required>
                                        @error('cost_center')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="direktorat" class="col-sm-4 col-form-label">Nama Direktorat</label>
                                    <div class="col-sm-8">
                                        <select class="form-control direktorat_uker select2" name='direktorat' required data-select2-tags="true" placeholder='-- Pilih Direktorat --'>
                                            <option value=""  data-value=""></option>
                                            <option value="" {{@old('direktorat') <> '' ? '' : 'selected'}} disabled>Direktorat</option>
                                            @forelse($direktorat_edit_profile as $item)
                                                @if($item->direktorat <> NULL)
                                                    <option value="{{$item->direktorat}}" data-value="{{$item->direktorat}}" {{@old('direktorat') == $item->direktorat ? 'selected' : ''}}>{{$item->direktorat}}</option>
                                                @endif
                                            @empty
                                            @endforelse
                                        </select>
                                        <small class="text-dark font-italic">Bila Direktorat kosong Maka Dikategorikan "Lainnya"</small>
                                        @error('direktorat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="divisi" class="col-sm-4 col-form-label">Nama Divisi<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('divisi') is-invalid @enderror" id="divisi" name="divisi" value='{{@old('divisi')}}' placeholder="Divisi" required>
                                        @error('divisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="shortname" class="col-sm-4 col-form-label">Shortname<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('shortname') is-invalid @enderror" id="shortname" name="shortname" placeholder="Shortname" value='{{@old('shortname')}}' maxlength="4" required>
                                        @error('shortname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm float-right" type="submit" id="btn-submit-uker">Tambahkan</button>
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
        if(jQuery().select2) {
            $(".select2").select2();
        }
        const Tst = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        var cek = localStorage.getItem('divisi_deleted');
        if (cek == 1) {
            Tst.fire({icon: 'success',title: "Divisi berhasil dihapus"});
            localStorage.removeItem('divisi_deleted');
        } else if (cek == 2) {
            Tst.fire({icon: 'error',title: "Divisi gagal dihapus!"});
            localStorage.removeItem('divisi_deleted');
        } else if (cek == 3) {
            Tst.fire({icon: 'error',title: "Gagal menghapus, divisi terhubung dengan projek"});
            localStorage.removeItem('divisi_deleted');
        }

        localStorage.clear();
    </script>
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/uker.js')}}"></script>
    <script>
        var uri;
        var csrf;
        const metas2 = document.getElementsByTagName('meta');
        for (let i = 0; i < metas2.length; i++) {
            if (metas2[i].getAttribute('name') === "pages") {
                uri = metas2[i].getAttribute('content');
            }
            if (metas2[i].getAttribute('name') === "csrf") {
                csrf = metas2[i].getAttribute('content');
            }
        }

        $( "#form-uker" ).submit(function( event ) {
            $('.senddataloader').show();
        });
        $( "#form-update-uker" ).submit(function( event ) {
            $('.senddataloader').show();
        });
        function getData(a){
            $.ajax({
                url: "{{ url('').'/manageuker/detail/' }}" + a,
                type: "get",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN",csrf);
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();

                    let id = a;
                    let uri = "{{url('/manageuker/edit/')}}";
                    $("#form-update-uker").attr('action', `${uri}/${a}`);
                    // console.log(a);

                    console.log(data.data.data['direktorat']);

                    if (data.data.data !== '') {
                        $("#cost_center").val(data.data.data['cost_center']);
                        // $('#direktorat').val(data.data.data['direktorat']); //NON SELECT2
                        $("#direktorat").val(data.data.data['direktorat']).trigger('change'); //SELECT2 VERSION
                        $("#divisi").val(data.data.data['divisi']);
                        $("#shortname").val(data.data.data['shortname']);

                        // SELECT DIREKTORAT
                        $('#direktorat').select2({
                            placeholder : 'Pilih Direktorat',
                            tags: true,
                            dropdownParent: $("#modal-update-uker")
                        });
                    } else {
                        $("#cost_center").val();
                        $("#direktorat").val();
                        $("#divisi").val();
                        $("#shortname").val();
                    }
                    // console.log(data);
                },
                error: function (e) {
                    $('.senddataloader').hide();
                    alert(e);
                },
            })
        };

        function hapus(a){
            swal.fire({ title: "Yakin Ingin Menghapusnya?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageuker/delete/' }}" + a,
                        type: "DELETE",
                        data: { _method: "DELETE"},
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN",csrf);
                            $('.senddataloader').show();
                        },
                        success: function (data) {
                            $('.senddataloader').hide();
                            alert(data.status);
                            if (data.status == 1) {
                                localStorage.setItem('divisi_deleted', '1')
                            } else if (data.status == -1) {
                                localStorage.setItem('divisi_deleted', '3')
                            } else {
                                localStorage.setItem('divisi_deleted', '2')
                            }
                            location.reload();
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Tst.fire({icon: 'error',title: "Divisi gagal dihapus!"});
                        },
                    })
                }else{
                }
            });
        };
    </script>
@endpush
