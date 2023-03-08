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
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;margin-bottom: 1rem">
            <thead>
            <tr>
                <td style="background-color:#b9c3ef;border:1px solid #b9c3ef;width: 20%">
                    <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
                </td>
                <td colspan="6" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;width: 80%">
                    Data All Communication Support Per Tanggal {{now()->format('d F Y')}}
                </td>
            </tr>
            </thead>

        </table>

        <h3>Communication Initiative</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
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
                @forelse($dataInitiative as $item)
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

        <h3>Strategic Initiative</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
            <tr>
                <th rowspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:10%;">Project</th>
                <th rowspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:10%;">Total Pencarian Project</th>
                <th rowspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:10%;">Tipe</th>
                <th rowspan="2" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:10%;">Pencarian</th>
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
            @forelse($dataStrategic as $item)
                @php $rowspan = $item->rowspan;@endphp
                @php $rowspan1 = count($item->strategic);@endphp
                @php $rowspanm = count($item->strategic[0]->views_most);@endphp
                <tr>
                    <td rowspan="{{$rowspan}}" style='border:1px solid black;text-align:center;'>{{$item->nama}}</td>
                    <td rowspan="{{$rowspan}}" style='border:1px solid black;text-align:center;'>{{$item->search_total}}</td>
                    <td rowspan="{{$rowspanm}}" style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->tipe??'-'}}</td>
                    <td rowspan="{{$rowspanm}}" style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->search??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->views_most[0]->title??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->views_most[0]->views??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->downloads_most[0]->downloads??'-'}}</td>
                    <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->downloads_most[0]->downloads??'-'}}</td>
                </tr>
                @for($i=1; $i<$rowspanm; $i++)
                    <tr>

                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->views_most[$i]->title??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->views_most[$i]->views??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->downloads_most[$i]->downloads??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[0]->downloads_most[$i]->downloads??'-'}}</td>
                    </tr>
                @endfor
                @for($i=1; $i<$rowspan1; $i++)
                    @php $rowspan2 = count($item->strategic[$i]->views_most);@endphp
                    <tr>
                        <td rowspan="{{$rowspan2}}" style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->tipe??'-'}}</td>
                        <td rowspan="{{$rowspan2}}" style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->search??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->views_most[0]->title??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->views_most[0]->views??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->downloads_most[0]->downloads??'-'}}</td>
                        <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->downloads_most[0]->downloads??'-'}}</td>
                    </tr>
                    @for($j=1; $j<$rowspan2; $j++)
                        <tr>
                            <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->views_most[$j]->title??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->views_most[$j]->views??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->downloads_most[$j]->downloads??'-'}}</td>
                            <td style='border:1px solid black;text-align:center;'>{{$item->strategic[$i]->downloads_most[$j]->downloads??'-'}}</td>
                        </tr>
                    @endfor
                @endfor
            @empty
                <tr>
                    <td style='border:1px solid black;text-align:center;'>-</td>
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

        <h3>Implementation</h3>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
            <tr>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:10%;">Tahap</th>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:15%;">Total Pencarian</th>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Project</th>
                <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;">Pencarian</th>
            </tr>
            </thead>
            <tbody>
            @forelse($dataImp as $item)
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