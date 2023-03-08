let BE                      = '';
let uri                     = '';
let base_url                = '';
let token                   = '';
let csrf                   = '';
/*let old_photo               = '';
let old_hidden_photo        = '';*/
let project = [];
const slug = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)
let formSubmitting = false;
const today = new Date();

const Toast3 = Swal.mixin({
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

const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "token") {
        token = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "kunci") {
        BE = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "base_url") {
        base_url = metas[i].getAttribute('content');
    }
}

const $parent = $('#parent');
$parent.change(function () {
    const $projectContent = $('#content-project')
    if ($(this).val() === "1") {
        let content =   `
            <div class="form-group project-link" style="width: 70%;">
                <label for="link" class="label-cus">Nama Proyek</label>
                <select class="select2 form-control" id="link" name="link" placeholder='Nama Proyek' required>
                </select>
<!--                <input type="text" class="form-control" style="width: 70%; height: 40px" id="link" name="link" placeholder="Project Link">-->
            </div>
        `

        // $projectContent.append($(content).hide().fadeIn(300));
        $projectContent.fadeIn(300, function () {
            $(this).removeClass('d-none')
            $('#form-gr-direktorat').removeClass('d-none')
            $('#project').attr('required', true)
            $('#direktorat').attr('required', true)
            $('#form-gr-divisi').removeClass('d-none')
            $('#divisi').attr('required', true)
        })
    } else {
        $projectContent.fadeOut(300, function () {
            $(this).addClass('d-none')
            $('#form-gr-direktorat').addClass('d-none')
            $('#project').attr('required', false)
            $('#direktorat').attr('required', false)
            $('#form-gr-divisi').addClass('d-none')
            $('#divisi').attr('required', false)
        })
        // $('.project-link').fadeOut(300, function () {$(this).remove()});
    }

    $('#project').select2({
        placeholder : 'Nama Proyek'
    });

    $('#direktorat').select2({
        placeholder : 'Pilih Direktorat'
    });

    $('#divisi').select2({
        placeholder : 'Pilih Unit Kerja'
    });

    $("#project").select2({
        placeholder: 'Nama Proyek',
        tags: true,
        minimumInputLength: 1,
        templateResult: formatSelect,
        language: {
            inputTooShort: function (args) {
                return "Type at least 1 character";
            },
        },
        createTag: function (tag) {
            return {
                id: tag.term,
                text: tag.term,
                isNew : true
            };
        },
        ajax: {
            url: `${base_url}/searchproject`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                // Query parameters will be ?search=[term]
                return {
                    search: params.term,
                    nonpublic: 'Y',
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });
})

function todayFormatter(date = today) {
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

const $preview = $('#preview')
const $photo = $('#photo')

function readFile(input) {
    const type_file = ['application/x-zip-compressed', 'zip', 'rar']
    const name_file = input.files[0].name;
    if (type_file.includes(input.files[0].type) || type_file.includes(name_file.split('.')[1])) {
        $('#file').val('')
        Toast3.fire({icon: 'error',title: 'Tipe file tidak sesuai !'});
        return;
    }
    for (let f in input.files) {
        if (input.files[f] instanceof File) {
            showPreview(input.files[f])
        }
    }
}

function readThumbnail(input) {
    const type_file = ['image/png', 'image/jpg', 'image/jpeg']
    if (!type_file.includes(input.files[0].type)) {
        $photo.val('')
        Toast3.fire({icon: 'error',title: 'Tipe file tidak sesuai !'});
        return;
    }

    $('#drop-wrap').css({border: 'none'})
    $('#thumbnail-prev').remove()
    $('#thumbnail-del').remove()
    $('#thumbnail-loading').remove()
    let src = URL.createObjectURL(input.files[0])
    let imagePrev = `
        <img id="thumbnail-prev" class="blur-image thumbnail-prev" src="${src}" alt="thumbnail" />
        <div id="thumbnail-del" title="Hapus" class="thumbnail-delete d-flex align-items-center justify-content-center d-none" onclick="removeThumbnailPreview()">
            <i class="fas fa-times" style="font-size: 24px"></i>
        </div>
        <div id="thumbnail-loading" style="height: inherit; width: inherit; position:absolute; z-index: 88;" class="d-flex align-items-center justify-content-center">
            <i class="fas fa-circle-notch fa-spin" style="font-size: 70px"></i>
        </div>
    `

    $('#thumbnail-desc').append($(imagePrev).hide().fadeIn(300));

    if($('#form').hasClass('was-validated')){
        $("#thumbnail-prev").attr("style", "border:solid 1px #38c172;");
    }

    let form_data = new FormData();
    form_data.append('thumbnail', input.files[0]);
    if ($('#thumbnail').val()) {
        form_data.append('del', $('#thumbnail').val());
    }

    $.ajax({
        url: uri+'/up/thumbnail',
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(res){
            $('#hidden-thumbnail').empty()
            $('#thumbnail-loading').fadeOut(200, function () {$(this).remove()});
            $('#thumbnail-del').removeClass('d-none')
            $('#thumbnail-prev').removeClass('blur-image')

            let hidden_thumb = `<input type="hidden" class="d-none" id="thumbnail" name="thumbnail" value="${res}">`
            let hidden_temp = `<input type="hidden" class="d-none" id="temp" name="temp[]" value="${res}">`
            $('#hidden-thumbnail').append(hidden_thumb);
            $('#hidden-thumbnail').append(hidden_temp);
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Upload Gagal'});
            $('#thumbnail-prev').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail').remove().val('');
            $('#thumbnail-del').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail-loading').remove();
            $('#drop-wrap').css({border: 'dashed 1px black'})
            $photo.val('')

            if($('#form').hasClass('was-validated')){
                $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
            }
        },
    });
}

function showPreview(file) {
    const unique_name = Date.now().toString(36) + Math.random().toString(36).substring(2) + file.name.replace(/ /g, "")
    const timemillis = Date.now()
    let htmlPreview = [
        '<div id="prev'+timemillis+'" class="d-flex align-items-center mb-3" style=" width: 50%; height: 40px;">',
            '<div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">',
                '<div class="d-flex align-items-center justify-content-between" style="width: 100%">',
                    '<div class="align-items-center text-elip">',
                        '<i class="fas fa-file mr-3"></i>',file.name,
                    '</div>',
                    '<div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Cancel" onclick="removePreview(this, \'cancel\')">',
                        '<i class="fas fa-circle-notch fa-spin"></i>',
                    '</div>',
                '</div>',
            '</div>',
            '<div id="loading" class="d-flex align-items-center" style="width: 20px;">',
                '<p class="m-0 d-flex align-items-center">Uploading&nbsp;<span class="loadings">...</span></p>',
            '</div>',
        '</div>'
    ]

    // $preview.removeClass('hidden');
    $preview.append($(htmlPreview.join('')).hide().fadeIn(300))

    let $container = $('#prev'+timemillis+'')
    let id = $container.attr('id')

    if($('#form').hasClass('was-validated')){
        $("#attach-wrap").attr("style", "border:solid 1px #38c172;");
    }

    let form_data = new FormData();
    form_data.append(`content_communication_support`, file);

    $.ajax({
        url: uri+`/up/content_communication_support`,
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(res){
            let $first = $container.children().first().children()
            $first.addClass('detail-prev')

            let $click = $first.children().last()
            $click.prop("onclick", null).off("click");
            $click.on('click', function () {
                removePreview(this, 'delete')
            })
            let $icon = $click.find(':first-child')
            $icon.removeClass('fa-circle-notch fa-spin')
            $icon.addClass('fa-times')
            $icon.prop('title', 'Delete')

            let $last = $container.children().last()
            $last.children().remove()
            $last.append('<div class="d-flex align-items-center" style="border-radius: 50%; padding: 6px 5px 4px; border: 2px solid #218838; color: #218838">' +
                '<i style="font-size: 10px" class="fas fa-check"></i></div>')

            const input_hidden = `<input type="hidden" name="attach[]" id="attach" value="${res}">`
            const temp_hidden = `<input type="hidden" name="temp[]" id="temp" value="${res}">`
            $('#prev'+timemillis).append(input_hidden)
            $('#prev'+timemillis).append(temp_hidden)
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Upload Gagal'});
            removePreview(this, 'cancel')
        },
    });
}

function removePreview(id, type) {
    if (type === 'cancel') {
        $(id).parent().parent().parent().fadeOut(300, function () {
            $(this).remove()
            if ( $preview.children().length === 0 ) {
                $('#file').val('')
            }
            if($('#form').hasClass('was-validated')){
                $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
            }
        });
    } else {
        let $last = $(id).parent().parent().parent().children().last()
        let form_data = new FormData();
        form_data.append(`content_communication_support`, $last.val());
        form_data.append('isNew', slug === 'content' ? "1" : "0");
        $.ajax({
            url: uri+`/delete/content_communication_support`,
            data: form_data,
            type: 'post',
            contentType: false,
            processData: false,
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function(response){
                $(id).parent().parent().parent().fadeOut(300, function () {
                    $(this).remove()
                    if ( $preview.children().length === 0 ) {
                        $('#file').val('')
                        const attr = $('#file').attr('required');
                        if (typeof attr === 'undefined' || attr === false) {
                            $('#file').attr('required', true)
                        }
                        if($('#form').hasClass('was-validated')){
                            $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
                        }

                        if (slug !== 'content') {
                            const hidden_del = `<input type="hidden" name="temp_delete[]" value="${response.request.path}">`
                            $('#temp_delete').append(hidden_del)
                        }
                    }
                });
            },
            error: function () {
                Toast3.fire({icon: 'error',title: 'Delete Gagal'});
            },
        });
    }

    /*if ( $preview.children().length === 0 ) {
        $preview.addClass('hidden')
    }*/
}

function removeThumbnailPreview() {
    let form_data = new FormData();
    form_data.append('thumbnail', $('#thumbnail').val());
    form_data.append('isNew', slug === 'content' ? "1" : "0");
    $.ajax({
        url: uri+'/delete/thumbnail',
        data: form_data,
        type: 'post',
        contentType: false,
        processData: false,
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
        },
        success: function(response){
            $('#thumbnail-prev').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail').remove().val('');
            $('#thumbnail-del').fadeToggle(300, function () {$(this).remove()});
            $('#thumbnail-loading').remove();
            $('#drop-wrap').css({border: 'dashed 1px black'})
            $photo.val('')

            if($('#form').hasClass('was-validated')){
                $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
            }

            if (slug !== 'content') {
                const hidden_del = `<input type="hidden" name="temp_delete[]" value="${response.request.path}">`
                $('#temp_delete').append(hidden_del)
            }

            const attr = $('#photo').attr('required');
            if (typeof attr === 'undefined' || attr === false) {
                $('#photo').attr('required', true)
            }
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Delete Gagal'});
        },
    });
}

function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}
$('#file').change(function(){
    readFile(this);
});
$photo.change(function(){
    readThumbnail(this);
});
let $dropWrap = $('.dropzones-wrapper')
$dropWrap.on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragover');
});
$dropWrap.on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass('dragover');
});
$dropWrap.on('drop', function(e) {
    /*e.preventDefault();
    e.stopPropagation();*/
    $(this).removeClass('dragover');
});
$('.remove-preview').on('click', function() {
    var boxZone = $(this).parents('.preview-zone').find('.box-body');
    var previewZone = $(this).parents('.preview-zone');
    var dropzones = $(this).parents('.form-group').find('.dropzones');
    boxZone.empty();
    previewZone.addClass('hidden');
    reset(dropzones);
});

