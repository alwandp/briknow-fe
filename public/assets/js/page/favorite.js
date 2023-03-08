var uri;
var sort = 'asc';
var mode = 0;
var csrf = '';

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
}

// favorite
function saveFavCons(id){
    var url = `${uri}/favoritconsultant/${id}`;
    $.ajax({
        url: url,
        type: "get",
        success: function (data) {
            if (typeof data.status !== "undefined") {
                if (data.status == 1) {
                    if (data.data.kondisi == 1) {
                        getData2();
                    }else{
                        getData2();
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

function saveFavCom(id){
    var url = `${uri}/favoritcomsupport/content/${id}`;
    $.ajax({
        url: url,
        type: "get",
        success: function (data) {
            if (typeof data.status !== "undefined") {
                if (data.status == 1) {
                    if (data.data.kondisi == 1) {
                        getData3();
                    }else{
                        getData3();
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
}

function migrasi(pesan) {
    var kopi = document.getElementById("link");
    kopi.value = pesan
}

function kopas() {
    var kopi = document.getElementById("link");
    kopi.select();
    kopi.setSelectionRange(0, 99999);
    document.execCommand("copy");
}

function saveFavProj(id){
    var url = `${uri}/favoritproject/${id}`;
    $.ajax({
        url: url,
        type: "get",
        success: function (data) {
            if (typeof data.status !== "undefined") {
                if (data.status == 1) {
                    if (data.data.kondisi == 1) {
                        getData();
                    }else{
                        getData();
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

var centang2 = `<svg class="w-6 h-6 mr-2 centang2 float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
$("#az").click(function(e){
    $('.centang2').remove();
    if (sort === 'asc') {
        sort = 'asc';
    }else{
        sort = 'asc';
        $('#az').append(centang2);
    }

    if (mode === 0) {
        getData();
    }else if (mode === 1){
        getData2();
    } else {
        getData3()
    }
});
$("#za").click(function(e){
    $('.centang2').remove();
    if (sort == 'desc') {
        sort = 'asc';
    }else{
        sort = 'desc';
        $('#za').append(centang2);
    }
    
    if (mode == 0) {
        getData();
    }else if (mode === 1){
        getData2();
    } else {
        getData3()
    }
});

// get data
const getData = () =>{
    var url = `${uri}/fav_proj/${sort}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.rowdoc').remove();
            $('.senddataloader').show();
        },
        success: function(data){
            if(data.html == "" || data.html == null){
                $('.senddataloader').hide();
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#list").append(data.html);
        },
        error : function(e){
            alert(e);
        }
    });
    mode = 0;
}

const getData2 = () =>{
    var url = `${uri}/fav_cons/${sort}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.rowdoc').remove();
            $('.senddataloader').show();
        },
        success: function(data){
            if(data.html == "" || data.html == null){
                $('.senddataloader').hide();
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#list").append(data.html);
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
    mode = 1;
}

function getData3(){
    var url = `${uri}/fav_com/${sort}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.rowdoc').remove();
            $('.senddataloader').show();
        },
        success: function(data){
            if(data.html == "" || data.html == null){
                $('.senddataloader').hide();
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#list").append(data.html);
        },
        error : function(e){
            alert(e);
        }
    });
    mode = 2;
}

getData();