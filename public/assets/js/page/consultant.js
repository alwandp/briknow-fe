var search = "*";;
var uri;
var sort = 'desc';
var csrf = '';
var id_consultant;
let filter_tahun = [];
var tampung;
var sklt = `<div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div>`;

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "id_consultant") {
        id_consultant = metas[i].getAttribute('content');
    }
}

$(".riwayat_tahun").click(function(e){
    tampung = $(this).attr("data-value");
    var url = `${uri}/riwayat/${tampung}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.senddataloader').show();
            localStorage.setItem('fil_div',[]);
            localStorage.setItem('fil_thn',[]);
            localStorage.setItem('fil_kon',[]);

        },
        success: function(data){
            $('.senddataloader').hide();
            if (typeof(data.data) !== 'undefined') {
                var temp    =   data.data[tampung];
                console.log(temp);
                temp.forEach((slicing));
                localStorage.setItem("fil_thn",filter_tahun);
                window.open(`${uri}/katalog`,'_blank');
            }
        },
        error : function(e){
            alert(e);
            $('.senddataloader').hide();
        }
    });
});

function slicing(item) {
    filter_tahun.push(`${tampung}-${item.bulan}`);
}

$("#search").submit(function(e){
    if (!e.isDefaultPrevented()){
        var tampung = e.target[0].value;
        if (tampung == "" || !tampung.trim().length) {
            search = "*";
        }else{
            search = tampung;
        }
        // console.log(search);
        getData();
    }
    return false;
});

var centang = `<svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
$("#baru").click(function(e){
    $('.centang').remove();
    sort = 'desc';
    $('#baru').append(centang);
    getData();
});
$("#lama").click(function(e){
    $('.centang').remove();
    sort = 'asc';
    $('#lama').append(centang);
    getData();
});

// favorite
$("#btn-favoritcons").click(function(e){
    saveFavCons();
});

function saveFavCons(){
    let t = "{{$token_auth}}";
    var url = `${uri}/favoritconsultant/${id_consultant}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization","Bearer " + t);
        },
        success: function (data) {
            console.log(data);
            if (typeof data.status !== "undefined") {
                if (data.status == 1) {
                    if (data.data.kondisi == 1) {
                        $("#btn-favoritcons").attr('class','btn btn-sm px-2 control btn-control rounded font-weight-normal aktip');
                        $("#star").attr('class','fas fa-star mr-1 gold');
                    }else{
                        $("#btn-favoritcons").attr('class','btn btn-sm px-2 control btn-control rounded font-weight-normal');
                        $("#star").attr('class','far fa-star mr-1');
                    }
                }else{
                    alert('Proses Favorite Gagal, Coba lagi');
                }
            }else{
                alert('Proses Favorite Gagal, Coba lagi');
            }
        },
        error: function (e) {
            alert('Proses Favorite Gagal, Coba lagi');
        },
    })
};

// get data
const getData = () =>{
    var url = `${uri}/proj_cons/${id_consultant}/${search}/${sort}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.rowdoc').remove();
            $('#notice').remove();

            // sklt
            $('.sklt').remove();
            $("#list_project").append(sklt);
        },
        success: function(data){
            console.log(data);
            $('#notice').remove();
            if(data.html == "" || data.html == null){
                // sklt
                $('.sklt').fadeOut().remove();          

                $('#notice').remove();
                $("#list_project").append(
                    `<div class="col-md-12 text-center" id="notice">
                        Tidak ada project.
                    </div>`
                );
                return;
            }
            // sklt
            $('.sklt').fadeOut().remove();

            // innert html
            $("#list_project").append(data.html);
        },
        error : function(e){
            alert(e);
            $('#notice').remove();
            $('.senddataloader').hide();
        }
    });
}

getData();