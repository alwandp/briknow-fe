@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset_app('assets/css/review.css') }}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')

<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Project</h3>

        <!-- NAVIGASI -->
            <div class="d-flex bd-highlight">
                <div class="mr-auto p-2 bd-highlight">
                    <a class="btn btn-light btn-sm active" href="{{ route('manage_project.review') }}" role="button">Review</a>
                    <a class="btn btn-light btn-sm" href="{{ route('manage_project.rekomendasi') }}" role="button">Rekomendasi</a>
                </div>
                <!-- Dropdowns TEMP -->

                <!-- Dropdowns TEMP -->

                <!-- Dropdowns -->
                    <div class="p-2 bd-highlight" id="drop-nama-proyek">
                        <div class="dropdown show">
                            <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="modal" data-target="#modal-sort-nama" aria-haspopup="true" aria-expanded="false">
                                Konsultan
                            </a>
                        </div>
                    </div>
                    <div class="p-2 bd-highlight" id="drop-pemilik">
                        <div class="dropdown show">
                            <a class="btn btn-outline-secondary bg-white text-black-50 btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="modal" data-target="#modal-sort-pemilik" aria-haspopup="true" aria-expanded="false">
                                Pemilik Proyek
                            </a>
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
                                <input type="text" class="form-control form-control-sm" placeholder="Search Nama Project..." aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </form>
                    </div>
                <!-- Search -->
            </div>
        <!-- NAVIGASI -->

        @include('layouts.alert')

        <!-- REVIEW -->
            <div class="table-responsive" id="review">
                <table class="table" id="table-init">
                    <thead class="thead-light text-left justify-content-start align-content-start">
                        <tr>
                            <th id="th-line"
                                style="border-left: 1px solid rgba(214, 214, 214, 1); border-top-left-radius: 12px;">Nama
                                Proyek</th>
                            <th id="th-line">Direktorat</th>
                            <th id="th-line">Pemilik Proyek</th>
                            <th id="th-line">Tahun</th>
                            <th id="th-line">Status</th>
                            <th id="th-line">Tgl Upload</th>
                            <th id="th-line">Restricted</th>
                            <th id="th-line" style="border-right: 1px solid rgba(214, 214, 214, 1); border-top-right-radius: 12px;"></th>
                        </tr>
                    </thead>
                    <tbody class="text-left justify-content-start align-content-start" id="content-table-body">
                    </tbody>
                </table>
                <div class="d-flex justify-content-sm-end content-pagination" id="pag">
                </div>
            </div>
        <!-- REVIEW -->
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
    <!-- MODAL SORT PEMILIK-->
        <div class="modal fade" id="modal-sort-pemilik" tabindex="-1" aria-labelledby="modal-sort-pemilikLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card-body">
                    <form id="form-sort-1">
                        <div class="row d-flex">
                            <div class="col-md-12" id="list-pemilik-proyek">
                                <div id="listnya" class="ml-1">
                                    @forelse ($divisi_unik as $key => $val)
                                        <div class="input-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input fil_div" type="checkbox" value="{{$val}}">
                                                <label class="form-check-label">
                                                    <span>{{$val}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="d-flex justify-content-center">
                                            Tidak ada data.
                                        </div>
                                    @endforelse
                                </div>
                                <div id="group-btn">
                                    <button class="btn btn-success fil-div-app float-right mr-3" type="button" id="btn-apply-sort-pemilik">Terapkan</button>
                                    <button class="btn btn-danger fil-div-res float-right mr-2" type="button">Reset</button>
                                    <button class="btn btn-light float-right mr-2" data-dismiss="modal" id="btn-cancel-sort-pemilik">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    <!-- MODAL SORT PEMILIK-->

    <!-- MODAL SORT NAMA-->
        <div class="modal fade" id="modal-sort-nama" tabindex="-1" aria-labelledby="modal-sort-namaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="card-body">
                    <form id="form-sort-2">
                        <div class="row d-flex">
                            <div class="col-md-12" id="list-nama-proyek">
                                <div id="listnya" class="ml-1">
                                    @forelse ($nama_unik as $key => $val)
                                        <div class="input-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input fil_kon" type="checkbox" value="{{$val}}">
                                                <label class="form-check-label" for="{{$key}}-check-sort-nama">
                                                    <span>{{$val}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="d-flex justify-content-center">
                                            Tidak ada data.
                                        </div>
                                    @endforelse
                                </div>
                                <div id="group-btn">
                                    <button class="btn btn-success fil-kon-app float-right mr-3" type="button">Terapkan</button>
                                    <button class="btn btn-danger fil-kon-res float-right mr-2" type="button">Reset</button>
                                    <button class="btn btn-light float-right mr-2" data-dismiss="modal" id="btn-cancel-sort-nama">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    <!-- MODAL SORT NAMA-->
@endsection
@push('page-script')
    <script>
        localStorage.clear();
    </script>
    <script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/review.js')}}"></script>
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
        const checks_pemilik = [];
        const checks_nama = [];

        $( document ).ready(function() {
            var storedChecks_pemilik = JSON.parse(localStorage.getItem("checked_list_pemilik"));
            var storedChecks_nama = JSON.parse(localStorage.getItem("checked_list_nama"));

            $.each(storedChecks_pemilik, function( index, value ) {
                // console.log(index + ": " + value);
                checks_pemilik.push(value);
                // document.getElementById(value+"-check-sort-proyek").checked = true;
                $('#'+value+"-check-sort-proyek").prop('checked', true);
            });
            $.each(storedChecks_nama, function( index, value ) {
                // console.log(index + ": " + value);
                checks_nama.push(value);
                // document.getElementById(value+"-check-sort-nama").checked = true;
                $('#'+value+"-check-sort-nama").prop('checked', true);
            });

            console.log(checks_pemilik);
            console.log(checks_nama);


            // $(".check-pemilik").change(function() {

            // });
            // $(".check-nama").change(function() {

            // });
        });

        function publish(a){
            let t = "{{$token_auth}}";
            swal.fire({ title: "Anda yakin ingin menerbitkan Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageproject/review/publish/' }}" + a,
                        type: "post",
                        data: { _method: "POST"},
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            Toast2.fire({icon: 'success',title: 'Proyek berhasil diterbitkan'});
                                if(i.isConfirmed){
                                    location.reload();
                                }else{
                                    location.reload();
                                }
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Swal.fire({ icon: "error", title: "Oops...", text: "Project gagal diterbitkan!" });
                        },
                    })
                }
            });
        };

        function unpublish(a){
            swal.fire({ title: "Anda yakin ingin membatalkan publikasi Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageproject/review/unpublish/' }}" + a,
                        type: "post",
                        data: { _method: "POST"},
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            Toast2.fire({icon: 'success',title: 'Unpublish Proyek berhasil'});
                            if(i.isConfirmed){
                                location.reload();
                            }else{
                                location.reload();
                            }
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Toast2.fire({icon: 'error',title: 'Unpublish Proyek gagal'});
                        },
                    })
                }
            });
        };

        function hapus(a){
            let t = "{{$token_auth}}";
            swal.fire({ title: "Anda yakin akan menghapus Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
                if(i.isConfirmed){
                    $.ajax({
                        url: "{{ url('').'/manageproject/review/destroy/' }}" + a,
                        type: "DELETE",
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                            $('.senddataloader').show();
                        },
                        success: function () {
                            $('.senddataloader').hide();
                            Toast2.fire({icon: 'success',title: 'Berhasil dihapus'}); //PERLU DIGANTI BAHASANYA
                                if(i.isConfirmed){
                                    location.reload();
                                }else{
                                    location.reload();
                                }
                        },
                        error: function () {
                            $('.senddataloader').hide();
                            Toast2.fire({icon: 'error',title: 'Gagal dihapus'}); //PERLU DIGANTI BAHASANYA
                        },
                    })
                }
            });
        };
    </script>
@endpush
