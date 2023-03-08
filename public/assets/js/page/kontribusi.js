let BE          = '';
let uri         = '';
let base_url    = '';
let token       = '';
let old_photo   = '';
let old_attach  = [];
let input_attach = [];
let regexForm = /^(?!.*(<script|<iframe|<meta|<link|<style|onload|onclick|onmouseover|onerror|javascript:|eval\(|expression\()).*$/i;

const slug = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1)

//toast
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

// CHECK SELECT2 COMPONENTS
const checkSelect2Component = (previewClicked) => {
    const direktorat = $('#direktorat')
    const divisi = $('#divisi')
    const konsultant = $('#konsultant')
    const restrictedUser = $('#restricted-user')
    const tags = $('#tags')
    const checker = $('#checker')
    const signer = $('#signer')

    // NEXT BUTTON
    if(direktorat.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Direktorat tidak boleh kosong!'})
    }

    if(divisi.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Divisi tidak boleh kosong!'})
    }

    if(konsultant.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Konsultan/Vendor tidak boleh kosong!'})
    }

    if(restrictedUser.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'User yang mendapatkan Hak Akses tidak boleh kosong!'})
    }

    if(tags.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Tags tidak boleh kosong!'})
    }

    // PREVIEW BUTTON
    if(!checker.val() && previewClicked === 1){
        return Toast3.fire({icon: 'error',title: 'Checker tidak boleh kosong!'})
    }

    if(!signer.val() && previewClicked === 1){
        return Toast3.fire({icon: 'error',title: 'Signer tidak boleh kosong!'})
    }
}

// CHECK FILEPOND COMPONENTS
const checkFilepondComponent = (previewClicked) => {
    const photo = $('#photo')
    const attach = $('#attach')
    const oldAttachType = $('.old_attach_type')

    // NEXT BUTTON
    if(photo.hasClass('is-invalid')){
        // return Toast3.fire({icon: 'error',title: 'Thumbnail Project tidak boleh kosong!'})
    }else{
        $("[id='photo']").attr("style", "border-color:#38c172;");
    }

    // PREVIEW BUTTON
    /*const checkFileUploaded = attach[0].innerText.includes('Upload complete')
    let cekFileExisting     = attach[0].querySelectorAll('.filepond--item').length
    console.log(cekFileExisting);
    if(!checkFileUploaded && previewClicked === 1 && cekFileExisting === 0){
        return Toast3.fire({icon: 'error',title: 'Dokumen Project tidak boleh kosong!'})
    }*/
    if (previewClicked === 1) {
        if($('#file').hasClass('is-invalid')){
            $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
            return Toast3.fire({icon: 'error',title: 'Dokumen Project tidak boleh kosong!'})
        }else{
            $("#attach-wrap").attr("style", "border:solid 1px #38c172;");
        }
    }
}

// editing
old_photo   =   $('#old_photo').val();
var urut = 0;
var inputs = document.getElementsByClassName('old_attach'),
    temp  = [].map.call(inputs, function( input ) {

        var size = document.getElementsByClassName('old_attach_size')[urut];
        var type = document.getElementsByClassName('old_attach_type')[urut];

        old_attach.push({
            nama : input.value,
            size : size.value,
            type : type.value,
        });
        urut++;
    });
// console.log(old_attach);

// remove function
function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

// meta url
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

let optionkonsultant = '';
let optionuser = '';
let lesson_learned_urut = $("#urut").val();
let foto;
let attach_file=[];
let photo_file = uri+"/public/assets/img/boxdefault.svg";
var today = new Date();
// base waktu
const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

document.addEventListener('DOMContentLoaded', function() {
    FilePond.registerPlugin(
        FilePondPluginFileEncode,
        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation
    );

    // photo
    const inputfoto  = document.querySelector('input[id="photo"]');
    foto       = FilePond.create( inputfoto,
        {
            allowFileTypeValidation         : true,
            acceptedFileTypes               : ['image/png','image/jpg','image/jpeg'],
            allowImagePreview               : true,
            labelIdle                       : "Pilih Foto",
            imagePreviewHeight              : 170,
            imageCropAspectRatio            : '1:1',
            imageResizeTargetWidth          : 200,
            imageResizeTargetHeight         : 200,
            stylePanelLayout                : 'compact square',
            styleLoadIndicatorPosition      : 'center bottom',
            styleProgressIndicatorPosition  : 'right bottom',
            styleButtonRemoveItemPosition   : 'left bottom',
            styleButtonProcessItemPosition  : 'right bottom',
            fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                resolve(type);
            })
        });

    if (typeof(old_photo) !== 'undefined') {
        foto.files = [
            {
                source: old_photo,
                options: {
                    type: 'local',
                    file: {
                        name: old_photo,
                        size: 3001025,
                        type: 'image/png'
                    },
                }
            }
        ];
    }

    let pondBox = document.querySelector('.filepond--root');
    pondBox.addEventListener('FilePond:processfile', e => {
        photo_file = uri+"/storage/"+foto.getFile().serverId;
        if (photo_file === 'undefined') {
            photo_file = uri+"/public/assets/img/boxdefault.svg";
        }
        // console.log('photo nya : ' +foto.getFiles());
    });

    foto.setOptions({
        name : 'photo',
        allowRemove: true,
        server: {
            url:uri+'/up/photo',
            headers:{
                'X-CSRF-TOKEN' : `${csrf}`,
            }
        }
    });
});


FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
);

function readFile(input) {
    const type_file = ['application/x-zip-compressed', 'zip', 'rar', 'html']
    const name_file = input.files[0].name;
    console.log(type_file.includes(input.files[0].type));
    console.log(type_file.includes(name_file.split('.')[1]));
    console.log(name_file);
    console.log(type_file);
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

const $preview = $('#preview_zone')

// function validate() {
//     let fileName = document.getElementById("file").value;
//     let dot = fileName.lastIndexOf(".") + 1;
//     let extFile = fileName.substr(dot, fileName.length).toLowerCase();
//     if (extFile == "jpg" || extFile == "jpeg") {
//     //accepted
//     showPreview(file);
//     } else {
//     alert("Only jpg and jpeg image files allowed!");
//     }
// }

function showPreview(file) {
    const timemillis = Date.now()
    let htmlPreview = [
        '<div id="prev'+timemillis+'" class="d-flex align-items-center mb-3" style=" width: 50%; height: 40px;">',
        '<div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">',
        '<div class="d-flex align-items-center justify-content-between" style="width: 100%">',
        '<div class="align-items-center text-elip">',
        '<i class="fas fa-file mr-3"></i>',file.name,
        '</div>',
        `<div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Cancel" onclick="removePreview(this, \'cancel\', ${file})">`,
        '<i class="fas fa-circle-notch fa-spin"></i>',
        '</div>',
        '</div>',
        '</div>',
        '<div id="loading" class="d-flex align-items-center" style="width: 20px;">',
        '<p class="m-0 d-flex align-items-center">Uploading&nbsp;<span class="loadings">...</span></p>',
        '</div>',
        '</div>'
    ]

    $preview.append($(htmlPreview.join('')).hide().fadeIn(300))

    let $container = $('#prev'+timemillis+'')

    /*if($('#form').hasClass('was-validated')){
        $("#attach-wrap").attr("style", "border:solid 1px #38c172;");
    }*/

    let form_data = new FormData();
    form_data.append(`attach`, file);

    $.ajax({
        url: uri+`/up/attach`,
        data: form_data,
        type: 'post',
        mimeType: 'multipart/form-data',
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
                removePreview(this, 'delete', file)
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

            attach_file.push({file: file, url: res})
        },
        error: function () {
            Toast3.fire({icon: 'error',title: 'Upload Gagal'});
            removePreview(this, 'cancel', file)
        },
    });
}

function removePreview(id, type, file = null) {
    if (type === 'cancel') {
        $(id).parent().parent().parent().fadeOut(300, function () {
            $(this).remove()
            if ( $preview.children().length === 0 ) {
                $('#file').val('')
            }
            /*if($('#form').hasClass('was-validated')){
                $("#attach-wrap").attr("style", "border:1px solid #e3342f;");
            }*/
        });
    } else {
        let $last = $(id).parent().parent().parent().children().last()
        let form_data = new FormData();
        form_data.append(`attach`, $last.val());
        form_data.append('isNew', slug === 'kontribusi' ? "1" : "0");
        $.ajax({
            url: uri+`/delete/attach`,
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

                        if (slug !== 'kontribusi') {
                            const hidden_del = `<input type="hidden" name="temp_delete[]" value="${response.request.path}">`
                            $('#temp_delete').append(hidden_del)
                        }
                    }
                    let index = attach_file.findIndex(elem => elem.file === file);
                    attach_file.splice(index, 1);
                });
            },
            error: function () {
                Toast3.fire({icon: 'error',title: 'Delete Gagal'});
            },
        });
    }
}

