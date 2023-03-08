var uri;
var csrf = '';
var page    = 1;
var be      = '';
var search  = '*';
let sort = '*';
let sort2 = '*';

// meta url
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

// filter
var centang = `<svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
var centang2 = `<svg class="w-6 h-6 mr-2 centang2 float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
$("#baru").click(function(e){
    $('.centang').remove();
    if (sort == 'asc') {
        sort = '*';
        console.log(sort);
    }else{
        sort = 'asc';
        console.log(sort);
        $('#baru').append(centang);
    }
    getdatalist();
});
$("#lama").click(function(e){
    $('.centang').remove();
    if (sort == 'desc') {
        sort = '*';
        console.log(sort);
    }else{
        sort = 'desc';
        console.log(sort);
        $('#lama').append(centang);
    }
    getdatalist();
});
$("#az").click(function(e){
    $('.centang2').remove();
    if (sort2 == 'asc') {
        sort2 = '*';
        console.log(sort2);
    }else{
        sort2 = 'asc';
        console.log(sort2);
        $('#az').append(centang2);
    }
    getdatalist();
});
$("#za").click(function(e){
    $('.centang2').remove();
    if (sort2 == 'desc') {
        sort2 = '*';
        console.log(sort2);
    }else{
        sort2 = 'desc';
        console.log(sort2);
        $('#za').append(centang2);
    }
    getdatalist();
});

$("#search").submit(function(e){
    if (!e.isDefaultPrevented()){
        page=1;
        var tampung = e.target[0].value;
        if (tampung == "" || !tampung.trim().length) {
            search = "*";
        }else{
            search = tampung;
        }
        getdatalist();
    }
    return false;
});

$(document).on('click', '.pagination a', function(event){
    event.preventDefault();
    page = $(this).attr('href').split('page=')[1];
    getdatalist();
});

const getdatalist = () =>{
    var url = `${uri}/manageuker/${sort}/${sort2}/${search}?page=${page}`;
    $.ajax({
        url: url,
        headers: {
            "X-CSRF-TOKEN"  :   csrf,
            "Accept"        :   "application/json"
        },
        type: "get",
        beforeSend: function()
        {
            $('.senddataloader').show();
            $('#content-table-body').empty();
            $('#pag').empty();
            $('.modal_log').remove();
        },
        success: function(data){
            // console.log(data.data);
            if(data.data.data.html == "" || data.data.data.html == null){
                $('.senddataloader').hide();
                alert(data.data.data.html); //kaga kena
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#content-table-body").append(data.data.data.html);
            $("#pag").append(data.data.data.paginate);
            $("#popupin").append(data.data.data.modal);
        },
        error : function(xhr, status, error){
            console.log(xhr.responseText);
            console.log(error.Message);
            // alert(e);
            $('.senddataloader').hide();
        }
    });
}

getdatalist();

// SELECT DIREKTORAT
$('#direktorat_uker').select2({
    placeholder : 'Pilih Direktorat',
    tags: true,
    dropdownParent: $("#modal-add-uker")
});