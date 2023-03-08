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
$("#btn-submit-level").click(function(e){
    e.preventDefault();
    //VALIDASI
    $('#form-level').submit();
});

$("#btn-submit-activity").click(function(e){
    e.preventDefault();
    //VALIDASI
    $('#form-act').submit();
});

$("#btn-submit-achievement").click(function(e){
    e.preventDefault();
    //VALIDASI
    $('#form-ach').submit();
    
});

$(document).ready(function(){

});