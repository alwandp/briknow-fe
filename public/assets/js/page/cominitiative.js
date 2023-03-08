let $table = $('#table')
let selections = [];
let uri;
let page = '1';
let key = '';
let csrf = '';
let be      = '';
let id_projects = '';

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

const type = [
    {'id': 'article', 'name': 'Articles'},
    {"id": "logo", "name": "Icon, Logo, Maskot BRIVO"},
    {"id": "infographics", "name": "Infographics"},
    {"id": "transformation", "name": "Transformation Journey"},
    {"id": "podcast", "name": "Podcast"},
    {"id": "video", "name": "Video Content"},
    {"id": "instagram", "name": "Instagram Content"}
]

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

const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "BE") {
        be = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function imgError(image) {
    let r = Math.floor(Math.random() * 9) + 1
    image.onerror = "";
    image.src = `${uri}/assets/img/news/img0${r}.jpg`;
    return true;
}

function hapus(a){
    const url = `${uri}/communicationinitiative/delete/${a}`
    let t = "{{$token_auth}}";
    swal.fire({ title: "Anda yakin akan menghapus Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            $.ajax({
                url: url,
                type: "DELETE",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                    $('.senddataloader').show();
                },
                success: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'success',title: 'Berhasil dihapus'}); //PERLU DIGANTI BAHASANYA

                    location.reload();
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: 'Gagal dihapus'}); //PERLU DIGANTI BAHASANYA
                },
            })
        }
    });
}

function edit(e) {
    window.location.href = uri+`/managecommunication/upload/content/${e}`;    
}

function download(id) {
    window.location.href = uri+`/attach/download/content/${id}`;
}

$('#modal-preview-1').on('hide.bs.modal', function(){
    $('#content-preview-desc').empty();
});

function view(row, index) {

    let attach = row.attach_file;

    const url = `${uri}/communication/views/content/${row}`
    let t = "{{$token_auth}}";

    $.ajax({
        url: url,
        data: {data: attach},
        type: 'post',
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
            $('#content-preview-desc').empty();
        },
        success: function (data) {
            $('.senddataloader').hide();

            let view = data.data.views
            $table.bootstrapTable('updateRow', {
                index: index,
                row: {
                    views: view
                }
            })
            $('#content-preview-desc').append(data.html);
            $('#coloumnrow').append(data.col);

            $('#modal-preview-1').modal({
                show : true
            });
        },
        error: function () {
            $('.senddataloader').hide();
            Toast2.fire({icon: 'error',title: 'Gagal'});
        },
    })
}

function dateFormat(date) {
    return date.getDate()+" "+ months[date.getMonth()]+" "+date.getFullYear();
}

function setStatus(value, row, valueOld, index) {
    const url = `${uri}/communicationinitiative/status/${value}/${row}`
    let $select = $('#selectStatus'+row)
    let t = "{{$token_auth}}";
    let title = "";
    switch (value) {
        case 'approve':
            title = "Anda yakin ingin approve Proyek ini?"
            break
        case 'publish':
            title = "Anda yakin ingin menerbitkan Proyek ini?"
            break
        case 'reject':
            title = "Anda yakin ingin Reject Proyek ini?"
            break
        case 'unpublish':
            title = "Anda yakin ingin membatalkan publikasi Proyek ini?"
            break
        default:
            title = ""
            break
    }
    swal.fire({ title: title, text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
        if(i.isConfirmed){
            $.ajax({
                url: url,
                type: "post",
                data: { _method: "POST"},
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                    $('.senddataloader').show();
                },
                success: function (data) {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'success',title: data.data.toast});
                    location.reload();
                },
                error: function (error) {
                    const resError = JSON.parse(error.responseText);
                    $('.senddataloader').hide();
                    $select.val(valueOld)
                    Swal.fire({ icon: "error", title: "Oops...", text: resError.data.toast });
                },
            })
        } else {
            $select.val(valueOld)
        }
    });
}

function searchContent() {
    key = document.getElementById('inlineFormInputGroup').value;
    getData(key);
}

getData(key)
function getData(key) {
    const types = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
    const url = `${getCookie('url_be')}api/communicationinitiative/${types}?page=1&search=${key}`;
    console.log(url);
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data) {
            $('.senddataloader').hide();
            $("#content-table-body").empty();
            if (data.data.data !== undefined && data.data.data.total !== 0) {
                console.log(data.data.data);
                for (let i = 0; i < data.data.data.total; i++) {
                    let title = data.data.data[i].title;
                    $('#content-table-body').append(`
                        <tr height="100px">
                            <td>${titleFormatter(title, data.data.data[i])}</td>
                            <td class="text-center">
                                <div class="text-center">,
                                    <i class="fas fa-eye mr-2"></i>
                                    ${data.data.data[i].views}
                                </div>
                            </td>
                            <td class="text-center">${data.data.data[i].tanggal_upload}</td>
                            <td class="text-center">${statusFormatter(data.data.data[i].status, data.data.data[i], i)}</td>
                            <td class="text-center">${operateFormatter(data.data.data[i].id, data.data.data[i], i)}</td>
                        </tr>
                    `);
                }
            }
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

// function ajaxRequest(params) {
//     const types = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
//     const url = `${getCookie('url_be')}api/communicationinitiative/${types}`;
//     console.log(url);
//     $.ajax({
//         url: url + '?' + $.param(params.data),
//         type: "get",
//         beforeSend: function(xhr){
//             xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
//             $('.senddataloader').show();
//         },
//         success: function(data){
//             let pagination_height = data.totalRow === data.total ? 0 : 54
//             const height = data.totalRow === 0 ? 105 : 51 + (data.totalRow * 108) + pagination_height
//             $table.bootstrapTable( 'resetView' , {height: height} );
//             $('.senddataloader').hide();
//             params.success(data)
//         },
//         error : function(e){
//             $('.senddataloader').hide();
//             alert(e);
//         }
//     });
// }

function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
        return row.id
    })
}

