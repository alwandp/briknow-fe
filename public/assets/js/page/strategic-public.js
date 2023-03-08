let selections = [];
let csrf;
let urlBE = "";
let uri;

let pageParam = "1";
let yearParam = "";
let monthParam = "";
let direktoratParam = "";
let divisiParam = "";
let sortParam = "";
let tahapParam = "";
let keywordParam = "";
let slideIndex = 1;

localStorage.removeItem('fil_proj');

const metas = document.getElementsByTagName('meta');
let lastpath = window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
let twoLastPath = window.location.pathname.split('/');

for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

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

function openPreview(id) {
    const url = `${uri}/communication/views/content/${id}?public=1`
    let t = "{{$token_auth}}";

    $.ajax({
        url: url,
        type: 'post',
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
            $('#content-modal').empty();
        },
        success: function (data) {
            $('.senddataloader').hide();

            let view = data.data.views
            $(`#view-${id}`).text(view)
            $('#content-modal').append(data.prev);

            $('#preview').modal({
                show : true
            });

            showSlides(slideIndex);
        },
        error: function () {
            $('.senddataloader').hide();
            Toast2.fire({icon: 'error',title: 'Gagal'});
        },
    })
}

$('#preview').on('hidden.bs.modal', function () {
    let video = $('video').get(0)
    if (video) {
        video.pause()
    }

    $('#content-modal').empty();
})

$(document).on('click', '.pagination a', function(event){
    event.preventDefault();
    pageParam = $(this).attr('href').split('page=')[1];
    getData(pageParam, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam);
});

if (lastpath === 'strategic'){
    getData(pageParam, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam)
}else if(lastpath === twoLastPath[3]){
    getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}else if (twoLastPath[3] !== undefined){
    getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
}

function getData(page, year, month, direktorat, divisi, sort, search, tahap){
    const url = `${getCookie('url_be')}api/get/strategic/publish?page=${page}&year=${year}&month=${month}&direktorat=${direktorat}&divisi=${divisi}&sort=${sort}&search=${search}&tahap=${tahap}`
    console.log(url);
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
            $("#pag").empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#card-content-strategic").html("");
            if (data.data.data.total !== 0){
                $("#pag").append(data.data.data.paginate);
                console.log(data.data.data);
                for (let index=0; index < data.data.data.total; index++){
                    $('#card-content-strategic').append(`<div class="col-lg-4 d-flex justify-content-center mb-3">
                                                <a class="w-100" href="${uri+'/mycomsupport/strategic/'+data.data.data[index].slug}">
                                                    <div class="card" style="border-radius: 16px;">
                                                        <img class="card-img-up" src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                                                             alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title text-center" style="height: 45px;">${data.data.data[index].nama}</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>`);
                }
            }else{
                $('#card-content-strategic').append(`
                    <div class="p-2 w-100 pt-5 text-center">
                        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                        <h5 class="font-weight-bold mt-5 mb-1">Oops.. Project tidak ditemukan</h5>
                        <p class="w-100 text-center font-weight-bold">Coba cari project lain</p>
                    </div>`);
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function getDataByProject(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/strategic/publish/${lastpath}?year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    console.log(url);
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
	    $('#ContentArticle').empty();
	    $('#ContentVideo').empty();
	    $('#ContentPodcast').empty();
	    $('#ContentIg').empty();
	    $('#ContentTrans').empty();
	    $('#ContentLogo').empty();
	    $('#ContentInfo').empty();
        },
        success: function(data){
            $('.senddataloader').hide();
            if (data.data.content !== undefined || data.data.content.length !== 0){
                for (let index=0; index < data.data.content.length; index++){
                    for (let index2=0; index2 < data.data.content[index].data.length; index2++){
                        if (data.data.content[index].id === 'article'){
                            $("#ContentArticle").append(`<div class="col-2 justify-content-center">
	                                                    <div class="card h-100" style="border-radius: 16px">
	                                                        <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
	                                                             alt="Card image cap">
	                                                    </div>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'video'){
                            $("#ContentVideo").append(`<div class="col-2 justify-content-center">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'podcast'){
                            $("#ContentPodcast").append(`<div class="col-2 justify-content-center">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'instagram'){
                            $("#ContentIg").append(`<div class="col-2 justify-content-center">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'transformation'){
                            $("#ContentTrans").append(`<div class="col-2 justify-content-center">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'logo'){
                            $("#ContentLogo").append(`<div class="col-2 justify-content-center">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                    </div>`);
                        }else if(data.data.content[index].id === 'infographics'){
                            $("#ContentInfo").append(`<div class="col-2 justify-content-center">
                                                            <div class="card h-100" style="border-radius: 16px">
                                                                <img class="img-fluid img-content" src="${uri+'/storage/'+data.data.content[index].data[index2].thumbnail}"
                                                                     alt="Card image cap">
                                                            </div>
                                                    </div>`);
                        }
                    }
                }
            }else{
                document.getElementById('card-content-strategic').innerHTML =
                    `<div class="p-2 w-100 pt-5 text-center">
                        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                        <h5 class="font-weight-bold mt-5 mb-1">Oops.. Content tidak ditemukan</h5>
                        <p class="w-100 text-center font-weight-bold">Coba cari content lain</p>
                    </div>`
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

function toPiloting() {
  let namaProject = $('#namaProject').val();
  localStorage.setItem('fil_proj', namaProject);
}

function getDataByContent(page, year, month, divisi, sort, search){
    const url = `${getCookie('url_be')}api/get/strategic/publish/${twoLastPath[3]}/${lastpath}?year=${year}&month=${month}&divisi=${divisi}&sort=${sort}&search=${search}`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
            $('.senddataloader').show();
        },
        success: function(data){
            $('.senddataloader').hide();
            $("#card-content-strategic").empty();
            if (data.data !== undefined && data.data.length !== 0){
                for (let index=0; index < data.data.length; index++) {
                    $("#card-content-strategic").append(`<div class="col-lg-4 d-flex justify-content-center">
                                        <div class="card" style="border-radius: 16px;width: inherit">
                                            <button type="button" class="btn p-0 text-primary" onclick="openPreview(${data.data[index].id})">
                                                <img class="card-img-up"
                                                     src="${uri+'/storage/'+data.data[index].thumbnail}" alt="Card image cap">
                                             </button>
                                                <div class="card-body">
                                                    <button type="button" class="btn p-0 text-primary" onclick="openPreview(${data.data[index].id})">
                                                        <h5 class="card-title text-black-50">${data.data[index].title}</h5>
                                                    </button>
                                                    <div class="d-flex justify-content-between">
                                                        <i class="mr-auto p-2 fas fa-eye mt-2">
                                                            <span id="view-${data.data[index].id}">${data.data[index].views}</span>
                                                        </i>
                                                      <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data[index].id})">
                                                          <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                                                      </button>
                                                      <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                                                          onclick="migrasi('Eh, liat Konten ini deh. ${data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data[index].type_file+"?slug="+data.data[index].slug}')">
                                                          <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                                                      </button>
                                                      <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data[index].id})">
                                                          <img src="${uri+(data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                                                      </button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>`);
                }
            }else{
                $("#card-content-strategic").append(`
                    <div class="p-2 w-100 pt-5 text-center">
                        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                        <h5 class="font-weight-bold mt-5 mb-1">Oops.. Content tidak ditemukan</h5>
                        <p class="w-100 text-center font-weight-bold">Coba cari content lain</p>
                    </div>`)
            }
        },
        error : function(e){
            alert(e);
        }
    });
}

