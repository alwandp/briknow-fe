var uri;
var csrf = '';
let id_project = '';
id_project = $('input#id_project').val();

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
    
    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

const Toast2 = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
}
});

function getData() {
    const url = `${uri}/communication/views/implementation/${id_project}`
    let t = "{{$token_auth}}";

    $.ajax({
        url: url,
        type: 'post',
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
            $('#coloumnrow-piloting').empty()
            $('#coloumnrow-rollout').empty()
            $('#coloumnrow-sosialisasi').empty()
        },
        success: function (data) {
            $('.senddataloader').hide();
            if (data.data.desc_piloting !== null) {
                $('#coloumnrow-piloting').append(data.col.piloting);
            }
            if (data.data.desc_roll_out !== null) {
                $('#coloumnrow-rollout').append(data.col.rollout);
            }
            if (data.data.desc_sosialisasi !== null) {
                $('#coloumnrow-sosialisasi').append(data.col.sosialisasi);
            }
        },
        error: function () {
            $('.senddataloader').hide();
            Toast2.fire({icon: 'error',title: 'Gagal'});
        },
    })
}

getData();

function migrasi(pesan) {
    var kopi = document.getElementById("link");
    kopi.value = pesan
}

let a = document.getElementById("generate");
var b = document.getElementById("link");
b.value = a.value;

function kopas() {
    var kopi = document.getElementById("link");
    kopi.select();
    kopi.setSelectionRange(0, 99999);
    document.execCommand("copy");
}

function saveFavCom(e, id){
    const $child = $(e).children()
    var url = `${uri}/favoritcomsupport/implementation/${id}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
        },
        success: function (data) {
            $('.senddataloader').hide();
            if (typeof data.status !== "undefined") {
                if (data.status === 1) {
                    if (data.data.kondisi === 1) {
                        $(e).addClass('aktip')
                        $child.addClass('gold')
                    } else {
                        $(e).removeClass('aktip')
                        $child.removeClass('gold')
                    }
                }else{
                    alert('Proses Favorite Gagal, Coba lagi');
                }
            }else{
                alert('Proses Favorite Gagal, Coba lagi');
            }
        },
        error: function (e) {
            $('.senddataloader').hide();
            alert('Proses Favorite Gagal, Coba lagi');
        },
    })
}
