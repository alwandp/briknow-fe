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

//validasi
$("#btn-submit").click(function(e){
    e.preventDefault();
    // alert($('#hakakses').val());
    $('#status').val('1');
    const checkTabPost = document.querySelector('#post-tab');
    const checkTabLink = document.querySelector('#link-tab');
    var msgLengthPost = CKEDITOR.instances['editorpost'].getData().replace(/<[^>]*>/gi, '').length;
    if ($("#title").val().length == 0) {
        Toast2.fire({icon: 'error',title: 'Judul tidak boleh kosong'});
    } else if ($("#title").val().length < 12) {
        Toast2.fire({icon: 'error',title: 'Judul terlalu pendek'});
    } else if (!$("#hakakses").val()) {
        Toast2.fire({icon: 'error',title: 'Harap pilih hak akses'});
    } else if ($("#hakakses").val() == '1' && $("#user_private").val().length == 0) {
        Toast2.fire({icon: 'error',title: 'User Restricted tidak boleh kosong'});
    } else {
        if (checkTabPost.classList.contains('active')) {
            if( !msgLengthPost ) {
                Toast2.fire({icon: 'error',title: 'Isi post tidak boleh kosong!'});
            } else if (msgLengthPost <= 15) {
                Toast2.fire({icon: 'error',title: 'Isi post kurang dari 15 karakter!'});
            } else { //ketika 2 kondisi diatas terpenuhi
                $('#form').submit();
            }
        } else if (checkTabLink.classList.contains('active')) {
            let isValid = validateUrl($('#editorlink').val());
            if (!$('#editorlink').val()) {
                Toast2.fire({icon: 'error',title: 'URL tidak boleh kosong'});
            } else if (isValid == false) {
                Toast2.fire({icon: 'error',title: 'Harap memasukan url yang benar'});
            } else {
                $('#form').submit();
            }
        }
    }
    return false;
});

$("#btn-draft").click(function(e){
    e.preventDefault();
    // alert($('#hakakses').val());
    $('#status').val('0');
    const checkTabPost = document.querySelector('#post-tab');
    const checkTabLink = document.querySelector('#link-tab');
    var msgLengthPost = CKEDITOR.instances['editorpost'].getData().replace(/<[^>]*>/gi, '').length;
    if ($("#title").val().length == 0) {
        Toast2.fire({icon: 'error',title: 'Judul tidak boleh kosong'});
    } else if ($("#title").val().length < 12) {
        Toast2.fire({icon: 'error',title: 'Judul terlalu pendek'});
    } else if (!$("#hakakses").val()) {
        Toast2.fire({icon: 'error',title: 'Harap pilih hak akses'});    
    } else {
        if (checkTabPost.classList.contains('active')) {
            if( !msgLengthPost ) {
                Toast2.fire({icon: 'error',title: 'Isi post tidak boleh kosong!'});
            } else if (msgLengthPost <= 15) {
                Toast2.fire({icon: 'error',title: 'Isi post kurang dari 15 karakter!'});
            } else { //ketika 2 kondisi diatas terpenuhi
                $('#form').submit();
            }
        } else if (checkTabLink.classList.contains('active')) {
            let isValid = validateUrl($('#editorlink').val());
            if (!$('#editorlink').val()) {
                Toast2.fire({icon: 'error',title: 'URL tidak boleh kosong'});
            } else if (isValid == false) {
                Toast2.fire({icon: 'error',title: 'Harap memasukan url yang benar'});
            } else {
                $('#form').submit();
            }
        }
    }
    return false;
});

function validateUrl(value) {
    return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(value);
}

$(document).ready(function(){
    $('#hakakses').change(function(){
        if ($(this).children("option:selected").val() == 1) {
            $('#restricted').attr('style','display:grid;');
        }else{
            $('#restricted').attr('style','display:none;');
        }
    });
});