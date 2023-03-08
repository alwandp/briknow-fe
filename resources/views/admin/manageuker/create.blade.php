@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-admin.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    
    <link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
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
@section('csrf',session()->get('token')??"")

@section('content')
    <div class="row">
        <div class="col-md-12" id="konten">
            <div class="d-flex bd-highlight mt-3">
                <div class="mr-auto pt-2 bd-highlight">
                    <h3>Manage Uker - Create</h3>
                </div>
            </div>
        <div class="d-flex">
            <form action="{{route('manage_uker.create_proses')}}" id="form"  method="post" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3">
                    </div>
                </div>
                <fieldset class="form-group row">
                    <legend class="col-form-label col-sm-2 float-sm-left pt-0">Radios</legend>
                    <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                        <label class="form-check-label" for="gridRadios1">
                        First radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                        <label class="form-check-label" for="gridRadios2">
                        Second radio
                        </label>
                    </div>
                    <div class="form-check disabled">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
                        <label class="form-check-label" for="gridRadios3">
                        Third disabled radio
                        </label>
                    </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck1">
                        <label class="form-check-label" for="gridCheck1">
                        Example checkbox
                        </label>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script src="{{asset_app('assets/js/page/uker.js')}}"></script>
    <script>
        $(document).ready(function() {
            $.fn.select2.defaults.set( "theme", "bootstrap" );
        });
    </script>
@endpush
