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
                    <td colspan="5" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef">
                        Data Communication Initiative Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <th rowspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:15%;">Tipe</th>
                    <th rowspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:15%;">Total Pencarian</th>
                    <th colspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">View Terbanyak</th>
                    <th colspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Download Terbanyak</th>
                </tr>
                <tr>
                    <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;">Judul</th>
                    <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;">Views</th>
                    <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;">Judul</th>
                    <th style="background-color:#cccdd0;font-weight:bold;width:40px;border:1px solid black;">Downloads</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php $rowspan = count($item->views_most);@endphp
                    <tr>
                        <td rowspan="{{$rowspan}}" style='border:1px solid black;text-align:center;'>{{$item->tipe_nama}}</td>
                        <td rowspan="{{$rowspan}}" style='border:1px solid black;text-align:center;'>{{$item->search}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->views_most[0]->title??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->views_most[0]->views??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->downloads_most[0]->title??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->downloads_most[0]->downloads??'-'}}</td>
                    </tr>
                    @for($i=1; $i<$rowspan; $i++)
                        <tr>
                            <td style='border:1px solid black;text-align:center;'>{{$item->views_most[$i]->title??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->views_most[$i]->views??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->downloads_most[$i]->title??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->downloads_most[$i]->downloads??'-'}}</td>
                        </tr>
                    @endfor
                @empty
                    <tr>
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