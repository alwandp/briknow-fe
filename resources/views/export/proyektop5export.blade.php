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
        </style>
    </head>
    <body>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
                <tr>
                    <td style="background-color:#b9c3ef;border:1px solid #b9c3ef;">
                        <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
                    </td>
                    <td colspan="6" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef">
                        Data Proyek Top 5 Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                </tr>
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
                @forelse($data as $item)
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
    </body>
</html>