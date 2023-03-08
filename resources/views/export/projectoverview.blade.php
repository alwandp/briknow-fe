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
            <thead>
                <tr>
                    <td colspan="3" style="background-color:#cccdd0;font-weight:bold;border:1px solid black;text-align:center;">
                        Pengunjung Project Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
                <tr>
                    <th style="background-color:#cccdd0;font-weight:bold;width:20px;border:1px solid black;text-align:center;">Tanggal</th>
                    <th style="background-color:#cccdd0;font-weight:bold;width:30px;border:1px solid black;text-align:center;"colspan="2">Pengunjung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
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
    </body>
</html>