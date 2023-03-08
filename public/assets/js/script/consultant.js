var uri;
let sort = 'desc';
let search = '*';

// paginate
let from = 0;
let all = 0;
let data_inpage = 0;
let page_active = 0;
let per_page = 10;

// paginator
const paginator = () =>{
    // var temp_pag = paginate_prev;
    var temp_pag = "";
    if (all > per_page) {
        // urutan pagination
        var page_urut=0;
        //  jangka jarak
        var jarak = page_active - 2;
        // awal
        if (jarak > 1) {
            temp_pag += `<li class="page-item"><a class="page-link" href="#" onclick='paging(0)'>${0+1}</a></li>`;
            temp_pag += `<li class="page-item disabled"><a class="page-link" href="#">..</a></li>`;
            page_urut = jarak;
            jarak *= 10;
        }else{
            jarak = 0;
        }
        // akhir
        var button_per_page = 2;
        var button_per_page_now = 0;
        var button_per_page_shuttle = 0;

        // looping
        for (let index = jarak; index < all; index+=per_page) {
            if (button_per_page_now <= button_per_page) {
                if (page_urut==page_active) {
                    temp_pag += `<li class="page-item active"><a class="page-link" href="#" onclick='paging(${page_urut})'>${page_urut+1}</a></li>`;
                }else{
                    temp_pag += `<li class="page-item"><a class="page-link" href="#" onclick='paging(${page_urut})'>${page_urut+1}</a></li>`;
                }
            }else{
                button_per_page_shuttle = page_urut;
            }
            
            page_urut++;
            if (page_urut > page_active) {
                button_per_page_now++;
            }
        }
    }else{
        temp_pag += '<li class="page-item active disabled"><a class="page-link" href="#">1</a></li>';
    }
    // akhir
    if (typeof button_per_page_shuttle !== 'undefined') {        
        if (button_per_page_shuttle > 0) {
            temp_pag += `<li class="page-item disabled"><a class="page-link" href="#">..</a></li>`;
            temp_pag += `<li class="page-item"><a class="page-link" href="#" onclick='paging(${button_per_page_shuttle})'>${button_per_page_shuttle+1}</a></li>`;
        }
    }
    // next
    // temp_pag += paginate_next;

    // paginate
    $("#pagination").append(temp_pag);

    // result
    $("#first_number").text(from+1);
    var last_number = all - from;
    if (last_number < per_page) {
        $("#last_number").text(all);
    }else{
        $("#last_number").text(from+=10);
    }
}

const paging = (page_urut) =>{
    if (page_urut == 0) {
        from = 0;
    }else{
        from = page_urut * 10;
    }

    if (page_active > page_urut) {
        var jarak = page_active - page_urut;
        page_active -= jarak;
    }else if (page_active < page_urut){
        var jarak = page_urut - page_active;
        page_active += jarak;
    }
    getData();
}

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
      uri = metas[i].getAttribute('content');
    }
}

// pencarian
$("#search-form").submit(function(e){
    console.log(e.target[0]);
    if (!e.isDefaultPrevented()){
        from = 0;
        all = 0;
        data_inpage = 0;
        page_active = 0;

        var tampung = e.target[0].value;
        if (tampung == "" || !tampung.trim().length) {
            search = "*";
        }else{
            search = tampung;
        }
        $(".input-search").attr('disabled',true);
        $(".btn-search").attr('disabled',true);
        getData();
    }
    return false;
});

// get data
const getData = () =>{
    var url = `${uri}/consultant/${sort}/${from}/${search}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function()
        {
            $('.pagination').remove();
            $('.data').remove();
            $('.aload').show();
        },
        success: function(data){
            console.log(data);
            if(data.html == "" || data.html == null){
                $('.aload').hide();
                return;
            }
            $('.aload').hide();
            // innert html
            $("#result").append(data.html);
            // count data
            all = data.all;
            // paginate
            if (all > 0) {
                paginator();
            }
            // set default input form
            $(".input-search").attr('disabled',false);
            $(".btn-search").attr('disabled',false);
        },
        error : function(e){
            alert(e);
        }
    });
}

getData();