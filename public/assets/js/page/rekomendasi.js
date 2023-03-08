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