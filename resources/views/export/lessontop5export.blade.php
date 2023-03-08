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
                    <td style="background-color:#b9c3ef;border:1px solid #b9c3ef;width: 20%">
                        <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
                    </td>
                    <td style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;width: 80%">
                        Data Lesson Learned per Tahap Project Top 5 Per Tanggal {{now()->format('d F Y')}}
                    </td>
                </tr>
            </thead>

        </table>
        <table style="width:100%;table-layout: fixed;border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color:#cccdd0;font-weight:bold;border:1px solid black;width:70%;">Tahap</th>
                    <th style="background-color:#cccdd0;font-weight:bold;width:30%;border:1px solid black;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
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
    </body>
</html>