var csrf = '';
var uri = '';
var BE = '';
var search  = '*';
var page    = 1;
var sklt = `<div class="col-md-12 sklt mt-2"><div class="ph-item border control list-manageforum mb-2"><div class="content-manageforum-area"><div class="ph-row h-100"><div class="ph-col-6 h-50 thumb-lg"></div><div class="ph-col-8 mt-3"></div></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-manageforum mb-2"><div class="content-manageforum-area"><div class="ph-row h-100"><div class="ph-col-6 h-50 thumb-lg"></div><div class="ph-col-8 mt-3"></div></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-manageforum mb-2"><div class="content-manageforum-area"><div class="ph-row h-100"><div class="ph-col-6 h-50 thumb-lg"></div><div class="ph-col-8 mt-3"></div></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-manageforum mb-2"><div class="content-manageforum-area"><div class="ph-row h-100"><div class="ph-col-6 h-50 thumb-lg"></div><div class="ph-col-8 mt-3"></div></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-manageforum mb-2"><div class="content-manageforum-area"><div class="ph-row h-100"><div class="ph-col-6 h-50 thumb-lg"></div><div class="ph-col-8 mt-3"></div></div></div></div></div>`;
// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
    if (metas[i].getAttribute('name') === "BE") {
        BE = metas[i].getAttribute('content');
    }
}

//toast
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

$("#search").submit(function(e){
    if (!e.isDefaultPrevented()){
        if ($("#sort-all").hasClass('active')) {
            var tampung = e.target[0].value;
            page = 1;
            if (tampung == "" || !tampung.trim().length) {
                search = "*";
            }else{
                search = tampung;
            }
            getdatalist();
        } else if ($("#sort-private").hasClass('active')) {
            var tampung = e.target[0].value;
            page = 1;
            if (tampung == "" || !tampung.trim().length) {
                search = "*";
            }else{
                search = tampung;
            }
            sortPrivate();
        } else if ($("#sort-public").hasClass('active')) {
            var tampung = e.target[0].value;
            page = 1;
            if (tampung == "" || !tampung.trim().length) {
                search = "*";
            }else{
                search = tampung;
            }
            sortPublic();
        }
    }
    return false;
});

$(document).on('click', '.pagination a', function(event){
    event.preventDefault(); 
    page = $(this).attr('href').split('page=')[1];
    getdatalist(page);
});

const getdatalist = () =>{
var url = `${uri}/manageforum/all/${search}?page=${page}`;
    $.ajax({
        url: url,
        headers: {
            "X-CSRF-TOKEN"  :   csrf,
            "Accept"        :   "application/json"
        },
        type: "get",
        beforeSend: function()
        {
            $('.forum-content').empty();
            $('.forum-content').append(sklt);
            $('#pag').empty();
        },
        success: function(data){
            if(data.data.html == "" || data.data.html == null){
                    $('.sklt').fadeOut().remove();
                return;
            }
            $('.sklt').fadeOut().remove();
            // innert html
            $(".forum-content").append(data.data.html);
            $("#pag").append(data.data.paginate);
            $("#sort-all").addClass('active');
            $("#sort-public").removeClass('active');
            $("#sort-private").removeClass('active');
        },
        error : function(xhr, status, error){
            console.log(xhr.responseText);
            console.log(error.Message);
            Toast2.fire({icon: 'error',title: 'Get Forum Failed'});
            // alert(error);
            console.log(error);
            $('.senddataloader').hide();
        }
    });
}

const remove = (id) =>{
    let t = "{{$token_auth}}";
    var url = `${uri}/manageforum/all/remove/` + id;
    swal.fire({ title: "Yakin ingin menghapus postingan?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
        if(i.isConfirmed){
            $.ajax({
                url: url,
                headers: {
                    "X-CSRF-TOKEN"  :   csrf,
                    "Accept"        :   "application/json"
                },
                type: "post",
                beforeSend: function(xhr){
                    $('.senddataloader').show();
                },
                success: function () {
                    $('.senddataloader').hide();
                    swal.fire({ title: "Postingan berhasil dihapus!", text: "", icon: "success",confirmButtonColor: "#3085d6", confirmButtonText: "Ok"}).then((i) => {
                        if(i.isConfirmed){
                            location.reload();
                        }else{
                            location.reload();
                        }});
                },
                error: function () {
                    $('.senddataloader').hide();
                    Swal.fire({ icon: "error", title: "Oops...", text: "Postingan gagal dihapus!" });
                },
            })
        }else{
            swal.fire("Postingan tidak jadi dihapus!");
        }
    });
};

function sortPrivate() {
var url = `${uri}/manageforum/all/sort/private/${search}?page=${page}`;
    $.ajax({
        url: url,
        headers: {
            "X-CSRF-TOKEN"  :   csrf,
            "Accept"        :   "application/json"
        },
        type: "get",
        beforeSend: function()
        {
            $('.forum-content').empty();
            $('.forum-content').append(sklt);
            $('#pag').empty();
        },
        success: function(data){
            if(data.data.html == "" || data.data.html == null){
                    $('.sklt').fadeOut().remove();
                return;
            }
            $('.sklt').fadeOut().remove();
            // innert html
            $(".forum-content").append(data.data.html);
            $("#pag").append(data.data.paginate);
            $("#sort-private").addClass('active');
            $("#sort-all").removeClass('active');
            $("#sort-public").removeClass('active');
        },
        error : function(xhr, status, error){
            console.log(xhr.responseText);
            console.log(error.Message);
                Toast2.fire({icon: 'error',title: 'Sort Forum Failed'});
            // alert(error);
            console.log(error);
            $('.senddataloader').hide();
        }
    });
}

function sortPublic() {
var url = `${uri}/manageforum/all/sort/public/${search}?page=${page}`;
    $.ajax({
        url: url,
        headers: {
            "X-CSRF-TOKEN"  :   csrf,
            "Accept"        :   "application/json"
        },
        type: "get",
        beforeSend: function()
        {
            $('.forum-content').empty();
            $('.forum-content').append(sklt);
            $('#pag').empty();
        },
        success: function(data){
            if(data.data.html == "" || data.data.html == null){
                    $('.sklt').fadeOut().remove();
                return;
            }
            $('.sklt').fadeOut().remove();
            // innert html
            $(".forum-content").append(data.data.html);
            $("#pag").append(data.data.paginate);
            $("#sort-public").addClass('active');
            $("#sort-all").removeClass('active');
            $("#sort-private").removeClass('active');
        },
        error : function(xhr, status, error){
            console.log(xhr.responseText);
            console.log(error.Message);
                Toast2.fire({icon: 'error',title: 'Sort Forum Failed'});
            // alert(error);
            console.log(error);
            $('.senddataloader').hide();
        }
    });
}

getdatalist();  