function responseHandler(res) {
    $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.id, selections) !== -1
    })
    return res
}

function operateFormatter(value, row, index) {
    return [
        '<div class="d-flex pr-4 align-items-center justify-content-center" style="padding-top: 0; padding-bottom: 0">',
        `<div class="view border-action d-flex align-items-center justify-content-center mr-1 action-icon" title="View" onclick="view(${row.id}, ${index})">`,
        '<i class="fas fa-eye" style="margin: 0; font-size: 18px"></i>',
        '</div>  ',
        `<div class="edit border-action d-flex align-items-center justify-content-center mr-1 action-icon" onclick="edit('${row.slug}')" title="Edit">`,
        '<i class="fas fa-pencil-alt" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        `<div class="remove border-action d-flex align-items-center justify-content-center mr-1 action-icon" onclick="hapus('${value}')" title="Remove">`,
        '<i class="fas fa-trash" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        `<div class="download border-action d-flex align-items-center justify-content-center action-icon" onclick="download(${row.id})" title="Download">`,
        '<i class="fas fa-download" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        '</div>'
    ].join('')
}

window.operateEvents = {
    'click .view': function (e, value, row, index) {
        view(row, index)
    },
    'click .edit': function (e, value, row, index) {
        edit(row.slug)
    },
    'click .remove': function (e, value, row, index) {
        hapus(value)
    },
    'click .download': function (e, value, row, index) {
        download(row.id);
    },
}

function statusFormatter (value, row, index) {
    const options1 = ['Approve', 'Reject'];
    const options2 = ['Approve'];
    const options3 = ['Publish', 'Unpublish'];
    const options4 = ['Publish'];
    const options5 = ['Unpublish'];
    let selected = '';
    let options;
    if (value === 'review') {
        options = options1
        selected = 'Review'
    } else if (value === 'reject') {
        options = options2
        selected = 'Rejected'
    } else if (value === 'approve') {
        options = options3
        selected = 'Approved'
    } else if (value === 'publish') {
        options = options5
        selected = 'Published'
    } else {
        options = options4
        selected = 'Unpublished'
    }
    let $select = [`<select id="selectStatus'${row.id}'" class="select-custom" onchange="setStatus(value,'${row.id}','${value}','${index}')">`];
    $select.push(`<option value="${value}" selected>${selected}</option>`)
    for (let val in options) {
        $select.push(`<option value="${options[val].toLocaleLowerCase()}">${options[val]}</option>`);
    }
    $select.push('</select>')
    return $select.join('');
}

function dateFormater(date) {
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [day, month, year].join('/');
}

function viewsFormatter(views) {
    return [
        '<div class="pl-2">',
        '<i class="fas fa-eye mr-2"></i>',
        views,
        '</div>',
    ].join('')
}

function titleFormatter(value, row, index) {
    let src = `${uri}/storage/${row.thumbnail}`
    let content = `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" class="mr-3 img-thumb" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <div style="width: 72%" class="ellipsis-2">
                ${value}
            </div>
        </div>`

    if (row.project_id) {
        content = `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" class="mr-3 img-thumb" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <a href="${uri}/project/${row.project.slug}" style="width: fit-content; text-align: left" class="ellipsis-2 link-format-table font-weight-bold">
                ${value}
            </a>
        </div>`
    }
    return content
}

function divisiFormatter(value) {
    try {
        if (!value) {
            return `<div class="ellipsis-2 link-format-table">General</div>`
        }
        return `<div class="ellipsis-2 link-format-table">${value}</div>`
    } catch (e) {
        return `<div class="ellipsis-2 link-format-table">General</div>`
    }
}

function toKatalog(short) {
    localStorage.removeItem("fil_div");
    localStorage.setItem("fil_div",short);
}

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        height: 660,
        locale: 'id-ID',
        paginationParts: 'pageList',
        classes: 'table',
        columns: [
            [{
                field: 'title',
                title: 'Judul',
                // align: 'center',
                cellStyle: {
                    classes: 'font-weight-bold',
                    css: {
                        padding: '0.7rem 0!important'
                    }
                },
                formatter: titleFormatter,
                width: 275
            },
                {
                    field: 'project.divisi.direktorat',
                    title: 'Direktorat',
                    align: 'center',
                    formatter: divisiFormatter,
                    width: 170
                },
                {
                    field: 'project.divisi.divisi',
                    title: 'Divisi',
                    align: 'center',
                    formatter: divisiFormatter,
                    width: 170
                },
                {
                    field: 'views',
                    title: 'Views',
                    align: 'center',
                    formatter: viewsFormatter,
                    width: 85
                },
                {
                    field: 'tanggal_upload',
                    title: 'Tanggal',
                    sortable: true,
                    align: 'center',
                    formatter: dateFormater,
                    cellStyle: {
                        classes: 'font-weight-bold',
                    },
                    width: 100
                },
                {
                    field: 'status',
                    title: 'Status',
                    align: 'center',
                    formatter: statusFormatter,
                    width: 210
                },
                {
                    field: 'id',
                    title: 'Action',
                    align: 'center',
                    /*cellStyle: {
                        classes: 'd-flex align-items-center justify-content-center',
                    },*/
                    clickToSelect: false,
                    events: window.operateEvents,
                    formatter: operateFormatter
                }]
        ]
    })
}

$(function() {
    initTable()
})
