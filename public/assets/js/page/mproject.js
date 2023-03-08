var uri;
var csrf = '';

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

function urlSave() {
    localStorage.setItem("url", "/myproject");
}

const views = (slug) =>{
    var url = `${uri}/myproject/preview/`+slug;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf},
        type: "get",
        beforeSend: function()
        {
            $('.senddataloader').show();
            $('.content-preview').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            $('.content-preview').append(data.html);
            $('#coloumnrow').append(data.col);
            $('#modalpreview').modal({
                show : true
            });
        },
        error : function(e){
            $('.senddataloader').hide();
            console.log('Gagal memuat preview project. ERROR: '+e);
        }
    });
}

function downloadDoc(name, source) {
    window.location.href = uri+`/doc/download?source=${source}&file_name=${name}`;
}

const closemodal = () =>{
    $('#modalpreview').modal({
        show : false
    });
    console.log('problem');
}

function appr(a, b){
    let t = "{{$token_auth}}";
    let ref = "";
    if (b == 1) { //All Role - Approve
        ref = "Anda yakin ingin menyetujui Proyek ini?";
        rep_ok   = "Proyek berhasil disetujui";
        rep_fail = "Proyek gagal disetujui!";
        btn_txt = "APPROVE";
    } else if (b == 2) { //hanya berlaku untuk role admin dengan skenario setelah membuat proyek memilih draft
        ref = "Anda yakin ingin menyetujui dan menerbitkan Proyek ini?"; //lebih hemat teks
        rep_ok   = "Proyek berhasil disetujui dan diterbitkan";
        rep_fail = "Proyek gagal disetujui dan diterbitkan!";
        btn_txt = "APPROVE & PUBLISH";
        // ref = "Anda yakin ingin menyetujui dan menerbitkan Proyek ini?"; //lebih detail teks
    } else if (b == 0) { //USER (MAKER) - SEND
        ref = "Anda yakin akan mengirim Proyek ini?"; //lebih hemat teks
        rep_ok   = "Proyek berhasi dikirim";
        rep_fail = "Proyek gagal dikirim!";
        btn_txt = "SEND";
    }
    swal.fire({ title: ref, text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: btn_txt, cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            var url = `${uri}/myproject/appr/`+a;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': csrf},
                type: "post",
                beforeSend: function(xhr){
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();
                    if (typeof(data.status) == 'undefined') {
                        Toast2.fire({icon: 'error', title: rep_fail});
                    }else{
                        if (data.status == 1) {
                            Toast2.fire({icon: 'success', title: rep_ok});
                            location.reload();
                        }else{
                            Toast2.fire({icon: 'error',title: rep_fail});
                            // Swal.fire({ icon: "error", title: "Gagal", text: data.message });
                        }
                    }
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: rep_fail});
                },
            })
        }
    });
};

function hapus(a){ //byUser dari MyProject (Ketika belum dikirim ke Checker) -- STATUS : DRAFT
    let t = "{{$token_auth}}";
    swal.fire({ title: "Anda yakin ingin menghapus Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "DELETE", cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            var url = `${uri}/myproject/hapus/`+a;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': csrf},
                type: "post",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("Authorization","Bearer " + t);
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();
                    if (typeof(data.status) == 'undefined') {
                        Toast2.fire({icon: 'error',title: 'Proyek gagal dihapus!'});
                    }else{
                        if (data.status == 1) {
                            Toast2.fire({icon: 'success',title: 'Proyek berhasil dihapus'});
                            location.reload();
                        }else{
                            Toast2.fire({icon: 'error',title: 'Proyek gagal dihapus!'});
                        }
                    }
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: 'Proyek gagal dihapus!'});
                },
            })
        }
    });
};

function send(a){
    let t = "{{$token_auth}}";
    swal.fire({ title: "Anda yakin ingin mengirim Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "SEND", cancelButtonText: "CANCEL", }).then((i) => {
        if(i.isConfirmed){
            var url = `${uri}/myproject/send/`+a;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': csrf},
                type: "post",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("Authorization","Bearer " + t);
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();
                    if (typeof(data.status) == 'undefined') {
                        Toast2.fire({icon: 'error',title: 'Proyek gagal dikirim!'});
                    }else{
                        if (data.status == 1) {
                            Toast2.fire({icon: 'success',title: 'Proyek berhasil dikirim'});
                            location.reload();
                        }else{
                            Toast2.fire({icon: 'error',title: 'Proyek gagal dikirim!'});
                        }
                    }
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: 'Proyek gagal dikirim!'});
                },
            })
        }
    });
};

function reject(a){
    let t = "{{$token_auth}}";
    var url = `${uri}/myproject/reject/`+a;
    swal.fire({ title: "Anda yakin ingin menolak Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#dc3545", cancelButtonColor: "#6c757d", confirmButtonText: "REJECT", cancelButtonText: "CANCEL", }).then((i) => {
        if(i.isConfirmed){
            const { value: text } = Swal.fire({
                input: 'textarea',
                inputLabel: 'Tuliskan alasan Anda',
                inputPlaceholder: 'Masukan alasan penolakan...',
                inputAttributes: {
                    'aria-label': 'Masukan alasan penolakan'
                },
                inputValidator: (value) => {
                    if(!value || value == 0){
			            Toast2.fire({icon: 'error', title: 'Wajib Mencantumkan Catatan'});
			            return false;
	 	            }else if (!value || value <= 15) {
                        Toast2.fire({icon: 'error',title: 'Alasan terlalu singkat'});
                        return false;
                    } else {
                        // Toast2.fire({icon: 'success',title: value});
                        $.ajax({
                            url: url,
                            headers: {'X-CSRF-TOKEN': csrf},
                            type: "post",
                            data: value,
                            beforeSend: function(xhr){
                                xhr.setRequestHeader("Authorization","Bearer " + t);
                                $('.senddataloader').show();
                            },
                            success: function (data) {
                                $('.senddataloader').hide();
                                if (typeof(data.status) == 'undefined') {
                                    Toast2.fire({icon: 'error',title: 'Proyek gagal ditolak!'});
                                }else{
                                    if (data.status == 1) {
                                        Toast2.fire({icon: 'success',title: 'Proyek berhasil ditolak'});
                                        location.reload();
                                    }else{
                                        Toast2.fire({icon: 'error',title: 'Proyek gagal ditolak!'});
                                    }
                                }
                            },
                            error: function () {
                                $('.senddataloader').hide();
                                Toast2.fire({icon: 'error',title: 'Proyek gagal ditolak!'});
                            },
                        })
                    }
                },
                showCancelButton: true,
                confirmButtonText: "Submit",
                cancelButtonText: "Back",
                confirmButtonColor: "#28a745",
            })
        }
    });
};
