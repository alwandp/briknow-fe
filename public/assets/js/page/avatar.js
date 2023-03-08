var search = "*";;
var uri;
var sort = 'desc';
var csrf = '';
var avatar_id;
var avatar_id_current;

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "id_project") {
        avatar_id = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
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


$( document ).ready(function() {
    $(".ava-touch").click(function(e){
        // clearing
        $('.checked-avatar').fadeOut().remove();
        $('.ava-active').attr('class','rounded-circle ava relative');

        // set style pointer checked
        $(this).after(`
            <div class="avatar-cover checked-avatar" style="display:none;">
                <div class="text-center">
                    <i class="fas fa-check text-success" style="font-size:50px;"></i>
                </div>
            </div>
        `);
        $('.checked-avatar').fadeIn();
        $(this).attr('class','rounded-circle ava-active relative')

        // handle value avatar id
        avatar_id_current     =    $(this).attr('data-id');
        if (avatar_id === avatar_id_current) {
            $('.control').empty();
        }else{
            $('.control').empty();
            $('.control').append(`
                                    <div>
                                        <button class="btn btn-outline-primary" onclick='discard()'>Discard</button>
                                        <button class="btn btn-primary btn-save">Save Changes</button>
                                    </div>
                                `);
            
            //fungsi btn-save
            $('.btn-save').click(function(e){
                var url = `${uri}/changeavatar`;
                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': csrf},
                    type: "POST",
                    data: {avatar:avatar_id_current},
                    beforeSend: function(){
                        $(`.senddataloader`).show();
                    },
                    success: function(data){
                        $(`.senddataloader`).hide();
                        if (data.status == 1) {
                            Toast2.fire({icon: 'success',title: data.data.message});
                            location.reload();
                        }else{
                            Toast2.fire({icon: 'error',title: data.data.message});
                        }
                    },
                    error : function(e){
                        Toast2.fire({icon: 'error',title: 'Avatar Gagal Di Perbarui'});
                        console.log(e);
                    }
                });
            });
        }
    });
});

const discard = () => {
    console.log(avatar_id);
    // clearing
    $('.checked-avatar').fadeOut().remove();
    $('.ava-active').attr('class','rounded-circle ava relative');

    // back to default
    $(`img[data-id="${avatar_id}"]`).after(`
        <div class="avatar-cover checked-avatar" style="display:none;">
            <div class="text-center">
                <i class="fas fa-check text-success" style="font-size:50px;"></i>
            </div>
        </div>
    `);
    $('.checked-avatar').fadeIn();
    $(`img[data-id="${avatar_id}"]`).attr('class','rounded-circle ava-active relative');

    // set pointer current
    avatar_id_current     =    avatar_id;

    //control hide
    $('.control').fadeOut().empty();
}