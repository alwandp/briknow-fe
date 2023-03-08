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
                    <td colspan="3" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef">
                        Data Implementation Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:10%;">Tahap</th>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:15%;">Total Pencarian</th>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Project</th>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Pencarian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php $rowspan = count($item->search_most);@endphp
                    <tr>
                        <td rowspan="{{$rowspan}}" style='border:1px solid black;text-align:center;'>{{$item->tipe_nama}}</td>
                        <td rowspan="{{$rowspan}}" style='border:1px solid black;text-align:center;'>{{$item->search_total}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->search_most[0]->title??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->search_most[0]->views??'-'}}</td>
                    </tr>
                    @for($i=1; $i<$rowspan; $i++)
                        <tr>
                            <td style='border:1px solid black;text-align:center;'>{{$item->search_most[$i]->title??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->search_most[$i]->views??'-'}}</td>
                        </tr>
                    @endfor
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
    </body>
</html>