var uri;
var csrf = '';
var page    = 1;
var be      = '';
var search  = '*';

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
        //  divisi
            var filter_divisi   = [];
            filter_divisi       = localStorage.getItem('rev_fil_div')??[];
            console.log(`filter_divisi : ${filter_divisi}`);
            if (filter_divisi   ===  "" || typeof(filter_divisi) === null) {
                filter_divisi   =   [];
            }else{
                try {
                    filter_divisi = filter_divisi.split(',') === [""] ? [] : filter_divisi.split(',');
                } catch (error) {
                    filter_divisi   =   [];
                }
            }
            if (filter_divisi.length > 0) {
                for (let index = 0; index < filter_divisi.length; index++) {
                    $(`.fil_div[value="${filter_divisi[index]}"]`).prop('checked',true);
                }
            }
            // console.log(`filter divisi : ${filter_divisi}`);

        //  konsultan
            var filter_konsultant = [];
            filter_konsultant = localStorage.getItem('rev_fil_kon')??[];
            console.log(`filter_konsultant : ${filter_konsultant}`);
            if (filter_konsultant   ===  "" || typeof(filter_konsultant) === null) {
                filter_konsultant   =   [];
            }else{
                try {
                    filter_konsultant = filter_konsultant.split(',') === [""] ? [] : filter_konsultant.split(',');
                } catch (error) {
                    filter_konsultant = [];
                }
            }
            if (filter_konsultant.length > 0) {
                for (let index = 0; index < filter_konsultant.length; index++) {
                    $(`.fil_kon[value="${filter_konsultant[index]}"]`).prop('checked',true);
                }
            }

// filter
    // divisi
    $(".fil_div").change(function(e){
        if ($(this).prop('checked')==true){
            // add item
            filter_divisi.push(e.target.value);
            $(`.fil_div[value="${e.target.value}"]`).prop('checked',true);
        }else{
            // remove item
            const index = filter_divisi.indexOf(e.target.value);
            if (index > -1) {
                filter_divisi.splice(index, 1);
            }
            $(`.fil_div[value="${e.target.value}"]`).prop('checked',false);
        }
    })

    $(".fil-div-res").click(function(e){
        $('.fil_div').prop('checked',false);
        localStorage.setItem("rev_fil_div",[]);
        filter_divisi=[];
        getdatalist();
    })

    $(".fil-div-app").click(function(e){
        localStorage.setItem("rev_fil_div",[]);
        localStorage.setItem("rev_fil_div",filter_divisi);
        page=1;
        getdatalist();
    })
// consultant
    $(".fil_kon").change(function(e){
        if ($(this).prop('checked')==true){
            // add item
            filter_konsultant.push(e.target.value);
            $(`.fil_kon[value="${e.target.value}"]`).prop('checked',true);
        }else{
            // remove item
            const index = filter_konsultant.indexOf(e.target.value);
            if (index > -1) {
                filter_konsultant.splice(index, 1);
            }
            $(`.fil_kon[value="${e.target.value}"]`).prop('checked',false);
        }
    })

    $(".fil-kon-res").click(function(e){
        $('.fil_kon').prop('checked',false);
        localStorage.setItem("rev_fil_kon",[]);
        filter_konsultant=[];
        getdatalist();
    })

    $(".fil-kon-app").click(function(e){
        localStorage.setItem("rev_fil_kon",[]);
        localStorage.setItem("rev_fil_kon",filter_konsultant);
        page=1;
        getdatalist();
    })

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


const views = (slug) =>{
    var url = `${uri}/myproject/preview2/`+slug;
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
            alert(e);
        }
    });
}

function downloadDoc(name, source) {
    window.location.href = uri+`/doc/download?source=${source}&file_name=${name}`;
}

$(document).on('click', '.pagination a', function(event){
    event.preventDefault();
    page = $(this).attr('href').split('page=')[1];
    getdatalist();
});

const getdatalist = () =>{
    // filter
    var h_div="*";
    for (let index = 0; index < filter_divisi.length; index++) {
        if (h_div   ==  "*") {
            h_div   =  `${filter_divisi[index]}`;
        }else{
            h_div   +=  `,${filter_divisi[index]}`;
        }
    }
    var h_kon="*";
    for (let index = 0; index < filter_konsultant.length; index++) {
        if (h_kon   ==  "*") {
            h_kon   =  `${filter_konsultant[index]}`;
        }else{
            h_kon   +=  `,${filter_konsultant[index]}`;
        }
    }

    var url = `${uri}/manageproject/review/${h_div}/${h_kon}/${search}?page=${page}`;
    $.ajax({
        url: url,
        headers: {
            'Authorization' :   `Bearer ${csrf}`,
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
            console.log(data);
            if(data.data.html == "" || data.data.html == null){
                $('.senddataloader').hide();
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#content-table-body").append(data.data.html);
            $("#pag").append(data.data.paginate);
            $("#popupin").append(data.data.modal);
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

