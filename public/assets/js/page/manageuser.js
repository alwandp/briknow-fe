var csrf    = '';
var uri     = '';
var be      = '';
var search  = '*';
var csrf    = '';
var page    = 1;

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

$("#search").submit(function(e){
    if (!e.isDefaultPrevented()){
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
    getdatalist(page);
});

const getdatalist = () =>{
    var url = `${uri}/manageuser/list_admin/${search}/${page}`;
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
            $('.content-list').remove();
            $('#pag').empty();
        },
        success: function(data){
            if(data.data.html == "" || data.data.html == null){
                $('.senddataloader').hide();
                return;
            }
            $('.senddataloader').hide();
            // innert html
            $("#content-list-user").append(data.data.html);
            $("#pag").append(data.data.paginate);
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
