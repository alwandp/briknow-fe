@extends('layouts.master_admin')
@section('title', 'BRIKNOW')
@push('style')
    <style>
        .navbar-bg {
            height: auto;
            background-color: #0e3984;
        }

        .master {
            background-color: #E5E5E5;
        }

        .btn-light {
            color: rgba(14, 57, 132, 0.5);
            background-color: #fff;
            box-shadow: 0 2px 6px #dddddd;
            margin-right: 10px;
            border-radius: 8px;
        }

        .main-footer {
            margin-top: 0;
        }

        .tr {
            margin: 20, 20, 20, 20;
        }

        .td {
            background-color: #fff;
        }
    </style>
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <h4>Dashboard</h4>
            {{-- {{$data}} --}}
            <div class="section-body">
                <div class="my-3 d-flex mx-auto flex-wrap">
                    <button type="button" class="btn btn-light mt-2 active" id="pengunjung" onclick="loadPengunjung()">Pengunjung</button>
                    <button type="button" class="btn btn-light mt-2" id="project" onclick="loadProject()">Project</button>
                    <button type="button" class="btn btn-light mt-2" id="uker" onclick="loadUker()">Uker</button>
                    <button type="button" class="btn btn-light mt-2" id="konsultan" onclick="loadKonsultan()">Konsultan</button>
                </div>
            </div>
            @include('admin.dashboard.pengunjung')
            {{-- @include('admin.dashboard.project') --}}
        </section>
    </div>
@endsection
@push('page-script')
    <script src="{{asset_app('assets/js/chart.js')}}"></script>
    <script>
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'IT Strategy\nGoverment Division',
                    'Information\nSecurity Desk',
                    'Credit Operation\nDivision',
                    'Mass Funding\nDivision',
                    'Retail Payment\nDivision',
                    'Corporate\nUniversity',
                    'Credit Restructing\n& Recovery Division',
                    'Human Capital\nDevelopment Division',
                    'Distribution\nNetwork Division',
                    'Marketing Communication\nDivision',
                    'Treasury Business\nDivision'
                ],
                datasets: [{
                    barThickness: 30,
                    label: ' Pengunjung',
                    data: [3642, 3358, 3410, 2900, 2721, 2430, 2101, 1922, 1729, 1501, 800],
                    backgroundColor: [
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                    ],
                    borderColor: [
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                        'rgba(68, 114, 196, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            callback: function (label, index, labels) {
                                if (/\s/.test(label)) {
                                    return label.split("\n");
                                } else {
                                    return label;
                                }
                            }
                        }
                    }]
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            }
        });

    </script>
@endpush
