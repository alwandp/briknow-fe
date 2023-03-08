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
        <table style="table-layout: fixed;border-collapse: collapse;width:100%;">
            <tr>
                <td style="background-color:#b9c3ef;border:1px solid #b9c3ef;">
                    <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
                </td>
                <td colspan="6" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;">
                    Data Vendor Top 5 Per Tanggal {{now()->format('d F Y')}}
                </td>
            </tr>
            <tr>
                <td colspan="7"></td>
            </tr>
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
                @forelse($data as $item)
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
    </body>
</html>