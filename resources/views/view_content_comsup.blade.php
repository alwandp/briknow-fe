@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-proj.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/content-consum.css')}}">

@endpush

@push('page-script')
    <script src="{{asset_app('assets/js/page/mproject.js')}}"></script>
@endpush

@section('content')
    <div class="modal fade" id="modalcontent" tabindex="-1" role="document" aria-labelledby="modalcontent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content p-2">
                <div class="modal-header d-flex">
                    <h5 class="modal-title mr-auto p-2" id="modalcontentTitle">Modal title</h5>
                    <button type="button" class="btn btn-primary fas fa-download p-2 mr-2" >
                    </button>
                    <button type="button" class="btn btn-outline-secondary fas fa-share-alt-square p-2" >
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="p-2">
                            <img src="{{asset_app('assets/img/belum_ada_forum.png')}}" class="img-content mb-3"/>
                        </div>
                        <div class="p-2">
                            <h4>JUDUL ARTIKEL</h4>
                        </div>
                        <div class="p-2">
                            <p>LOREM IPSUM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('page-script')
    <script>
        $(window).on('load', function() {
            $('#modalcontent').modal({backdrop: 'static', keyboard: false});
        });
    </script>
@endpush