function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}
$('#file').change(function(){
    readFile(this);
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

$(document).ready(function () {
    // let attachment = $('#file').val();
    // console.log(attachment);
    var t = 0;
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        first_page = $('#step-1'),
        allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');

    allWells.hide();
    first_page.show();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            curStepBtn = $($(this).attr('id')),
            $item = $(this);

        if (curStepBtn == 's-1') {
            t = 1;
        }else if (curStepBtn == 's-2') {
            t = 2;
        }else if (curStepBtn == 's-3') {
            t = 3;
        }

        $item.removeClass('disable');
        $item.removeClass('btn-default');
        $item.removeAttr( "style" );

        if (!$item.hasClass('disable')) {
            if (t == 1) {
                jQuery('.s2').addClass('stepwizard-step-oren');
            }else if(t == 2) {
                jQuery('.s3').addClass('stepwizard-step-oren');
            }

            $item.addClass('btn-warning aktiv');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id");
        var pointer = 0;

        if (curStepBtn == 'step-1') {
            pointer = 1;
        }else if (curStepBtn == 'step-2') {
            pointer = 2;
        }

        var nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
        var curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file'],input[type='date'],input[type='email'],select"),
            isValid = true;

        $(".form-control").removeClass("is-invalid");
        $(".thumbnail-input").removeClass("is-invalid");
        $('#form').removeClass('was-validated');
        $('#form').addClass('was-validated');
        let t_nama_project = $('#nama_project').val();
        let t_nama_pm = $('#projectmanager').val();
        let t_lesson_learn = $('.lesson').val();
        let t_lesson_keterangan = $('.lesson_keterangan').val();
        let t_tags = $('#tags').val();
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-control").addClass("is-invalid");
                $(curInputs[i]).closest(".thumbnail-input").addClass("is-invalid");
            }
            else if (regexForm.test(t_nama_project) == false) {
                isValid = false;
                $('#nama_project').removeClass("valid");
                $('#nama_project').addClass("is-invalid");
            }
            else if (regexForm.test(t_nama_pm) == false) {
                isValid = false;
                $('#projectmanager').closest(".form-control").removeClass("valid");
                $('#projectmanager').closest(".thumbnail-input").removeClass("valid");
                $('#projectmanager').closest(".form-control").addClass("is-invalid");
                $('#projectmanager').closest(".thumbnail-input").addClass("is-invalid");
            }
            else if (regexForm.test(t_lesson_learn) == false) {
                isValid = false;
                $('.lesson').removeClass("valid");
                $('.lesson').addClass("is-invalid");
            }
            else if (regexForm.test(t_lesson_keterangan) == false) {
                isValid = false;
                $('.lesson_keterangan').removeClass("valid");
                $('.lesson_keterangan').addClass("is-invalid");
            }
            else if (regexForm.test(t_tags) == false) {
                isValid = false;
                $('#tags').removeClass("valid");
                $('#tags').addClass("is-invalid");
            }

        }
        // var t_nama_project      = $('#nama_project').val();
        // var formNama = document.getElementById('#nama_project');
        // if(/^(?!.*(<script|<iframe|<meta|<link|<style|onload|onclick|onmouseover|onerror|javascript:|eval\(|expression\()).*$/i.test(t_nama_project) == false) {
        //     formNama.closest(".form-control").addClass("is-invalid");
        //     return false;
        // }

        // validasi ui
        var kolomvendor     = $('#jenispekerja').val();
        var kolomrestricted = $('#restricted').val();

        // console.log(t);
        if (t == 0) {
            // foto
            if($('#photo').hasClass('is-invalid')){
                $("[id='photo']").attr("style", "border-color:red;");
            }else{
                $("[id='photo']").attr("style", "border-color:#38c172;");
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

            // jenis pekerja
            if($('#jenispekerja').val() === '1'){
                if($('#konsultant').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:#38c172;");
                }
            }

            // restricted user
            if($('#restricted').val() === '1'){
                var urut;
                if (kolomvendor === '1') {
                    urut = 1;
                }else{
                    urut = 0;
                }
                // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
                if($('#restricted-user').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
                }
            }

        }else if(t == 1){
            // slide 2
            // console.log('masuk');
            var msgLengthDeskripsi = CKEDITOR.instances['editor-deskripsi'].getData().replace(/<[^>]*>/gi, '').length;
            var msgLengthMetodologi = CKEDITOR.instances['editor-metodologi'].getData().replace(/<[^>]*>/gi, '').length;
            // console.log(msgLengthDeskripsi);

            // validasi ui
            if(msgLengthDeskripsi <= 200){
                $("#cke_editor-deskripsi").attr("style", "border-color:red;");
                isValid = false;
            }else{
                $("#cke_editor-deskripsi").attr("style", "border-color:#38c172;");
            }

            if(msgLengthMetodologi <= 10){
                $("#cke_editor-metodologi").attr("style", "border-color:red;");
                isValid = false;
            }else{
                $("#cke_editor-metodologi").attr("style", "border-color:#38c172;");
            }

            // tags
            if (kolomvendor === '1' && kolomrestricted === '1') {
                urut = 2;
            }else if (kolomvendor === '1' || kolomrestricted === '1' ) {
                urut = 1;
            }else{
                urut = 0;
            }
            if($('#tags').hasClass('is-invalid')){
                document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
            }else{
                document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
            }

            // validasi alert
            if(msgLengthDeskripsi  ==  0) {
                Toast3.fire({icon: 'error',title: 'Deskripsi tidak boleh kosong!'});
            } else if (msgLengthDeskripsi <= 200) {
                Toast3.fire({icon: 'error',title: 'Deskripsi kurang dari 200 karakter!'});
            }else if (msgLengthMetodologi ==  0) {
                Toast3.fire({icon: 'error',title: 'Metodologi tidak boleh kosong!'});
            } else if (msgLengthMetodologi <= 10) {
                Toast3.fire({icon: 'error',title: 'Metodologi kurang dari 10 karakter!'});
            }else if($('#tags').hasClass('is-invalid')){
                Toast3.fire({icon: 'error',title: 'Tags tidak boleh kosong!'})
            }

        }else if(t == 2){
            // slide 3
            // checker
            if($('#checker').hasClass('is-invalid')){
                $("[aria-labelledby='select2-checker-container']").attr("style", "border-color:red;");
            }else{
                $("[aria-labelledby='select2-checker-container']").attr("style", "border-color:#38c172;");
            }

            if($('#signer').hasClass('is-invalid')){
                $("[aria-labelledby='select2-signer-container']").attr("style", "border-color:red;");
            }else{
                $("[aria-labelledby='select2-signer-container']").attr("style", "border-color:#38c172;");
            }

            // signer
        }

        if (isValid){
            if (pointer > t) {
                // console.log('masuk');
                t = t+1;
                // console.log(t);
            }
            nextStepWizard.removeAttr('disabled').trigger('click');
        }

        // CALL CHECKER FOR SELECT2 COMPONENTS
        checkSelect2Component()
        checkFilepondComponent()
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],input[type='file']"),
            isValid = true;

        if (isValid){
            t = t-1;
            nextStepWizard.removeAttr('disabled').trigger('click');
        }
    });

    $('div.setup-panel div a.btn-warning').trigger('click');


    $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());
            if(e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if(prev.length) {
                    $(prev).select();
                }
            } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));

                if(next.length) {
                    $(next).select();
                } else {
                    if(parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

    $('#direktorat').select2({
        placeholder : 'Pilih Direktorat'
    });

    $('#tags').select2({
        placeholder : 'Cari Tags',
        tags: true
    });

    $('#checker').select2({
        placeholder : 'Cari Checker Project'
    });

    $('#restricted-user').select2({
        placeholder : 'Cari User'
    });

    $('#signer').select2({
        placeholder : 'Cari Signer Project'
    });

    $('#divisi').select2({
        placeholder : 'Pilih Unit Kerja'
    });
    getKonsultan();
    // getUser();
    // console.log(`${base_url}/searchuser/`);
    $("#checker").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 66
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    $("#restricted-user").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 11
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    $("#signer").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 66
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    $('#preview').click(function(){
        // CHECK SELECT2 COMPONENT
        let isClicked = 1
        const check = !(checkFilepondComponent(isClicked) || checkSelect2Component(isClicked))

        if(check){
            isClicked = 0
            // change name filpond attach
            $("input[name='attach']").attr('name','attach[]');

            // init
            // if (typeof(old_photo) !== 'undefined') {
            //     var t_photo             = uri+"/storage/"+old_photo;
            // }else{
            //     var t_photo             = photo_file;
            // }
            if (photo_file == uri+"/public/assets/img/boxdefault.svg") {
                var t_photo             = uri+"/storage/"+old_photo;
            }else{
                var t_photo             = photo_file;
            }
            var t_direktorat        = $('#direktorat').val();
            var t_divisi            = $('#divisi :selected').map((_, e) => e.getAttribute("data-value")).get();
            var t_nama_project      = $('#nama_project').val();
            // var formNama = document.getElementById('#nama_project');
            // if(/^(?!.*(<script|<iframe|<meta|<link|<style|onload|onclick|onmouseover|onerror|javascript:|eval\(|expression\()).*$/i.test(t_nama_project) == false) {
            //     formNama.closest(".form-control").addClass("is-invalid");
            //     return false;
            // }

            // waktu mulai
            var temp_date           = new Date($('#tgl_mulai').val());
            var t_tgl_mulai         = temp_date.getDate()+" "+ months[temp_date.getMonth()]+" "+temp_date.getFullYear();
            // console.log("Date inputan user: "+$('#tgl_mulai').val());
            // console.log("temp_date: "+temp_date);
            // console.log("t_tgl_mulai: "+t_tgl_mulai);
            // console.log(temp_date.getUTCHours()); // Hours
            // console.log(temp_date.getUTCMinutes());
            // console.log(temp_date.getUTCSeconds());

            var t_stat_project;
            var t_tgl_selesai;
            if ($('#stat_project').prop('checked')) {
                // waktu
                var temp_date           = new Date($('#tgl_selesai').val());
                var t_tgl_selesai         = temp_date.getDate()+" "+ months[temp_date.getMonth()]+" "+temp_date.getFullYear();

                t_stat_project      = 'Selesai';
            }else{
                t_tgl_selesai = '-';
                t_stat_project      = 'On Progress';
            }
            var t_projectmanager    = $('#projectmanager').val();
            var t_email             = $('#email').val();
            var t_jenispekerja      = $('#jenispekerja').val();
            var vendor;
            if (t_jenispekerja == 1) {
                // vendor = $('#konsultant').find(":selected").attr("data-value");
                vendor = $("#konsultant :selected").map((_, e) => e.getAttribute("data-value")).get();
            }else{
                vendor = '-';
            }
            var t_user = $('#user').val();
            var t_deskripsi = CKEDITOR.instances['editor-deskripsi'].getData();
            var t_metodologi = CKEDITOR.instances['editor-metodologi'].getData();
            var t_tags = $('#tags').val();
            var t_lesson = $('.lesson').map((_, e) => e.value).get();
            var t_tahap = $('.tahap').map((_, e) => e.value).get();
            var t_lesson_keterangan = $('.lesson_keterangan').map((_, e) => e.value).get();
            var t_checker = $('#checker').val();
            var t_signer = $('#signer').val();
            var t_attach = []
            t_attach.push(...attach_file)

            let inputAttach = $('input[name^=attach]').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            if (slug !== 'kontribusi') {
                let length = input_attach.length;
                for (let i=length-1; i>=0; i--) {
                    if (inputAttach.includes(input_attach[i].name)) {
                        if (!t_attach.includes(input_attach[i])) {
                            t_attach.unshift(input_attach[i])
                        }
                    }
                }
            }
            // var t_attach = attach_file;

            console.log(t_attach);
            // empty
            $('#prev_namaproject').empty();
            $('#prev_pm').empty();

            // konsultant
            $('#prev_konsultant').empty();
            var tampung_vendor = "";
            if (t_jenispekerja == 1) {
                if (typeof vendor !== 'undefined') {
                    if (vendor.length > 1) {
                        for (let index = 0; index < vendor.length; index++) {
                            if (index == vendor.length - 1) {
                                tampung_vendor += `<span class='fs-10'>${vendor[index]}</span>`;
                            }else{
                                tampung_vendor += `<span class='fs-10'>${vendor[index]}</span>`+", ";
                            }
                        }
                    }else{
                        tampung_vendor = `<span class='fs-10'>${vendor}</span>`;
                    }
                }else{
                    tampung_vendor = vendor;
                }
            }else{
                tampung_vendor = vendor;
            }
            $('#prev_emailpm').empty();
            $('#prev_divisi').empty();
            $('#prev_tglmulai').empty();
            $('#prev_tglselesai').empty();
            $('#prev_status').empty();
            $('#prev_keyword').empty();
            var tampung_tags = "";
            if (t_tags.length > 1) {
                for (let index = 0; index < t_tags.length; index++) {
                    tampung_tags += `<span class="badge badge-cyan-light text-dark mr-1 mb-2">${t_tags[index]}</span>`;
                }
            }else{
                tampung_tags = `<span class="badge badge-cyan-light text-dark mr-1 mb-2">${t_tags}</span>`;
            }
            $('#prev_deskripsi').empty();
            $('#prev_metodologi').empty();
            $('#prev_lessonlearned').empty();
            var tampung_lesson = "";
            if (typeof t_lesson !== 'undefined') {
                if (t_lesson.length > 1) {
                    var urutin=1;
                    for (let index = 0; index < t_lesson.length; index++) {
                        if (t_lesson[index] === "" && t_lesson_keterangan[index] === "") {
                        }else{
                            tampung_lesson += `<tr>
                                                    <td id="td-metodologi" style="text-align:center !important;"><span>${urutin++}</span></td>
                                                    <td id="td-metodologi"><span>${t_lesson[index]}</span></td>
                                                    <td id="td-metodologi"><span>${t_tahap[index]}</span></td>
                                                    <td id="td-metodologi"><span>${t_lesson_keterangan[index]}</span></td>
                                                </tr>`;
                        }
                    }
                }else{
                    tampung_lesson = `<tr>
                                            <td id="td-metodologi"><span>1</span></td>
                                            <td id="td-metodologi"><span>${t_lesson}</span></td>
                                            <td id="td-metodologi"><span>${t_tahap}</span></td>
                                            <td id="td-metodologi"><span>${t_lesson_keterangan}</span></td>
                                        </tr>`;
                }
            }else{
                tampung_lesson += `<tr>
                                        <td id="td-metodologi"><span>-</span></td>
                                        <td id="td-metodologi"><span>-</span></td>
                                        <td id="td-metodologi"><span>-</span></td>
                                        <td id="td-metodologi"><span>-</span></td>
                                    </tr>`;
            }

            $('#prev_document').empty();
            var tampung_attach = "";

            if (typeof t_attach !== []) {
                var urutin=0;
                for (let index = 0; index < t_attach.length; index++) {
                    tampung_attach += `<tr>
                                            <td id="td-attachment" class="pl-2"><small>${t_attach[index].file instanceof File ? t_attach[index].file.name : t_attach[index].name}</small></td>
                                            <td id="td-attachment" class="pl-1"><small>${t_attach[index].file instanceof File ? t_attach[index].file.type : t_attach[index].type}</small></td>
                                            <td id="td-attachment" class="pl-1"><small>${t_attach[index].file instanceof File ? bytesToSize(t_attach[index].file.size) : bytesToSize(t_attach[index].size)}</small></td>
                                        </tr>`;
                }
            }else{
                tampung_attach += `<tr>
                                        <td id="td-attachment" class="pl-2"><small>-</small></td>
                                        <td id="td-attachment" class="pl-1"><small>-</small></td>
                                        <td id="td-attachment" class="pl-1"><small>-</small></td>
                                    </tr>`;
            }

            $('#prev_namaproject').append(`${t_nama_project}`);
            $('#prev_thumbnail').attr('src',`${t_photo}`);
            $('#prev_konsultant').append(`${tampung_vendor}`);
            $('#prev_pm').append(t_projectmanager);
            $('#prev_emailpm').append(`<i class="far fa-envelope mr-1"></i><a href="mailto:${t_email}">${t_email}</a>`);
            $('#prev_divisi').append(`${t_divisi}`);
            $('#prev_tglmulai').append(`${t_tgl_mulai}`);
            $('#prev_tglselesai').append(`${t_tgl_selesai}`);
            $('#prev_status').append(`${t_stat_project}`);
            $('#prev_keyword').append(`${tampung_tags}`);
            $('#prev_deskripsi').append(`${t_deskripsi}`);
            $('#prev_metodologi').append(`${t_metodologi}`);
            $('#prev_lessonlearned').append(`${tampung_lesson}`);
            $('#prev_document').append(`${tampung_attach}`);
            $('#modalpreview').modal({
                show : true
            });
        }
    });

    if (slug !== 'kontribusi') {
        const url = `${uri}/kontribusi/doc/${slug}`
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function(res){
                const data = res.data
                for (let x = 0; x<data.length; x++) {
                    const array = {name: data[x].nama, type: data[x].jenis_file, size: data[x].size, url: data[x].url_file}
                    input_attach.push(array)
                }
            },
            error : function(e){
                console.error(e);
            }
        });
    }
});

