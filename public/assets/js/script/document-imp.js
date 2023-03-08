$(document).ready(function(){
    let search = {'piloting': '*', 'rollout': '*', 'sosialisasi': '*'}
    let uri;
    let order = {'piloting': 'asc', 'rollout': 'asc', 'sosialisasi': 'asc'};
    let sort = {'piloting': 'created_at', 'rollout': 'created_at', 'sosialisasi': 'created_at'};
    let csrf = '';
    let id_project = '';

// meta url
    const metass = document.getElementsByTagName('meta');
    for (let i = 0; i < metass.length; i++) {
        if (metass[i].getAttribute('name') === "pages") {
            uri = metass[i].getAttribute('content');
        }

        if (metass[i].getAttribute('name') === "csrf") {
            csrf = metass[i].getAttribute('content');
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

    id_project = $('input#id_project').val();

    $("#search-pilot").submit(function(e){
        if (!e.isDefaultPrevented()){
            let tampung = e.target[0].value;
            if (tampung == "" || !tampung.trim().length) {
                search['piloting'] = "*";
            }else{
                search['piloting'] = tampung;
            }
            getData('piloting');
        }
        return false;
    });

    $('#sort-pilot').click(function () {
        if (order['piloting'] === 'desc') {
            $('#sort-pilot').empty()
            $('#sort-pilot').append(`<i class="fas fa-sort-amount-down-alt mr-2"></i>`)
            order['piloting'] = 'asc'
        } else {
            $('#sort-pilot').empty()
            $('#sort-pilot').append(`<i class="fas fa-sort-amount-up-alt mr-2"></i>`)
            order['piloting'] = 'desc'
        }

        getData('piloting')
    })

    $('#select-file-pilot').on('change', function () {
        sort['piloting'] = $(this).val()
        getData('piloting')
    })

    $("#search-roll").submit(function(e){
        if (!e.isDefaultPrevented()){
            let tampung = e.target[0].value;
            if (tampung == "" || !tampung.trim().length) {
                search['rollout'] = "*";
            }else{
                search['rollout'] = tampung;
            }
            getData('rollout');
        }
        return false;
    });

    $('#sort-roll').click(function () {
        if (order['rollout'] === 'desc') {
            $('#sort-roll').empty()
            $('#sort-roll').append(`<i class="fas fa-sort-amount-down-alt mr-2"></i>`)
            order['rollout'] = 'asc'
        } else {
            $('#sort-roll').empty()
            $('#sort-roll').append(`<i class="fas fa-sort-amount-up-alt mr-2"></i>`)
            order['rollout'] = 'desc'
        }

        getData('rollout')
    })

    $('#select-file-roll').on('change', function () {
        sort['rollout'] = $(this).val()
        getData('rollout')
    })

    $("#search-sos").submit(function(e){
        if (!e.isDefaultPrevented()){
            let tampung = e.target[0].value;
            if (tampung == "" || !tampung.trim().length) {
                search['sosialisasi'] = "*";
            }else{
                search['sosialisasi'] = tampung;
            }
            getData('sosialisasi');
        }
        return false;
    });

    $('#sort-sos').click(function () {
        if (order['sosialisasi'] === 'desc') {
            $('#sort-sos').empty()
            $('#sort-sos').append(`<i class="fas fa-sort-amount-down-alt mr-2"></i>`)
            order['sosialisasi'] = 'asc'
        } else {
            $('#sort-sos').empty()
            $('#sort-sos').append(`<i class="fas fa-sort-amount-up-alt mr-2"></i>`)
            order['sosialisasi'] = 'desc'
        }

        getData('sosialisasi')
    })

    $('#select-file-sos').on('change', function () {
        sort['sosialisasi'] = $(this).val()
        getData('sosialisasi')
    })

    const getData = (step) =>{
        let query = `?order=${order[step]}`
        if (search[step] && search[step] !== '*') {
            query += `&search=${search[step]}`
        }
        if (sort[step]) {
            query += `&sort=${sort[step]}`
        }
        let url = `${uri}/list_doc/${step}/${id_project}${query}`;
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function()
            {
                $(`#coloumnrow-${step}`).empty();
                $('.senddataloader').show();
            },
            success: function(data){
                if(data.html == "" || data.html == null){
                    $('.senddataloader').hide();
                    return;
                }
                $('.senddataloader').hide();
                // innert html
                $(`#coloumnrow-${step}`).append(data.html);

                // set default input form
                $(`#btn-archive-${step}`).attr('disabled',true);
                $(`#allcheck-${step}`).prop('checked',false);
            },
            error : function(e){
                $('.senddataloader').hide();
                alert(e);
            }
        });
    }
})

function allCheckChange(step) {
    if ($(`#allcheck-${step}`).prop('checked')) {
        $(`input[name=file-${step}]`).prop('checked',true);
    } else {
        $(`input[name=file-${step}]`).prop('checked',false);
    }
    klik(step);
}

function archive(step, id) {
    const files = $(`input[name=file-${step}]`);
    let tampung = [];
    let urut = 0;
    for (let i = 0; i < files.length; i++) {
        if (files[i].checked === true) {
            tampung[urut] = files[i].value;
            urut++;
        }
    }

    let data_send = {
        "data":tampung
    };

    let url = `${uri}/archive/implementation`;
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
            if (data == false) {
                alert('Gagal Mengarchieve File');
            }else{
                window.open(data , '_blank');
                downloadFile('implementation', id)
                $('.senddataloader').hide();
                $(`.file-${step}`).prop('checked',false);
                $(`input[name=file-${step}]`).prop('checked',false);
                unaktif_archive(step);
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function klik(step) {
    const files = $(`input[name=file-${step}]`);
    let cek = 0;
    let jml_cek = 0;
    for (let i = 0; i < files.length; i++) {
        if (files[i].checked === true) {
            cek = 1;
            jml_cek++
        }
    }
    if (jml_cek === files.length) {
        $(`#allcheck-${step}`).prop('checked',true);
    } else {
        $(`#allcheck-${step}`).prop('checked',false);
    }
    if (cek == 1) {
        aktif_archive(step);
    } else {
        unaktif_archive(step);
    }
}

function aktif_archive(step) {
    // $('#btn-archive').attr('class','btn btn-sm btn-primary d-inline');
    $(`#btn-archive-${step}`).removeClass('btn-secondary')
    $(`#btn-archive-${step}`).addClass('btn-primary')
    $(`#btn-archive-${step}`).attr('disabled',false);
}

function unaktif_archive(step) {
    // $('#btn-archive').attr('class','btn btn-sm btn-secondary d-inline');
    $(`#btn-archive-${step}`).removeClass('btn-primary')
    $(`#btn-archive-${step}`).addClass('btn-secondary')
    $(`#btn-archive-${step}`).attr('disabled',true);
    $(`#allcheck-${step}`).prop('checked',false);
}

function docClick(doc) {
    if (doc.implementation_id) {
        downloadFile('implementation', doc.implementation_id)
    }
}

function downloadFile(tipe, id) {
    const url = `${uri}/communication/download/${tipe}/${id}`

    $.ajax({
        url: url,
        type: 'post',
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function () {
        },
        error: function () {
            Toast2.fire({icon: 'error',title: 'Gagal'});
        },
    })
}