function cekValid() {
    const $form = $('#form')
    let curInputs = $form.find("input[type='text'],input[type='url'],input[type='file'],input[type='date'],input[type='email'],select")
    for(let i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid){
            return false;
        }
    }
    return checkEditor()
}

$(document).ready(function () {
    CKEDITOR.on("instanceReady", function(event) {
        $("#cke_deskripsi").addClass('border-none');
    });
    $('#submit').on('click', function () {
        const $form = $('#form')
        let curInputs = $form.find("input[type='text'],input[type='url'],input[type='file'],input[type='date'],input[type='email'],select")
        let isValid;

        $(".form-control").removeClass("is-invalid");
        // $(".thumbnail-input").removeClass("is-invalid");
        $form.removeClass('was-validated');
        $form.addClass('was-validated');
        for(let i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-control").addClass("is-invalid");
                // $(curInputs[i]).closest("#drop-wrap").addClass("is-invalid");
            }
        }

        if($('#photo').hasClass('is-invalid')){
            $("#drop-wrap").attr("style", "border:1px solid #e3342f;");
        }else{
            $("#thumbnail-prev").attr("style", "border:solid 1px #38c172;");
        }

        if($('#project').hasClass('is-invalid')){
            $("[aria-labelledby='select2-project-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-project-container']").attr("style", "border-color:#38c172;");
        }

        // direktorat
        if($('#direktorat').hasClass('is-invalid')){
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:#38c172;");
        }

        // divisi
        if($('#divisi').hasClass('is-invalid')){
            $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:#38c172;");
        }

        // file type
        if($('#file_type').hasClass('is-invalid')){
            $("[aria-labelledby='select2-file_type-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-file_type-container']").attr("style", "border-color:#38c172;");
        }

        if($('#file').hasClass('is-invalid')){
            $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
        }else{
            $("#attach-wrap").attr("style", "border:solid 1px #38c172;");
        }

        checkEditor()
        isValid = cekValid()

        if (isValid) {
            formSubmitting = true;
            $('form#form').submit();
            $('.senddataloader').show();
        }

    })

    $('#project').select2({
        placeholder : 'Based on project',
        tags: true,
    });

    $('#direktorat').select2({
        placeholder : 'Pilih Direktorat'
    });

    $('#divisi').select2({
        placeholder : 'Pilih Unit Kerja'
    });

    $('#file_type').select2({
        placeholder : 'Pilih Jenis File'
    });

    $("#project").select2({
        placeholder: 'Nama Proyek',
        tags: true,
        minimumInputLength: 1,
        templateResult: formatSelect,
        language: {
            inputTooShort: function (args) {
                return "Type at least 1 character";
            },
        },
        createTag: function (tag) {
            return {
                id: tag.term,
                text: tag.term,
                isNew : true
            };
        },
        ajax: {
            url: `${base_url}/searchproject`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                // Query parameters will be ?search=[term]
                return {
                    search: params.term,
                    nonpublic: 'Y',
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });
});

function formatSelect(project) {
    let contents = `<div class="d-flex align-items-center" id="container">`;
    if (project !== null && project !== undefined) {
        if (project.image !== null && project.image !== undefined) {
            let src = `${uri}/storage/${project.image}`
            contents += `<div><img src='${src}' alt="${project.text}" onerror="imgError(this)" width="50" height="50" class="mr-3" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)"></div>`
        }

        if (project.isNew) {
            contents += ``
        } else {
            contents += `<div>${project.text}</div>`
        }
    }
    contents += `</div>`

    return $(contents);
}

$('#direktorat').change(function(){
    if ($(this).val() !== null) {
        cekDivisi();
    }
});

$('#project').change(function () {
    cekProject($(this).val())
})

$('#project').on('select2:select', function (e) {
    if($('#project').hasClass('is-invalid') || $('#project').hasClass('is-valid')){
        if(this.value === ""){
            $("[aria-labelledby='select2-project-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-project-container']").attr("style", "border-color:#38c172;");
        }
    }

})

function cekProject(id) {
    if (!isNaN(id)) {
        let url = `${uri}/getproject/${id}`;
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function()
            {
                $('.senddataloader').show();
            },
            success: function(data){
                $('.senddataloader').hide();
                project = data.data
                const divisi = data.data.divisi
                $("#direktorat").val(divisi.direktorat).trigger('change');
                $("#direktorat").attr("readonly", "readonly");
                $("#divisi").attr("readonly", "readonly");
                $('#is_new').val(0)
                $('#project_nama').val(project.nama)
                /*$("#direktorat").select2(divisi.direktorat);
                $("#divisi").select2(divisi.id, divisi.divisi);*/
            },
            error : function(e){
                $('.senddataloader').hide();
                alert(e);
            }
        });
    } else {
        project = []
        $('#project_nama').val(id)
        // $("#direktorat").val(null).trigger('change');
        // $("#divisi").val(null).trigger('change');
        $("#direktorat").removeAttr('readonly');
        $("#divisi").removeAttr('readonly');

        $('#is_new').val(1)
    }
}

