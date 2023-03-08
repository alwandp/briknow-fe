var uri_notification;
var csrf_notification = '';

// meta url
var header = document.getElementsByTagName('meta');
for (let i = 0; i < header.length; i++) {
    if (header[i].getAttribute('name') === "pages") {
        uri_notification = header[i].getAttribute('content');
    }
    
    if (header[i].getAttribute('name') === "csrf") {
        csrf_notification = header[i].getAttribute('content');
    }
}

const Toast_profile = Swal.mixin({
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

$("#read_notif").click(function(e){
    var url = `${uri_notification}/notif`;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf_notification},
        type: "POST",
        success: function(data){
            $('.push-pop').fadeOut().remove();
            $("#read_notif").attr('id','');
        },
        error : function(e){
            console.log(e);
        }
    });
});

$("#direktorat_edit_profile").change(function(e){
    var temp        =   $("#direktorat_edit_profile option").filter(':selected').val();
    var url         =   `${uri_notification}/getdivisi/${temp}`;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf_notification},
        type: "GET",
        beforeSend: function()
        {
            $("#divisi_edit_profile option").each(function() {
                $(this).remove();
            });
            $('#direktorat_edit_profile').attr('disabled', true);
            $('#divisi_edit_profile').attr('disabled', true);
        },
        success: function(data){
            $('#direktorat_edit_profile').attr('disabled', false);
            $('#divisi_edit_profile').attr('disabled', false);

            var option = "<option value='' selected disabled>Pilih Divisi</option>";
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                }
            }
            $('#divisi_edit_profile').append(option);
        },
        error : function(e){        
            console.log(`Get Data Divisi Failed`);
        }
    });
});

$("#form-edit-prof").submit(function(e) {
    e.preventDefault();
    var url         =   `${uri_notification}/editprof`;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf_notification},
        type: 'POST',
        data: $(this).serialize(),     
        beforeSend: function()
        {
            $('.senddataloader').show();
        },        
        success: function(data){
            $('.senddataloader').hide();
            $('#editprofil').modal('hide');
            if (data.status === 1) {
                var tampung = `Profile Berhasil Diperbarui`;
                Toast_profile.fire({icon: 'success',title: tampung});   
            }else{
                var tampung = `Profile Gagal Diperbarui`;
                Toast_profile.fire({icon: 'error',title: tampung});
            }
        },
        error : function(e){   
            $('.senddataloader').hide();
            $('#editprofil').modal('hide');
            var tampung = `Profile Gagal Diperbarui`;
            Toast_profile.fire({icon: 'error',title: tampung});
        }
    });
});