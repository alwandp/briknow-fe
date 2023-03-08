<style>
    th{
        font-weight:bold;
    }
    .table{
        border-collapse: separate;
        border-spacing: 0;
        text-align:center;
    }
    .sub-content{
        border:1px solid black;
    }
    td{
        word-wrap: break-word;
    }
</style>
<table>
    <tr style="height:5px;">
        <td style="width:400px;">
            <img src="{{public_path("assets/icon-32.png")}}" style="width:20px;margin-top:5px;" alt="">
            <b>TOP 10 KEYWORD TERPOPULER {{now()->format('d F Y')}}</b>
        </td>
    </tr>
</table>
<br>
<table style="width:100%;" class="sub-content table">
    <thead>
        <tr>
            <th  class="sub-content"style="background-color:#cccdd0;font-weight:bold;">Jumlah Pencarian</th>
            <th  class="sub-content"style="background-color:#cccdd0;font-weight:bold;">Keyword</th>
            <th  class="sub-content"style="background-color:#cccdd0;font-weight:bold;">Project Terkait</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataEX as $item)
            <tr>
                <td class="sub-content" >{{$item->keyword_log_count}}</td>
                <td class="sub-content" >{{$item->nama}}</td>
                <td class="sub-content" >{{$item->related}}</td>
            </tr>
        @endforeach
    </tbody>
</table>