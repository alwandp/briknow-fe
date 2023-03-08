var uri;
var sort        = 'desc';
var csrf        = '';
var id_forum    = window.location.href;
var be          = '';

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
        be = metas[i].getAttribute('content');
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

// ckeditor
    const ckeditor = (urut = '',mode = null) =>{
        // handle jika comment masih di utama / sub
        if (mode == null) {
            // utama
            CKEDITOR.replace(`editor-comment${urut}`, {
                filebrowserUploadUrl: `${be}api/upimgcontent`,
                filebrowserUploadMethod: 'xhr',             
                fileTools_requestHeaders: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'csrftoken': csrf 
                },
                on: {
                    instanceReady: function( evt ) {
                        $('.cke_bottom').append('<button type="submit" class="btn btn-primary mx-1 sendcomment">Send</button>');
                    }
                }
            });
        }else{
            // sub
            CKEDITOR.replace(`editor-comment${urut}`, {
                filebrowserUploadUrl: `${be}api/upimgcontent`,
                filebrowserUploadMethod: 'xhr',             
                fileTools_requestHeaders: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'csrftoken': csrf 
                },
                on: {
                    instanceReady: function( evt ) {
                        $('.cke_bottom').append(`<button type="submit" class="btn sendcomment mx-1">Send</button>`);
                    }
                }
            });
        }

        CKEDITOR.config.toolbar = [
            { name: 'styles', items: [ 'Styles' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline'] },
            { name: 'document', items: ['Preview', 'Print'] },
            { name: 'insert', items: [ 'Image', 'Table', 'EmojiPanel'] },
            { name: 'clipboard', items: ['Undo', 'Redo' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'colors', items: [ 'BGColor' ] },
        ];
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraPlugins = 'emoji';
        CKEDITOR.config.toolbarLocation = 'bottom';
        CKEDITOR.config.resize_enabled = false;
    }


//INI BELUM DI INTEGRASI DI FORUM DETAIL COMMENT

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
        <div class="card w-100 shadow rep-${urut} ml-1 mb-0">
            <form action="#" class="form" onsubmit="komen(event,this,${parent},${project_id},${reply_to},${urut});">
                <div class="loadercomment" id="loader${urut}">
                    <div class="loading">
                        <img src="${uri}/assets/img/loading.gif" width="60px" draggable="false" alt="">
                    </div>
                </div>
                <div>
                    <textarea class="px-0 w-100 reply commentform" name="comment" placeholder="Tulis komentar" id="editor-comment${urut}" placeholder="Tulis komentar" data-emoji-input="unicode" data-parent="" data-id="" data-reply="" data-emojiable="true" required></textarea>
                </div>
            </form> 
        </div>
    `);
    ckeditor(urut,'subreply');
    $(e).attr('onclick','hreply(this)');
}

const hreply = (e) => {
    var urut  = e.id;
    $(`.rep-${urut}`).fadeOut();
    $(`.rep-${urut}`).remove();
    $(`.reply${urut}`).attr('onclick','reply(this)');
};

const komen = (e,el,p=null,frm_id,maker_id,urut=null) => {
    e.preventDefault();
    // cek
    var formValues= $(el).serializeArray();
    var koment    = CKEDITOR.instances[`editor-comment${urut}`].getData();
    if (koment !== '' || koment !== null) {
        var data_send = {
            "komentar"      :koment,
            "parent_form"   :p,
            "forum_form"    :frm_id,
            "reply_form"    :maker_id,
        };
        console.log(data_send);
        var url = `${uri}/komentarforum`;
        $.ajax({
            url: url,
            headers: {'X-CSRF-TOKEN': csrf},
            type: "POST",
            data: data_send,
            beforeSend: function()
            {
                $(`#loader${urut}`).fadeIn();
            },
            success: function(data){
                $(`#loader${urut}`).fadeOut();
                if (data.status == 0) {
                    Toast.fire({icon: 'error',title: 'Komentar Failed'});
                }else{
                    $('.comment-area').empty();
                    $('.comment-area').append(data.html);
                }
            },
            error : function(e){
                // console.log(e);
                $(`#loader${urut}`).fadeOut();
                Toast.fire({icon: 'error',title: 'Komentar Failed'});
            }
        });
    }
    return false;
}

ckeditor();