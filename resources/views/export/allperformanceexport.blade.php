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
                        Data All Performance Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
            </thead>

        </table>

        {{--Project--}}
        <h3>Project Top 5</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;margin-bottom: 2rem">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:20px;">Nama Project</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;">Direktorat</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;">Divisi</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:40px;border:1px solid black;">Consultant</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;border:1px solid black;">Tanggal Mulai</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;border:1px solid black;">Tanggal Selesai</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;border:1px solid black;">Pengunjung</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataProject as $item)
                <tr>
                    <td style='border:1px solid black;text-align:center;'>{{$item->namaproject}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->direktorat??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->divisi??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->consultant}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->tanggalmulai}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->tanggalselesai}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->jumlahpengunjung}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--Vendor--}}
        <h3>Vendor Top 5</h3>
        <table style="table-layout: fixed;border-collapse: collapse;width:100%;margin-bottom: 2rem">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;width:60px;border:1px solid black;">Vendor</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;border:1px solid black;">Bidang</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;border:1px solid black;">Website</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;border:1px solid black;">Telepon</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10px;border:1px solid black;">Email</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;border:1px solid black;">Lokasi</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:20px;border:1px solid black;">Pengunjung</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataVendor as $item)
                <tr>
                    <td style='border:1px solid black;text-align:center;'>{{$item->nama??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->bidang??'-'}}</td>
                    <td style='border:1px solid black;'>{{$item->website??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{phone($item->telepon)??'-'}}</td>
                    <td style='border:1px solid black;'>{{$item->email??'-'}}</td>
                    <td style='border:1px solid black;'>{{$item->lokasi??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->jumlahpengunjung??'-'}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--Lesson--}}
        <h3>Lesson Learned Top 5</h3>
        <table style="width:70%;table-layout: fixed;border-collapse: collapse;margin-bottom: 2rem">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:70%;">Tahap</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:30%;border:1px solid black;">Jumlah</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataLesson as $item)
                <tr>
                    <td style='border:1px solid black;text-align:center;'>{{$item->tahap}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->jml??'-'}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--ComInit--}}
        <h3>Communication Initiative Top 5</h3>
        <table style="width:70%;table-layout: fixed;border-collapse: collapse;margin-bottom: 2rem">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:70%;">Tipe</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:30%;border:1px solid black;">Jumlah View</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataCom as $item)
                <tr>
                    <td style='border:1px solid black;text-align:center;'>{{$item->type_file}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->jml??'-'}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--Strategic--}}
        <h3>Strategic Initiative Top 5</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;margin-bottom: 2rem">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:20%;">Nama Project</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:35%;border:1px solid black;">Direktorat</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:35%;border:1px solid black;">Divisi</th>
                <th style="background-color:#cccdd0;font-weight:bold;width:10%;border:1px solid black;">Views Content</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataStr as $item)
                <tr>
                    <td style='border:1px solid black;text-align:center;'>{{$item->nama}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->direktorat??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->divisi??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->jml}}</td>
                </tr>
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                    <td style='border:1px solid black;text-align:center;'>-</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{--IMP--}}
        <h3>Implementation Top 5</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;margin-bottom: 2rem">
            <thead>
                <tr>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:15%;">Tahap</th>
                    @forelse($dataImp as $item)
                        <th style="background-color:#e3e3e3;font-weight:bold;border:1px solid black;width:28%;text-align:center">{{$item->tahap}}</th>
                    @empty
                        <th style="background-color:#e3e3e3;font-weight:bold;border:1px solid black;width:28%;text-align:center">Piloting</th>
                        <th style="background-color:#e3e3e3;font-weight:bold;border:1px solid black;width:28%;text-align:center">Roll-out</th>
                        <th style="background-color:#e3e3e3;font-weight:bold;border:1px solid black;width:28%;text-align:center">Sosialisasi</th>
                    @endforelse
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Views</th>
                    @forelse($dataImp as $item)
                        <td style='border:1px solid black;text-align:center;'>{{$item->jml}}</td>
                    @empty
                        <td style='border:1px solid black;text-align:center;'>-</td>
                        <td style='border:1px solid black;text-align:center;'>-</td>
                        <td style='border:1px solid black;text-align:center;'>-</td>
                    @endforelse
                </tr>
            </tbody>
        </table>

        {{--TAGS--}}
        <h3>Keywords Top 10</h3>
        <table style="width:100%;border-collapse: separate;border-spacing: 0;text-align:center;" class="sub-content table">
            <thead>
            <tr>
                <th  class="sub-content" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Jumlah Pencarian</th>
                <th  class="sub-content" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Keyword</th>
                <th  class="sub-content" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Project Terkait</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dataTag as $item)
                <tr>
                    <td class="sub-content" style='border:1px solid black;text-align:center;'>{{$item->keyword_log_count}}</td>
                    <td class="sub-content" style='border:1px solid black;text-align:center;'>{{$item->nama}}</td>
                    <td class="sub-content" style='border:1px solid black;text-align:center;'>{{$item->related}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>