$(document).ready(function () {

    $('#dir-strategic-init').select2({
        placeholder: 'Pilih Direktorat'
    });

    $('#divisi-strategic-init').select2({
        placeholder: 'Pilih Unit Kerja'
    });
})

$("#dir-strategic-init").on("select2:select", function (e) {
  direktoratParam = e.params.data.id.replace('&', '%26');
  cekDivisi("select", e.params.data.id);
  divisiParam = "";
  getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam);
});

$("#divisi-strategic-init").on("select2:select", function (e) {
  divisiParam = e.params.data.id;
  getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam);
});

const cekDivisi = (selOrUn, value) => {
if ($("#divisi-strategic-init").hasClass("is-invalid") || $("#divisi-lesson-init").hasClass("is-valid")) {
    if (this.value == "") {
    $("[aria-labelledby='select2-direktorat-container']").attr(
        "style",
        "border-color:red;"
    );
    } else {
    $("[aria-labelledby='select2-direktorat-container']").attr(
        "style",
        "border-color:#38c172;"
    );
    }
}

var url = `${uri}/getdivisi/${value}`;
$.ajax({
    url: url,
    type: "get",
    beforeSend: function () {
    $(".pagination").remove();

    $("#divisi-strategic-init option").each(function() {
        $(this).remove();
    });

    $(".senddataloader").show();
    },
    success: function (data) {
    // var option = "<option value='' selected disabled>Pilih Unit Kerja</option>";
    let option = `<option value="init">All Divisi</option>`;
    $(".senddataloader").hide();
    // innert html
    if (data.data.length > 0) {
        for (let index = 0; index < data.data.length; index++) {
        if (selOrUn === "select") {
        if (value === data.data[index].id) {
        option += `<option value="${data.data[index].id}" data-value="${data.data[index].id}" selected>${data.data[index].divisi}</option>`;
        } else {
        option += `<option value="${data.data[index].id}" data-value="${data.data[index].id}">${data.data[index].divisi}</option>`;
        }
        } else {
            option += `<option value="${data.data[index].id}" data-value="${data.data[index].id}">${data.data[index].divisi}</option>`;
        }
        }
    }
    $('#divisi-strategic-init').append(option);
    },
    error: function (e) {
    $(".senddataloader").hide();
    alert(e);
    },
});
};