const cekDivisi = (valueOld = null) => {
    if($('#divisi').hasClass('is-invalid') || $('#divisi').hasClass('is-valid')){
        if(this.value == ""){
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-direktorat-container']").attr("style", "border-color:#38c172;");
        }
    }

    var direktorat  = $('select[name=direktorat] option').filter(':selected').val();
    var url = `${uri}/getdivisi/${direktorat}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.pagination').remove();

            $("#divisi option").each(function() {
                $(this).remove();
            });

            $('.senddataloader').show();
        },
        success: function(data){
            var option = "<option value='' selected disabled>Pilih Unit Kerja</option>";
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    if (valueOld !== null) {
                        if (valueOld === data.data[index].id) {
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`;
                        }else{
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        }
                    } else{
                        option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                    }
                }
            }
            $('#divisi').append(option);

            if (project.length !== 0) {
                $('#divisi').val(project.divisi.id).trigger('change')
            }
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

let divisiVal = $('#divisi').val();
if (divisiVal !== "" && divisiVal !== null) {
    divisiVal   =   parseInt(divisiVal);
    cekDivisi(divisiVal);
}

$('#divisi').change(function(){
    if($('#divisi').hasClass('is-invalid') || $('#divisi').hasClass('is-valid')){
        if(this.value == ""){
            $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-divisi-container']").attr("style", "border-color:#38c172;");
        }
    }
});

