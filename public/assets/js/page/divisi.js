var search = "*";;
var uri;
var sort = 'desc';
var csrf = '';
var id_consultant;
let filter_tahun = [];
var tampung;
var sklt = `<div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div>`;

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

$("#search").submit(function(e){
    if (!e.isDefaultPrevented()){
        var tampung = e.target[0].value;
        if (tampung == "" || !tampung.trim().length) {
            search = "*";
        }else{
            search = tampung;
        }
        getData();
    }
    return false;
});


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

// get data
const getData = () =>{
    var url = `${uri}/proj_div/${id_consultant}/${search}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.rowdoc').remove();

            // sklt
            $('.sklt').remove();
            $("#lst_content").append(sklt);
        },
        success: function(data){
            if(data.html == "" || data.html == null){
                $('.sklt').fadeOut().remove();          
                return;
            }
            $('.sklt').fadeOut().remove();          
            // innert html
            $("#lst_content").append(data.html);
        },
        error : function(e){
            alert(e);
            $('.senddataloader').hide();
        }
    });
}

getData();