var uri;
let sort = 'disabled';
let sort2 = 'disabled';
let search = "*";
var csrf = '';
var sklt = `<div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt mt-2"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div><div class="col-md-6 sklt"><div class="ph-item border control list-project mb-2"><div class="ph-col-4 mb-0"><div class="ph-picture"></div></div><div class="mb-0"><div class="ph-row"><div class="ph-col-12 big mb-3"></div><div class="ph-col-12"></div><div class="ph-col-12"></div><div class="ph-col-12"></div></div></div></div></div>`;


    //  divisi
    var filter_divisi   = [];
    filter_divisi       = localStorage.getItem('fil_div')??[];
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
            $(`.fil_div_d[value="${filter_divisi[index]}"]`).prop('checked',true);
        }
    }
    // console.log(`filter divisi : ${filter_divisi}`);

    //  konsultan
    var filter_konsultant = [];
    filter_konsultant = localStorage.getItem('fil_kon')??[];
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
            $(`.fil_kon_d[value="${filter_konsultant[index]}"]`).prop('checked',true);
        }
    }
    
    //  Tahun
    var filter_tahun = [];
    filter_tahun = localStorage.getItem('fil_thn')??[];
    console.log(`filter_tahun : ${filter_tahun}`);
    if (filter_tahun   ===  "") {
        filter_tahun   =   [];
    }else{
        try {
            filter_tahun = filter_tahun.split(',') === [""] ? [] : filter_tahun.split(',');
        } catch (error) {
            filter_tahun = [];
        }
    }
    if (filter_tahun.length > 0) {
        for (let index = 0; index < filter_tahun.length; index++) {
            $(`.fil_thn[value="${filter_tahun[index]}"]`).prop('checked',true);
            $(`.fil_thn_d[value="${filter_tahun[index]}"]`).prop('checked',true);
        }
    }
    // console.log(`filter Tahun : ${filter_tahun}`);
    //  lesson learn
    var filter_lessonlearn = [];
    filter_lessonlearn = localStorage.getItem('fil_les')??[];
    console.log(`filter_lessonlearn : ${filter_lessonlearn}`);
    if (filter_lessonlearn   ===  "" || typeof(filter_lessonlearn) === null) {
        filter_lessonlearn   =   [];
    }else{
        try {
            filter_lessonlearn = filter_lessonlearn.split(',') === [""] ? [] : filter_lessonlearn.split(',');
        } catch (error) {
            filter_lessonlearn = [];
        }
    }
    if (filter_lessonlearn.length > 0) {
        for (let index = 0; index < filter_lessonlearn.length; index++) {
            $(`.fil_les[value="${filter_lessonlearn[index]}"]`).prop('checked',true);
            $(`.fil_les_d[value="${filter_lessonlearn[index]}"]`).prop('checked',true);
        }
    }

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
      uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "kunci") {
        search = metas[i].getAttribute('content');
        if (search !== '*') {
            search  =   `*${search}*`;
        }
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

// paginate
let from = 0;
let all = 0;
let data_inpage = 0;
let page_active = 0;
let per_page = 10;

// filter
var centang = `<svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
var centang2 = `<svg class="w-6 h-6 mr-2 centang2 float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
$("#baru").click(function(e){
    from = 0;
    all = 0;
    data_inpage = 0;
    page_active = 0;
    $('.centang').remove();
    if (sort == 'desc') {
        sort = 'disabled';
    }else{
        sort = 'desc';
        $('#baru').append(centang);
    }
    getData();
});
$("#lama").click(function(e){
    from = 0;
    all = 0;
    data_inpage = 0;
    page_active = 0;
    $('.centang').remove();
    if (sort == 'asc') {
        sort = 'disabled';
    }else{
        sort = 'asc';
        $('#lama').append(centang);
    }
    getData();
});
$("#az").click(function(e){
    from = 0;
    all = 0;
    data_inpage = 0;
    page_active = 0;
    $('.centang2').remove();
    if (sort2 == 'asc') {
        sort2 = 'disabled';
    }else{
        sort2 = 'asc';
        $('#az').append(centang2);
    }
    getData();
});
$("#za").click(function(e){
    from = 0;
    all = 0;
    data_inpage = 0;
    page_active = 0;
    $('.centang2').remove();
    if (sort2 == 'desc') {
        sort2 = 'disabled';
    }else{
        sort2 = 'desc';
        $('#za').append(centang2);
    }
    getData();
});

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

// pencarian
$("#search-form").submit(function(e){
    if (!e.isDefaultPrevented()){
        from = 0;
        all = 0;
        data_inpage = 0;
        page_active = 0;

        var tampung = e.target[0].value;
        if (tampung == "" || !tampung.trim().length) {
            search = "*";
        }else{
            search = `*${tampung}*`;
        }
        $(".input-search").attr('disabled',true);
        $(".btn-search").attr('disabled',true);
        getData();
    }
    return false;
});

// filter
    // divisi
        $(".fil_div_d").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_divisi.push(e.target.value);
                $(`.fil_div[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_divisi.indexOf(e.target.value);
                if (index > -1) {
                    filter_divisi.splice(index, 1);
                }
                $(`.fil_div[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',false);
            }
            localStorage.setItem("fil_div",[]);
            localStorage.setItem("fil_div",filter_divisi);
            getData();
        })

        $(".fil_div").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_divisi.push(e.target.value);
                $(`.fil_div[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_divisi.indexOf(e.target.value);
                if (index > -1) {
                    filter_divisi.splice(index, 1);
                }
                $(`.fil_div[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_div_d[value="${e.target.value}"]`).prop('checked',false);
            }
        })

        $(".fil-div-res").click(function(e){
            $('.fil_div').prop('checked',false);
            $('.fil_div_d').prop('checked',false);
            localStorage.setItem("fil_div",[]);
            filter_divisi=[];
            getData();
        })

        $(".fil-div-app").click(function(e){
            localStorage.setItem("fil_div",[]);
            localStorage.setItem("fil_div",filter_divisi);
            getData();
        })
    // consultant
        $(".fil_kon_d").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_konsultant.push(e.target.value);
                $(`.fil_kon[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_konsultant.indexOf(e.target.value);
                if (index > -1) {
                    filter_konsultant.splice(index, 1);
                }
                $(`.fil_kon[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',false);
            }
            localStorage.setItem("fil_kon",[]);
            localStorage.setItem("fil_kon",filter_konsultant);
            getData();
        })

        $(".fil_kon").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_konsultant.push(e.target.value);
                $(`.fil_kon[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_konsultant.indexOf(e.target.value);
                if (index > -1) {
                    filter_konsultant.splice(index, 1);
                }
                $(`.fil_kon[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked',false);
            }
        })

        $(".fil-kon-res").click(function(e){
            $('.fil_kon').prop('checked',false);
            $('.fil_kon_d').prop('checked',false);
            localStorage.setItem("fil_kon",[]);
            filter_konsultant=[];
            getData();
        })

        $(".fil-kon-app").click(function(e){
            localStorage.setItem("fil_kon",[]);
            localStorage.setItem("fil_kon",filter_konsultant);
            getData();
        })
    // tahun
        $(".fil_thn_d").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_tahun.push(e.target.value);
                $(`.fil_thn[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_tahun.indexOf(e.target.value);
                if (index > -1) {
                    filter_tahun.splice(index, 1);
                }
                $(`.fil_thn[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',false);
            }
            localStorage.setItem("fil_thn",[]);
            localStorage.setItem("fil_thn",filter_tahun);
            getData();
        })

        $(".fil_thn").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_tahun.push(e.target.value);
                $(`.fil_thn[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_tahun.indexOf(e.target.value);
                if (index > -1) {
                    filter_tahun.splice(index, 1);
                }
                $(`.fil_thn[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked',false);
            }
        })

        $(".fil-thn-res").click(function(e){
            $('.fil_thn').prop('checked',false);
            $('.fil_thn_d').prop('checked',false);
            localStorage.setItem("fil_thn",[]);
            filter_tahun=[];
            getData();
        })

        $(".fil-thn-app").click(function(e){
            localStorage.setItem("fil_thn",[]);
            localStorage.setItem("fil_thn",filter_tahun);
            getData();
        })

        // lessonlearn
        $(".fil_les_d").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_lessonlearn.push(e.target.value);
                $(`.fil_les[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_lessonlearn.indexOf(e.target.value);
                if (index > -1) {
                    filter_lessonlearn.splice(index, 1);
                }
                $(`.fil_les[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',false);
            }
            localStorage.setItem("fil_les",[]);
            localStorage.setItem("fil_les",filter_lessonlearn);
            getData();
        })

        $(".fil_les").change(function(e){
            if ($(this).prop('checked')==true){ 
                // add item
                filter_lessonlearn.push(e.target.value);
                $(`.fil_les[value="${e.target.value}"]`).prop('checked',true);
                $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',true);
            }else{
                // remove item
                const index = filter_lessonlearn.indexOf(e.target.value);
                if (index > -1) {
                    filter_lessonlearn.splice(index, 1);
                }
                $(`.fil_les[value="${e.target.value}"]`).prop('checked',false);
                $(`.fil_les_d[value="${e.target.value}"]`).prop('checked',false);
            }
        })

        $(".fil-les-res").click(function(e){
            $('.fil_les').prop('checked',false);
            $('.fil_les_d').prop('checked',false);
            localStorage.setItem("fil_les",[]);
            filter_lessonlearn=[];
            getData();
        })

        $(".fil-les-app").click(function(e){
            localStorage.setItem("fil_les",[]);
            localStorage.setItem("fil_les",filter_lessonlearn);
            getData();
        })
  
// get data
const getData = () =>{
    // filter
    var h_div="";
    for (let index = 0; index < filter_divisi.length; index++) {
        if (h_div   ==  "") {
            h_div   =  `${filter_divisi[index]}`;
        }else{
            h_div   +=  `,${filter_divisi[index]}`;
        }
    }
    var h_kon="";
    for (let index = 0; index < filter_konsultant.length; index++) {
        if (h_kon   ==  "") {
            h_kon   =  `${filter_konsultant[index]}`;
        }else{
            h_kon   +=  `,${filter_konsultant[index]}`;
        }
    }
    var h_thn="";
    for (let index = 0; index < filter_tahun.length; index++) {
        if (h_thn   ==  "") {
            h_thn   =  `${filter_tahun[index]}`;
        }else{
            h_thn   +=  `,${filter_tahun[index]}`;
        }
    }
    // console.log(h_thn);
    var h_les="";
    for (let index = 0; index < filter_lessonlearn.length; index++) {
        if (h_les   ==  "") {
            h_les   =  `${filter_lessonlearn[index]}`;
        }else{
            h_les   +=  `,${filter_lessonlearn[index]}`;
        }
    }

    // parsing
    var url = `${uri}/kat`;
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': csrf},
        type: "post",
        data: {sort:sort,sort2:sort2,from:from,search:search,f_divisi:h_div,f_konsultant:h_kon,f_tahun:h_thn,f_lessonlearn:h_les},
        beforeSend: function()
        {
            $('.pagination').remove();
            $('.data').remove();

            // sklt
            $('.sklt').remove();
            $("#result").append(sklt);
        },
        success: function(data){
            if(data.html == "" || data.html == null){
                // sklt
                $('.sklt').fadeOut().remove();
                return;
            }
            
            // sklt
            $('.sklt').fadeOut().remove();

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