$('#file_type').change(function(){
    if($('#file_type').hasClass('is-invalid') || $('#file_type').hasClass('is-valid')){
        if(this.value == ""){
            $("[aria-labelledby='select2-file_type-container']").attr("style", "border-color:red;");
        }else{
            $("[aria-labelledby='select2-file_type-container']").attr("style", "border-color:#38c172;");
        }
    }
});

function checkEditor() {
    let valid = true;
    let msgLengthDeskripsi = CKEDITOR.instances['deskripsi'].getData().replace(/<[^>]*>/gi, '').length;

    $("#cke_deskripsi").removeClass('border-none');
    if(msgLengthDeskripsi <= 200){
        $("#cke_deskripsi").attr("style", "border-color:#e3342f");
    }else{
        $("#cke_deskripsi").attr("style", "border-color:#38c172");
    }

    if(msgLengthDeskripsi  ===  0) {
        valid = false
        Toast3.fire({icon: 'error',title: 'Deskripsi tidak boleh kosong!'});
    } else if (msgLengthDeskripsi <= 200) {
        valid = false
        Toast3.fire({icon: 'error',title: 'Deskripsi kurang dari 200 karakter!'});
    }

    return valid;
}

window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (formSubmitting) {
            return undefined;
        }
        let temp_upload = [];
        if ($('#temp').val()) {
            $('input#temp').each(function () {
                temp_upload.push($(this).val())
            })
        }

        if (temp_upload.length > 0) {

            let form_data = new FormData();
            form_data.append('temp', temp_upload.toString());

            $.ajax({
                url: uri+'/deleteonleave',
                data: form_data,
                type: 'post',
                contentType: false,
                processData: false,
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                },
                success: function(){
                    return undefined;
                },
                error: function () {
                    return undefined;
                },
            });
        }

        return undefined;
    });
};

function imgError(image) {
    let r = Math.floor(Math.random() * 9) + 1
    image.onerror = "";
    image.src = `${uri}/assets/img/news/img0${r}.jpg`;
    return true;
}

/*
*/