const getKonsultan = () => {
    var url = `${uri}/getconsultant`;
    $.ajax({
        url: url,
        type: "get",
        success: function(data){
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    optionkonsultant += `<option value='${data.data[index].id}' data-value='${data.data[index].nama}'>${data.data[index].nama}</option>`;
                }
            }
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

const getUser = () => {
    var url = `${uri}/getuser`;
    $.ajax({
        url: url,
        type: "get",
        success: function(data){
            $('.senddataloader').hide();
            // innert html
            if (data.data.length > 0) {
                for (let index = 0; index < data.data.length; index++) {
                    optionuser += `<option value='${data.data[index].id}' data-value='${data.data[index].name}'>${data.data[index].name}</option>`;
                }
            }
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

$('#jenispekerja').change(function(){
    var sample = $('select[name=jenispekerja] option').filter(':selected').val();
    if (sample == 0) {
        $('.content-worker').remove();
    }else if(sample == 1){
        var content = ` <div class="form-group row content-worker">
                            <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Pilih Konsultan/Vendor<span class='text-danger'>*</span></label>
                            <div class="col-md-10 col-sm-12">
                                <select class="select2 form-control" id="konsultant" name="konsultant[]" multiple required>
                                    ${optionkonsultant}
                                </select>
                            </div>
                        </div>`;
        $('#worker').append(content);
        $('#konsultant').on('select2:select', function (e) {
            if($('#konsultant').hasClass('is-invalid') || $('#konsultant').hasClass('is-valid')){
                if(this.value == ""){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:red;");
                }else{
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:#38c172;");
                }
            }
        });
    }

    // set select2
    $('#konsultant').select2({
        placeholder : 'Pilih Konsultan/Vendor',
        tags: true
    });
});

if ($('#konsultant').hasClass('select2')) {
    // set select2
    $('#konsultant').select2({
        placeholder : 'Pilih Konsultan/Vendor',
        tags: true
    });
}

$('#restricted-old').change(function(){
    var sample = $('select[name=restricted] option').filter(':selected').val();

    if (sample == 0) {
        $('.content-restricted').remove();
    }else if(sample == 1){
        var content =   `
                        <div class="form-group w-100 d-flex justify-content-start content-restricted">
                            <div>
                                <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                            </div>
                        </div>
                        <div class="form-group row content-restricted">
                            <div class="col-md-12 col-sm-12">
                                <select class="select2 form-control" id="user" name="user[]" multiple required>
                                    ${optionuser}
                                </select>
                            </div>
                        </div>
                        `;
        $('#restricted_content').append(content);
    }

    // set select2
    $('#user').select2({
        placeholder : 'Pilih User'
    });
});

$('#restricted').change(function(){
    var sample = $('select[name=restricted] option').filter(':selected').val();

    if (sample == 0) {
        $('.content-restricted').remove();
    }else if(sample == 1){
        var content =   `
                        <div class="form-group w-100 d-flex justify-content-start content-restricted">
                            <div>
                                <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                            </div>
                        </div>
                        <div class="form-group row content-restricted">
                            <div class="col-md-12 col-sm-12">
                                <select name="user[]" id="restricted-user" class="restricted-user select2 form-control" placeholder='Masukan Personal Number'  multiple required></select>
                            </div>
                        </div>
                        `;

        $('#restricted_content').append(content);
        $('#restricted-user').on('select2:select', function (e) {
            if($('#restricted-user').hasClass('is-invalid') || $('#restricted-user').hasClass('is-valid')){
                var kolomvendor = $('#jenispekerja').val();
                var urut;
                if (kolomvendor === '1') {
                    urut = 1;
                }else{
                    urut = 0;
                }
                // console.log(document.getElementsByClassName("select2-selection select2-selection--multiple"));
                if($('#restricted-user').hasClass('is-invalid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
                }else if($('#restricted-user').hasClass('is-valid')){
                    document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
                }
            }
        });
    }

    // set select2
    $('#restricted-user').select2({
        placeholder : 'Cari User'
    });

    $("#restricted-user").select2({
        minimumInputLength: 8,
        maximumInputLength: 8,
        placeholder: 'Masukan Personal Number',
        ajax: {
            url: `${base_url}/searchuser`,
            type: "get",
            headers: {'X-CSRF-TOKEN': csrf},
            data: function (params) {
                var query = {
                    pn: params.term,
                    mode: 11
                }
                // Query parameters will be ?pn=[term]
                return query;
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });
});


$('#stat_project').change(function(){
    if ($('#stat_project').prop('checked')) {
        var element = `
                        <div class="form-group row content-selesai">
                            <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                            <div class="col-md-5 col-sm-12 content-selesai">
                                <input type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" placeholder="Tanggal selesai" required>
                            </div>
                        </div>
                    `;
        $('#form_tgl_selesai').append(element);
    } else {
        $('.content-selesai').remove();
    }
});

$('#photo').change(function(){
    if($('#photo').hasClass('is-invalid') || $('#photo').hasClass('is-valid')){
        if(this.value == ""){
            $("#photo").attr("style", "border-color:red;");
        }else{
            $("#photo").attr("style", "border-color:#38c172;");
        }
    }
});

$('#direktorat').change(function(){
    cekDivisi();
});

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
                        if (valueOld == data.data[index].id) {
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}' selected>${data.data[index].divisi}</option>`;
                        }else{
                            option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                        }
                    }else{
                        option += `<option value='${data.data[index].id}' data-value='${data.data[index].divisi}'>${data.data[index].divisi}</option>`;
                    }
                }
            }
            $('#divisi').append(option);
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

$('#url').val(localStorage.getItem('url'))
// let urlSave = document.getElementById('url').value;
// urlSave = "ABC";

var divisiVal = document.getElementById('divisi').getAttribute('value');
if (divisiVal != "") {
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

$('#konsultant').on('select2:select', function (e) {
    if($('#konsultant').hasClass('is-invalid') || $('#konsultant').hasClass('is-valid')){
        if(this.value == ""){
            document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:red;");
        }else{
            document.getElementsByClassName("select2-selection select2-selection--multiple")[0].setAttribute("style", "border-color:#38c172;");
        }
    }
});

$('#restricted-user').on('select2:select', function (e) {
    if($('#restricted-user').hasClass('is-invalid') || $('#restricted-user').hasClass('is-valid')){
        var kolomvendor = $('#jenispekerja').val();
        var urut;
        if (kolomvendor === '1') {
            urut = 1;
        }else{
            urut = 0;
        }
        if($('#restricted-user').hasClass('is-invalid')){
            document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:red;");
        }else if($('#restricted-user').hasClass('is-valid')){
            document.getElementsByClassName("select2-selection select2-selection--multiple")[urut].setAttribute("style", "border-color:#38c172;");
        }
    }
});

$('#add_lesson').click(function(){
    lesson_learned_urut++;
    let element = ` <tr class='ll_field'>
                <td class="bg-white attr_input" style="vertical-align: text-top"><span class='control_ll'> </span></td>
                <td><textarea class="w-100 lesson_field lesson" name="lesson[]" placeholder="..." required></textarea></td>
                <td style="vertical-align: text-top">
                                                <select name="tahap[]" class="w-100 lesson_field tahap"
                                                        required value="">
                                                    <option value="Plan" {{'Plan' == 'Plan' ? 'selected' : ''}}>Plan</option>
                                                    <option value="Pilot Run" {{'Pilot Run' == 'Pilot Run' ? 'selected' : ''}}>Pilot Run</option>
                                                    <option value="Procurement" {{'Procurement' == 'Procurement' ? 'selected' : ''}}>Procurement</option>
                                                    <option value="Development" {{'Development' == 'Development' ? 'selected' : ''}}>Development</option>
                                                    <option value="Implementation" {{'Implementation' == 'Implementation' ? 'selected' : ''}}>Implementation</option>
                                                </select>
                                            </td>
                <td><textarea class="w-100 lesson_field lesson_keterangan" name="lesson_keterangan[]" placeholder="..." required></textarea></td>
                <td><img class='ll_min' src='${uri}/assets/img/datatables/ic_trash.png'/></td>
            </tr>`;
    $('.content_lesson').append(element);
    urutFields();
    if ($('.ll_field').length <= 1) {
        $('.ll_min').attr("class","ll_min ll_min_disabled");
    }else{
        $('.ll_min').attr("class","ll_min");
    }
    $(".ll_min").unbind();
    $(".ll_min").click(function(){
        var urutannya   =    $('.ll_min').index(this);
        removeFieldls(urutannya);
    });
});

$("#save").click(function(){
    try {
        let cek_edit = document.getElementById('id').value;
        if (typeof(cek_edit) == 'undefined') {
            $("#project").val('0');
            $('#form').submit();
            $('.senddataloader').show();
        }else{
            $('#form').attr('action',uri+"/kontribusi/update");
            // console.log(uri+"/kontribusi/update");

            $("#project").val('0');
            $('#form').submit();
            $('.senddataloader').show();
        }
    } catch (error) {
        $("#project").val('0');
        $('#form').submit();
        $('.senddataloader').show();
    }
});

$("#send").click(function(){
    v = $("#send").val();
    if (v == 1) { //SEND
        pesan = "Anda yakin akan mengirim Proyek ini?";
        btn_txt = "SEND";
    } else if (v == 2) { //PUBLISH
        pesan = "Anda yakin akan menerbitkan Proyek ini?";
        btn_txt = "PUBLISH";
    } else if (v == 3) { //SEND & APPROVE
        pesan = "Anda yakin ingin menyimpan dan menyetujui Proyek ini?";
        btn_txt = "SAVE & APPROVE";
        // pesan = "Anda yakin akan mengirim dan menyetujui Proyek ini?"; //versi detail
    }
    swal.fire({ title: pesan, text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: btn_txt, cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            try {
                let cek_edit = document.getElementById('id').value;
                if (typeof(cek_edit) == 'undefined') {
                    $("#project").val('1');
                    $('#form').submit();
                    $('.senddataloader').show();
                }else{
                    $('.senddataloader').show();
                    $('#form').attr('action',uri+"/kontribusi/update");
                    // console.log(uri+"/kontribusi/update");

                    $("#project").val('1');
                    $('#form').submit();
                }
            } catch (error) {
                $('.senddataloader').hide();
                $("#project").val('1');
                $('#form').submit();
            }
        }
    });
});

$(".ll_min").click(function(){
    var urutannya   =    $('.ll_min').index(this);
    removeFieldls(urutannya);
});

$('#stat_project').change(function () {
    if ($('#stat_project').is(':checked')) {
        $('#tgl_selesai').change(function () {
            let res = false;
            if($('#tgl_mulai').val() !== '' && $('#tgl_selesai').val() !== ''){
                if($('#tgl_selesai').val() < $('#tgl_mulai').val()){
                    Toast3.fire({icon: 'error',title: 'Tanggal Selesai tidak boleh kurang dari Tanggal Mulai'});
                    res = true;
                }
            }

            if(res){
                $('#tgl_selesai').val('');
            }
        });
    }
});

$('#tgl_mulai').change(function () {
    let res = false;
    if($('#tgl_mulai').val() !== '' && $('#tgl_selesai').val() !== ''){
        if($('#tgl_mulai').val() > $('#tgl_selesai').val()){
            Toast3.fire({icon: 'error',title: 'Tanggal Mulai Tidak Boleh Lebih Dari Tanggal Selesai'});
            res = true;
        }
    }
    if(res){
        $('#tgl_mulai').val('');
    }
});

const removeFieldls = (urutan) => {
    if ($('.ll_field').length > 1) {
        if (confirm('Apakah Anda Yakin Menghapusnya ?')) {
            $('.ll_field')[urutan].remove();
            urutFields();

            if ($('.ll_field').length <= 1) {
                $('.ll_min').attr("class","ll_min ll_min_disabled");
            }else{
                $('.ll_min').attr("class","ll_min");
            }
        }
    }
}

const urutFields = () => {
    var urut_temp  = $('.ll_field').length + 1;
    var u          = 1;
    $('.control_ll').empty();
    for (let index = 0; index < urut_temp; index++) {
        $('.control_ll').eq(index).html(`${u}`);
        u++;
    }
    $(".ll_min").click(function(){
        var urutannya   =    $('.ll_min').index(this);
        removeFieldls(urutannya);
    });
}
