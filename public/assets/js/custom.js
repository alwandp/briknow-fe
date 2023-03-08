var uri;
var meta = document.getElementsByTagName('meta');
for (let i = 0; i < meta.length; i++) {
    if (meta[i].getAttribute('name') === "pages") {
        uri = meta[i].getAttribute('content');
    }
}

$("#search").keyup(async function(){
    var tampung = document.getElementById("search").value;
    $.ajax({
        url: uri+"/suggestjax/"+tampung,
        type: "get",
        beforeSend: function()
        {
        }
    })
    .done(function(data){
        console.log(data);
        $('.ResultItem').remove();
        if (data.out.length == 0) {
            $('.ResultItem').remove();
        }else{
            var tampungin = "";
            $('.ResultItem').remove();
            data.out.forEach(element => {
                tampungin += `<a class="dropdown-item ResultItem" href="${uri}/katalog/${element._source.nama}">${element._source.nama}</a>`;
            });
            $('#searchResult').append(tampungin);
            $("#searchResult").toggle(true);
        }
        
    })
    .fail(function(jqXHR, ajaxOptions, thrownError){
        $('.ResultItem').remove();
        console.log('Server Not Responding.. , Please Refresh');
    });
});

$(document).on("click", function(event){
    $(".dropdown-menu").slideUp("fast");
});