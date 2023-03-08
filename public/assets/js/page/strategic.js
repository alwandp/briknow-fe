let $table = $('#table')
let selections = [];
let uri;
let key = '';
let csrf = '';
let be      = '';

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

function ajaxRequest(params) {
    const url = `${uri}/get/strategicinitiative`

    $.ajax({
        url: url + '?' + $.param(params.data),
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
        },
        success: function(data){
            let pagination_height = data.totalRow === data.total ? 0 : 54
            const height = data.totalRow === 0 ? 105 : 51 + (data.totalRow * 108) + pagination_height
            $table.bootstrapTable( 'resetView' , {height: height} );
            $('.senddataloader').hide();
            params.success(data)
        },
        error : function(e){
            $('.senddataloader').hide();
            alert(e);
        }
    });
}

function searchProject() {
    key = document.getElementById('inlineFormInputGroup').value;
    getData(key);
}

getData(key)
function getData(key) {
    const url = `${getCookie('url_be')}api/strategicinitiative?page=1&search=${key}`
    console.log(url);

    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#content-table-body").empty();
            if (data.data.data !== undefined && data.data.data.total !== 0) {
                console.log(data.data.data);
                for (let i = 0; i < data.data.data.total; i++) {
                    let row = data.data.data[i];
                    let title = data.data.data[i].nama;
                    $('#content-table-body').append(`
                        <tr height="100px">
                            <td>${titleFormatter(title, data.data.data[i])}</td>
                            <td class="text-center">
                                <div class="text-center">,
                                    <i class="fas fa-eye mr-2"></i>
                                    ${viewsFormatter(row)}
                                </div>
                            </td>
                            <td class="text-center">${dateFormater(row.tanggal_mulai)}</td>
                            <td class="text-center">${statusFormatter(row.flag_mcs)}</td>
                            <td class="text-center">${operateFormatter(row)}</td>
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

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        height: 660,
        locale: 'id-ID',
        paginationParts: 'pageList',
        classes: 'table table-hover',
        columns: [
            [
                {
                    field: 'nama',
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
                    field: 'divisi.direktorat',
                    title: 'Direktorat',
                    align: 'center',
                    formatter: divisiFormatter,
                    width: 170
                },
                {
                    field: 'divisi.divisi',
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
                    field: 'created_at',
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
                    field: 'flag_mcs',
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

    $table.on('click-row.bs.table', function (e, name, args) {
        window.location.href = uri+`/managecommunication/strategicinitiative/project/${name.slug}`;
    })
}

$(function() {
    initTable()
})

function imgError(image) {
    let r = Math.floor(Math.random() * 9) + 1
    image.onerror = "";
    image.src = `${uri}/assets/img/news/img0${r}.jpg`;
    return true;
}

function titleFormatter(value, row, index) {
    let src = `${uri}/storage/${row.thumbnail}`
    return `
        <div class="pl-4 d-flex align-items-center" style="padding-top: 0; padding-bottom: 0">
            <img src="${src}" alt="${value}" onerror="imgError(this)" class="mr-3 img-thumb" style="border-radius: 8px;box-shadow: 0 0 1px 1px rgb(172 181 194 / 56%)">
            <a href="${uri}/project/${row.slug}" style="width: fit-content; text-align: left" class="ellipsis-2 link-format-table font-weight-bold">
                ${value}
            </a>
        </div>`
}

function viewsFormatter(row) {
    let view = 0
    const com = row.communication_support
    for (let i=0; i<com.length; i++) {
        view += com[i].views
    }
    return [
        view
    ].join('')
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

function statusFormatter (value) {

    let status_title = ''
    if (value === 3) {
        status_title = 'Pending Review'
    } else if (value === 4) {
        status_title = 'Reviewed'
    } else if (value === 5) {
        status_title = 'Published'
    } else if (value === 6) {
        status_title = 'Unpublished'
    } else if (value === 7) {
        status_title = 'Rejected'
    } else {
        status_title = value
    }
    return `<div class="d-flex align-items-center justify-content-center" style="padding: 0.1rem;margin-left:auto;margin-right: auto;font-size: 14px;border-radius: 6px;width: 150px; border: 1px solid #cccccc">${status_title}</div>`;
}

function operateFormatter(row) {
    return [
        '<div class="d-flex align-items-center justify-content-center" style="padding-top: 0; padding-bottom: 0">',
        `<div class="view border-action d-flex align-items-center justify-content-center mr-1 action-icon" onclick="views('${row.slug}')" title="View">`,
        '<i class="fas fa-eye" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        `<div class="edit border-action d-flex align-items-center justify-content-center mr-1 action-icon" onclick="edit('${row.slug}')" title="Edit">`,
        '<i class="fas fa-pencil-alt" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        `<div class="remove border-action d-flex align-items-center justify-content-center mr-1 action-icon" onclick="hapus('${row.id}')" title="Remove">`,
        '<i class="fas fa-trash" style="margin: 0; font-size: 18px"></i>',
        '</div>',
        `<div class="download border-action d-flex align-items-center justify-content-center action-icon" onclick="download(${row.id})" title="Download">`,
        '<i class="fas fa-download" style="margin: 0; font-size: 18px"></i>',
        '</div>',
    ].join('')
}

window.operateEvents = {
    'click .view': function (e, value, row, index) {
        views(e, row.slug);
    },
    'click .edit': function (e, value, row, index) {
        edit(e, row.slug)
    },
    'click .remove': function (e, value, row, index) {
        hapus(e, value)
    },
    'click .download': function (e, value, row, index) {
        download(e, row.id);
    },
}

function divisiFormatter(value) {
    return `<div class="ellipsis-2 link-format-table">${value}</div>`
}

function toKatalog(short) {
    localStorage.removeItem("fil_div");
    localStorage.setItem("fil_div",short);
}

function download(id) {
    window.location.href = uri+`/attach/download/strategic/${id}`;
}

function edit(row) {
    window.location.href = uri+`/managecommunication/strategicinitiative/project/${row}`
}

function hapus(id){
    let t = "{{$token_auth}}";
    const url = `${uri}/manageproject/strategic/destroy/${id}`
    swal.fire({ title: "Anda yakin akan menghapus Konten Proyek ini?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#28a745", cancelButtonColor: "#dc3545", confirmButtonText: "OK", cancelButtonText: "CANCEL" }).then((i) => {
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
                    if(i.isConfirmed){
                        location.reload();
                    }else{
                        location.reload();
                    }
                },
                error: function () {
                    $('.senddataloader').hide();
                    Toast2.fire({icon: 'error',title: 'Gagal dihapus'}); //PERLU DIGANTI BAHASANYA
                },
            })
        }
    });
}

function views(row) {
    window.location.href = uri+`/managecommunication/strategicinitiative/project/${row}`;
}
