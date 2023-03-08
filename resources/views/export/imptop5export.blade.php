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
                        Data Implementation Top 5 Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                </tr>
                <tr>

                        <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:15%;">Tahap</th>
                    @forelse($data as $item)
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
                        @forelse($data as $item)
                            <td style='border:1px solid black;text-align:center;'>{{$item->jml}}</td>
                        @empty
                            <td style='border:1px solid black;text-align:center;'>-</td>
                            <td style='border:1px solid black;text-align:center;'>-</td>
                            <td style='border:1px solid black;text-align:center;'>-</td>
                        @endforelse
                    </tr>
            </tbody>
        </table>
    </body>
</html>