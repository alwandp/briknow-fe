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
                    <h3>Manage Consultant</h3>
                </div>
            </div>

            <!-- NAVIGASI -->
                <div class="d-flex bd-highlight mb-1 justify-content-end">
                    <div class="mr-auto p-2 bd-highlight">
                        <button type="button" class="btn btn-success btn-sm" id="btn-add-uker" data-toggle="modal" data-target="#modal-add-uker"><i class="fas fa-plus px-1"></i><span class="px-1">Tambah Consultant</span></button>
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
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Consultant" aria-describedby="inputGroup-sizing-sm">
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
                        <th id="th-line" style="width: 150px; border-left: 1px solid rgba(214, 214, 214, 1); border-top-left-radius: 12px;">Nama</th>
                        <th id="th-line" style="width: 300px;">Bidang</th>
                        <th id="th-line" style="width: 300px;">Website</th>
                        <th id="th-line" style="width: 100px;">No Telephone</th>
                        <th id="th-line">Lokasi</th>
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
        <div class="modal fade" id="modal-update-uker" data-keyboard="true" tabindex="-1" aria-labelledby="modal-update-ukerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card-body">
                    <h5>Update Consultant</h5>
                    <hr>
                    <form id="form-update-consultant"  method="post" class="w-100">
                        @csrf
                        <div class="row d-flex">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <label for="nama" class="col-sm-4 col-form-label">Nama Consultant<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama" name="nama_edit" placeholder="Nama Consultant" value="{{old('nama')}}" required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="bidang" class="col-sm-4 col-form-label">Bidang<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="bidang" name="bidang_edit" placeholder="Bergerak Dibidang" value="{{old('bidang')}}" required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="website" class="col-sm-4 col-form-label">Website<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="website" name="website_edit" placeholder="Website" value="{{old('website')}}" required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="telepon" class="col-sm-4 col-form-label">No Telephone<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-1" id="basic-addon1">+62</span>
                                            </div>
                                            <input type="number" class="form-control" id="telepon" name="telepon_edit" placeholder="21xxxxx" value="{{old('telepon')}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="email" class="col-sm-4 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" name="email_edit" placeholder="Email" value="{{old('email')}}" required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="facebook" class="col-sm-4 col-form-label">Facebook</label>
                                    <div class="col-sm-8">
                                        <input type="facebook" class="form-control" id="facebook" name="facebook_edit" placeholder="Facebook" value="{{old('facebook')}}">
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="instagram" class="col-sm-4 col-form-label">Instagram</label>
                                    <div class="col-sm-8">
                                        <input type="instagram" class="form-control" id="instagram" name="instagram_edit" placeholder="Instagram" value="{{old('instagram')}}">
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="tentang" class="col-sm-4 col-form-label">Tentang<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea name="tentang_edit" id="tentang" class="form-control" cols="50" rows="50" placeholder="Tentang Perusahaan" style="height: 50px;" value="{{old('tentang')}}" required></textarea>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="lokasi" class="col-sm-4 col-form-label">Lokasi<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea name="lokasi_edit" id="lokasi" class="form-control" cols="50" rows="50" placeholder="Lokasi Pusat Perusahaan" style="height: 50px;" value="{{old('lokasi')}}" required></textarea>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm float-right" type="submit" id="btn-update-consultant">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    <!-- Modal Edit -->

    <!-- MODAL TAMBAH Consultant -->
        <div class="modal fade" id="modal-add-uker" data-keyboard="true" tabindex="-1" aria-labelledby="modal-add-ukerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card-body">
                    <h5>Tambah Consultant</h5>
                    <hr>
                    <form action="{{route('manage_consultant.create_proses')}}" id="form-consultant"  method="post" class="w-100">
                        @csrf
                        <div class="row d-flex">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <label for="nama" class="col-sm-4 col-form-label">Nama Consultant<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Consultant" value="{{old('nama')}}" required>
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="bidang" class="col-sm-4 col-form-label">Bidang<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('bidang') is-invalid @enderror" id="bidang" name="bidang" placeholder="Bergerak Dibidang" value="{{old('bidang')}}" required>
                                        @error('bidang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="website" class="col-sm-4 col-form-label">Website<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Website" value="{{old('website')}}" required>
                                        @error('website')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="telepon" class="col-sm-4 col-form-label">No Telephone<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-1" id="basic-addon1">+62</span>
                                            </div>
                                            <input type="number" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" placeholder="21xxxxx" value="{{old('telepon')}}" required>
                                        </div>
                                        @error('telepon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="email" class="col-sm-4 col-form-label">Email<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{old('email')}}" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="facebook" class="col-sm-4 col-form-label">Facebook</label>
                                    <div class="col-sm-8">
                                        <input type="facebook" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" placeholder="Facebook" value="{{old('facebook')}}">
                                        @error('facebook')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="instagram" class="col-sm-4 col-form-label">Instagram</label>
                                    <div class="col-sm-8">
                                        <input type="instagram" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" placeholder="Instagram" value="{{old('instagram')}}">
                                        @error('instagram')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="tentang" class="col-sm-4 col-form-label">Tentang<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea name="tentang" id="tentang" class="form-control @error('tentang') is-invalid @enderror" cols="50" rows="50" placeholder="Tentang Perusahaan" style="height: 50px;" required>{{old('tentang')}}</textarea>
                                        @error('tentang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="lokasi" class="col-sm-4 col-form-label">Lokasi<span class="text-danger ml-1">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" cols="50" rows="50" placeholder="Lokasi Pusat Perusahaan" style="height: 50px;" required>{{old('lokasi')}}</textarea>
                                        @error('lokasi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm float-right" type="submit" id="btn-submit-consultant">Tambahkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    <!-- MODAL TAMBAH Consultant -->
@endsection
@push('page-script')
    <script>
        localStorage.clear();
    </script>
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/manage_consultant.js')}}"></script>
    <script>        
        function getData(a){
            $.ajax({
                url: "{{ url('').'/manageconsultant/detail/' }}" + a,
                type: "get",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();

                    let id = a;
                    let uri = "{{url('/manageconsultant/edit/')}}";
                    $("#form-update-consultant").attr('action', `${uri}/${a}`);
                    // console.log(a);

                    console.log(data.data.data['direktorat']);

                    if (data.data.data !== '') {
                        $("#nama").val(data.data.data['nama']);
                        $('#bidang').val(data.data.data['bidang']);
                        $("#website").val(data.data.data['website']);
                        $("#telepon").val(data.data.data['telepon']);
                        $("#email").val(data.data.data['email']);
                        $("#instagram").val(data.data.data['instagram']);
                        $("#facebook").val(data.data.data['facebook']);
                        $("#tentang").val(data.data.data['tentang']);
                        $("#lokasi").val(data.data.data['lokasi']);
                    } else {
                        $("#nama").val();
                        $('#bidang').val();
                        $("#website").val();
                        $("#telepon").val();
                        $("#email").val();
                        $("#instagram").val();
                        $("#facebook").val();
                        $("#tentang").val();
                        $("#lokasi").val();
                    }
                },
                error: function (e) {
                    $('.senddataloader').hide();
                    alert(e);
                },
            })
        };

        function hapus(a){
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

            swal.fire({ title: "Yakin Ingin Menghapusnya?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageconsultant/delete/' }}" + a,
                        type: "post",
                        data: { _method: "DELETE"},
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            Tst.fire({icon: 'success',title: "Consultant berhasil dihapus"});
                            location.reload();
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Swal.fire({ icon: "error", title: "Oops...", text: "Consultant gagal dihapus!" });
                        },
                    })
                }else{
                }
            });
        };
        $('#form-consultant').on('submit', function(e){
            $('.senddataloader').show();
        });

        $('#form-update-consultant').on('submit', function(e){
            $('.senddataloader').show();
        });
    </script>
    @if (Session::has('error'))
        <script>
            const Toast2 = Swal.mixin({
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

            var tampung = `{{ Session::get('error')}}`;
            Toast2.fire({icon: 'error',title: tampung});
        </script>
    @endif
@endpush
