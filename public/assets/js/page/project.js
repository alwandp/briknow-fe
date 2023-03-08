var search = "*";;
var uri;
var sort = 'desc';
var csrf = '';
var id_project;

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
    
    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
    
    if (metas[i].getAttribute('name') === "id_project") {
        id_project = metas[i].getAttribute('content');
    }
}

const Toast = Swal.mixin({
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

const aktif_archive = () => {
    $('#btn-archive').attr('class','btn btn-sm btn-primary d-inline');
    $('#btn-archive').attr('disabled',false);
}

const unaktif_archive = () => {
    $('#btn-archive').attr('class','btn btn-sm btn-secondary d-inline');
    $('#btn-archive').attr('disabled',true);
    $('#allcheck').prop('checked',false);
}

$("#allcheck").change(function(e){
    if ($('#allcheck').prop('checked')) {
        $('.file').prop('checked',true);
    } else {
        $('.file').prop('checked',false);
    }
    klik();
});

$("#btn-archive").click(function(e){
    const files = document.getElementsByClassName('file');
    var tampung = [];
    var urut = 0;
    for (let i = 0; i < files.length; i++) {
        if (files[i].checked === true) {
            tampung[urut] = files[i].value;
            urut++;
        }
    }

    var data_send = {
        "data":tampung
    };

    var url = `${uri}/archive`;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf},
        type: "POST",
        data: data_send,
        beforeSend: function()
        {
            $('.senddataloader').show();
        },
        success: function(data){
            console.log(data);
            if (data == false) {
                alert('Gagal Mengarchieve File');
            }else{
                window.open(data , '_blank');
                $('.senddataloader').hide();
                $('.file').prop('checked',false);
                unaktif_archive();
            }
        },
        error : function(e){
            alert(e);
        }
    });
});

const klik = () => {
    const files = document.getElementsByClassName('file');
    var cek = 0;
    for (let i = 0; i < files.length; i++) {
        if (files[i].checked === true) {
            cek = 1;
        }
    }
    if (cek == 1) {
        aktif_archive();
    } else {
        unaktif_archive();
    }
};

// const preview = (url) => {
//     console.log(url);
//     var iframe = document.createElement('iframe');
//     iframe.style.display = "none";
//     iframe.src = url;
//     iframe.class = "w-100 h-100";
//     $('#content-preview').append(iframe);
// }

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

var centang = `<svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
$("#baru").click(function(e){
    if (sort !== 'desc') {
        $('#dropdownMenuLink').text('Terbaru')
        $('.centang').remove();
        sort = 'desc';
        $('#baru').append(centang);
        getData();
    }
});
$("#lama").click(function(e){
    if (sort !== 'asc') {
        $('.centang').remove();
        sort = 'asc';
        $('#lama').append(centang);
        getData();
    }
});

// favorite
$("#btn-favoritproj").click(function(e){
    saveFavProj();
});

function saveFavProj(){
    let t = "{{$token_auth}}";
    var url = `${uri}/favoritproject/${id_project}`;
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
                        $("#btn-favoritproj").attr('class','btn btn-sm px-2 control btn-control rounded font-weight-normal aktip');
                        $("#star").attr('class','fas fa-star mr-1 gold');
                    }else{
                        $("#btn-favoritproj").attr('class','btn btn-sm px-2 control btn-control rounded font-weight-normal');
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
    var url = `${uri}/doc_proj/${id_project}/${search}/${sort}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.rowdoc').remove();
            $('#prev').empty();
            $('.senddataloader').show();
        },
        success: function(data){
            if(data.html == "" || data.html == null){
                $('.senddataloader').hide();
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#coloumnrow").append(data.html);
            $("#prev").append(data.preview);

            // set default input form
            $("#btn-archive").attr('disabled',true);
        },
        error : function(e){
            alert(e);
        }
    });
}

getData();

// comment
const showc = (selector) => {
    // handle button control
    $(`.label-handle-${selector}`).hide();
    $(`#handle-${selector}`).append(`<svg class="w-6 h-6 temp-${selector}" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> <span class="temp-${selector}">Hide Replies</span>`);
    $(`#handle-${selector}`).attr('onclick',`hidec('${selector}')`);
    $(`.sub-${selector}`).fadeIn();
}
const hidec = (selector) => {
    // handle button control
    $(`.label-handle-${selector}`).show();
    $(`.temp-${selector}`).remove();
    $(`#handle-${selector}`).attr('onclick',`showc('${selector}')`);
    $(`.sub-${selector}`).fadeOut();
}

const reply = (e) => {
    var urut        = e.id;
    var parent      = $( e ).data( "parent" );
    var project_id  = $( e ).data( "prj" );
    var reply_to    = $( e ).data( "reply" );
    
    $(`.reply-${urut}`).after(`
        <div class="card w-100 shadow rep-${urut} ml-1 mb-1">
            <form action="#" class="form" onsubmit="komen(event,this,${parent},${project_id},${reply_to});">
                <div class="px-3 pt-3">
                <textarea class="px-0 w-100 reply commentform${urut}" name="komentar" placeholder="Tulis komentar" data-emoji-input="unicode" data-parent="" data-id="" data-reply="" data-emojiable="true" required></textarea>
                </div>
                <div class="ml-auto px-3 d-flex justify-content-end py-2">
                <button type="button" class="btn btn-secondary btn-sm mx-1" onclick="hreply(this);" id="${urut}">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                </div>
            </form>
        </div>
    `);
    $(`.commentform${urut}`).emojioneArea({
        emojiPlaceholder: ":smile_cat:",
        searchPlaceholder: "Pencarian",
        buttonTitle: "Use your TAB key to insert emoji faster",
        searchPosition: "bottom",
        pickerPosition: "bottom",
        tonesStyle: "bullet"
    });
    $(e).attr('onclick','hreply(this)');
}

const hreply = (e) => {
    var urut  = e.id;
    $(`.rep-${urut}`).fadeOut();
    $(`.rep-${urut}`).remove();
    $(`.reply${urut}`).attr('onclick','reply(this)');
};

const komen = (e,el,p=null,prj_id,maker_id) => {
    e.preventDefault();
    // cek
    var formValues= $(el).serializeArray();
    console.log(formValues);
    if (formValues[0].value !== '' || formValues[0].value !== null) {
        console.log(formValues[0]);
        var data_send = {
            "komentar"      :formValues[0].value,
            "parent_form"   :p,
            "project_form"  :prj_id,
            "reply_form"    :maker_id,
        };
        console.log(data_send);
        var url = `${uri}/komentar`;
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': csrf},
            type: "POST",
            data: data_send,
            beforeSend: function()
            {
                $('.loadercomment').fadeIn();
            },
            success: function(data){
                $('.loadercomment').fadeOut();
                if (data.status == 0) {
                    Toast.fire({icon: 'error',title: 'Komentar Failed'});
                }else{
                    $('.comment-area').empty();
                    $('.comment-area').append(data.html);
                    // emoji
                    $(`.commentform`).emojioneArea({
                        emojiPlaceholder: ":smile_cat:",
                        searchPlaceholder: "Pencarian",
                        buttonTitle: "Use your TAB key to insert emoji faster",
                        searchPosition: "bottom",
                        pickerPosition: "bottom",
                        tonesStyle: "bullet"
                    });
                }
            },
            error : function(e){
                // console.log(e);
                $('.loadercomment').fadeOut();
                Toast.fire({icon: 'error',title: 'Komentar Failed'});
            }
        });
    }
    return false;
}