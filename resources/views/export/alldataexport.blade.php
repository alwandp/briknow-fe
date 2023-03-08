<html>
    <head>
        <style>
            th{
                background-color:#cccdd0;
                font-weight:bold;
            }
            td{
                word-wrap: break-word;
            }
            h3 {
                margin-bottom: 8px;
            }
            .sub-content{
                border:1px solid black;
            }
        </style>
    </head>
    <body>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;margin-bottom: 1rem">
            <thead>
                <tr>
                    <td style="background-color:#b9c3ef;border:1px solid #b9c3ef;width: 20%">
                        <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
                    </td>
                    <td colspan="6" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;width: 80%">
                        Data All Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
            </thead>

        </table>

        {{--Visitor--}}
        <h3>Pengunjung Project</h3>
        <table style="table-layout: fixed;border-collapse: collapse;width:100%;">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;border:1px solid black;text-align:center;">Tanggal</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;text-align:center;"colspan="2">Pengunjung</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataVisit as $item)
                <tr>
                    <td style="font-weight:bold;border:1px solid black;text-align:center;">{{$item->date??'-'}}</td>
                    <td style="font-weight:bold;border:1px solid black;text-align:center;"colspan="2">{{$item->jumlahpengunjung??'-'}}</td>
                </tr>
            @empty
                <tr>
                    <td style="font-weight:bold;border:1px solid black;text-align:center;">-</td>
                    <td style="font-weight:bold;border:1px solid black;text-align:center;"colspan="2">-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--Vendor--}}
        <h3>Data Consultant Beserta Project</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Vendor</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Bidang</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:5px;font-size:10px;border:1px solid black;">Website</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Telepon</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Email</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Facebook</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Instagram</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:5px;font-size:10px;border:1px solid black;">Jumlah Project</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Project</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataVendor as $item)
                <tr>
                    <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->nama_consultant}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:center;'>{{$item->bidang??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->website??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:center;'>{{phone($item->telepon)??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->email??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->facebook??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->instagram??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:center;'>{{$item->jumlah_project??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->list_project??'-'}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:left;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:left;'>-</td>
                    <td style='border:1px solid black;text-align:left;'>-</td>
                    <td style='border:1px solid black;text-align:left;'>-</td>
                    <td style='border:1px solid black;text-align:left;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:left;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--Divisi--}}
        <h3>Data Divisi Beserta Project</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Direktorat</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Divisi</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:5px;font-size:10px;border:1px solid black;">Shortname</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Jumlah Project</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">List Project</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataDiv as $item)
                <tr>
                    <td style='font-size:8px;border:1px solid black;'>{{$item->nama_direktorat}}</td>
                    <td style='font-size:8px;border:1px solid black;'>{{$item->nama_divisi??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;'>{{$item->shortname??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;'>{{$item->jumlah_project??'-'}}</td>
                    <td style='font-size:8px;border:1px solid black;'>{{$item->list_project??'-'}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--tahun--}}
        <h3>List Project Per Tahun</h3>
        <table class="sub-content table" style="font-size:10px;width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
            <tr>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:10px;width:5px;">Tanggal</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Nama Project</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Direktorat</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Divisi</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Consultant</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Status</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Tanggal Mulai</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Tanggal Selesai</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Restriction</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Maker</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Checker</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Signer</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Maker_at</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Checker_at</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Signer_at</th>
                <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">pm</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dataYear as $item)
                <tr>
                    <td class='sub-content' style="width:5px;">{{\Carbon\carbon::create($item->tanggal_mulai)->format('d M Y')}}</td>
                    <td class='sub-content'>{{$item->nama}}</td>
                    <td class='sub-content'>{{$item->divisi->direktorat}}</td>
                    <td class='sub-content'>{{$item->divisi->divisi}}</td>
                    @php
                        $temp = "INTERNAL";
                        if($item->consultant !== []){
                            foreach ($item->consultant as $item2) {
                                if ($temp === "INTERNAL") {
                                    $temp          = $item2->nama;
                                }else{
                                    $temp          = $temp.", ".$item2->nama;
                                }
                            }
                        }
                        echo "<td class='sub-content'>$temp</td>";
                    @endphp
                    @php
                        if ($item->status_finish === 0) {
                            $temp          = 'on progress';
                        }else{
                            $temp          = 'Finish';
                        }
                        echo "<td class='sub-content'>$temp</td>";
                    @endphp
                    <td class='sub-content'>{{\Carbon\carbon::create($item->tanggal_mulai)->format('d F Y')}}</td>
                    <td class='sub-content'>{{$item->status_finish === 0 ? '-' : \Carbon\carbon::create($item->tanggal_selesai)->format('d F Y')}}</td>
                    @php
                        if ($item->is_restricted === 0) {
                            $temp          = 'RESTRICTION';
                        }else{
                            $temp          = 'NON RESTRICTION';
                        }
                        echo "<td class='sub-content'>$temp</td>";
                    @endphp
                    <td class='sub-content'>{{$item->user_maker}}</td>
                    <td class='sub-content'>{{$item->user_checker}}</td>
                    <td class='sub-content'>{{$item->user_signer}}</td>
                    <td class='sub-content'>{{\Carbon\carbon::create($item->created_at)->format('d F Y')}}</td>
                    <td class='sub-content'>{{\Carbon\carbon::create($item->checker_at)->format('d F Y')}}</td>
                    <td class='sub-content'>{{\Carbon\carbon::create($item->signer_at)->format('d F Y')}}</td>
                    <td class='sub-content'>{{$item->project_managers->nama}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>