function getYearBtn(param, id){
    var element = document.getElementById(id);
    if (element.classList.contains("active")){
        element.classList.remove("active")
        if (yearParam.includes(','+param)){
            yearParam = yearParam.replace(','+param, "")
        }else{
            yearParam = yearParam.replace(param, "")
        }
    }else{
        element.classList.add("active");
        if (yearParam === ''){
            yearParam = param
        }else{
            yearParam = yearParam.concat(",", param)
        }
    }
    if (lastpath === 'strategic'){
        getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
}

function getMonthBtn(param, id){
    var element = document.getElementById(id);
    if (element.classList.contains("active")){
        element.classList.remove("active")
        if (monthParam.includes(','+param)){
            monthParam = monthParam.replace(','+param, "")
        }else{
            monthParam = monthParam.replace(param, "")
        }
    }else{
        element.classList.add("active");
        if (monthParam === ''){
            monthParam = param
        }else{
            monthParam = monthParam.concat(",", param)
        }
    }
    if (lastpath === 'strategic'){
        getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
}

function searchCominit(){
    keywordParam = document.getElementById("searchCominit").value;
    if (lastpath === 'strategic'){
        getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam)
    }else if(lastpath === twoLastPath[3]){
        getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }else{
        getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
    }
}

function sortingBy(params){
    sortParam = document.getElementById(params).getAttribute('data-value')
    if (sortParam !== ''){
        if (lastpath === 'strategic'){
            getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam)
        }else if(lastpath === twoLastPath[3]){
            getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        }else{
            getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam)
        }

        if (sortParam === 'nama'){
            document.getElementById('btn-sort-comsup').innerHTML = "Judul"
        }else if (sortParam === 'created_at'){
            document.getElementById('btn-sort-comsup').innerHTML = "Tanggal"
        }else if (sortParam === 'views'){
            document.getElementById('btn-sort-comsup').innerHTML = "View"
        }
    }else{
        if (lastpath === 'strategic'){
            getData(1, yearParam, monthParam, divisiParam, '', keywordParam, tahapParam)
        }else if(lastpath === twoLastPath[3]){
            getDataByProject(pageParam, yearParam, monthParam, divisiParam, '', keywordParam)
        }else{
            getDataByContent(pageParam, yearParam, monthParam, divisiParam, '', keywordParam)
        }
        document.getElementById('btn-sort-comsup').innerHTML = "Sort By"
    }
}

function filterTahap(params) {
    tahapParam = document.getElementById(params).getAttribute('data-value');
    if (tahapParam !== 'all') {
      if (lastpath === 'strategic') {
          getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, tahapParam);
      } else if (lastpath === twoLastPath[3]) {
          getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam);
      } else {
          getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam);
      }

      if (tahapParam === "piloting") {
          document.getElementById("btn-filter-tahap").innerHTML = "Piloting";
      } else if (tahapParam === "roll-out") {
          document.getElementById("btn-filter-tahap").innerHTML = "Roll Out";
      } else if (tahapParam === "sosialisasi") {
          document.getElementById("btn-filter-tahap").innerHTML = "Sosialisasi";
      }
    } else {
      if (lastpath === 'strategic') {
          getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, 'all');
      } else if (lastpath === twoLastPath[3]) {
          getDataByProject(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam);
      } else {
          getDataByContent(pageParam, yearParam, monthParam, divisiParam, sortParam, keywordParam);
      }

      document.getElementById("btn-filter-tahap").innerHTML = "All Implementation";
    }

}

function download(id) {
    window.location.href = uri+`/attach/download/content/${id}`;
}

function migrasi(pesan) {
    var kopi = document.getElementById("link");
    kopi.value = pesan
}

function kopas() {
    var kopi = document.getElementById("link");
    kopi.select();
    kopi.setSelectionRange(0, 99999);
    document.execCommand("copy");
}

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
}

function saveFavCom(e, id){
    const $img = $(e).children()
    var url = `${uri}/favoritcomsupport/content/${id}`;
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function(xhr){
            xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            $('.senddataloader').show();
        },
        success: function (data) {
            $('.senddataloader').hide();
            if (typeof data.status !== "undefined") {
                if (data.status === 1) {
                    if (data.data.kondisi === 1) {
                        $img.attr('src', `${uri+'/assets/img/logo/ic_favorited.png'}`);
                    } else {
                        $img.attr('src', `${uri+'/assets/img/logo/favoriite_ic.png'}`);
                    }
                }else{
                    alert('Proses Favorite Gagal, Coba lagi');
                }
            }else{
                alert('Proses Favorite Gagal, Coba lagi');
            }
        },
        error: function (e) {
            $('.senddataloader').hide();
            alert('Proses Favorite Gagal, Coba lagi');
        },
    })
}

