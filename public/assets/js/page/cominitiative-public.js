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
let keywordParam = "";
let generalParam = "";
const url = document.location.href;
const urlParam = new URLSearchParams(window.location.search)
const slug = urlParam.get('slug')

localStorage.removeItem('fil_proj');
let slideIndex = 1;

const metas = document.getElementsByTagName('meta');
let lastpath = window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
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

$(document).ready(function () {

  $('#direktorat-com-init').select2({
      placeholder: 'Pilih Direktorat'
  });

  $('#divisi-com-init').select2({
      placeholder: 'Pilih Unit Kerja'
  });

  getData(pageParam, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam, generalParam);
});

$(document).on('click', '.pagination a', function(event){
    event.preventDefault();
    pageParam = $(this).attr('href').split('page=')[1];
    getData(pageParam, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam);
});
  
const cekDivisi = (selOrUn, value) => {
  if ($("#divisi-com-init").hasClass("is-invalid") || $("#divisi-com-init").hasClass("is-valid")) {
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

  let url = `${uri}/getdivisi/${value}`;
  $.ajax({
    url: url,
    type: "get",
    beforeSend: function () {
      $(".pagination").remove();

      $("#divisi-com-init option").each(function() {
        $(this).remove();
      });

      $(".senddataloader").show();
    },
    success: function (data) {
      let option = `<option value="init">All Divisi</option>`;
      if (value == "general") {
        option = `<option value="general" disabled selected>General</option>`;
      }
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
      $('#divisi-com-init').append(option);
    },
    error: function (e) {
      $(".senddataloader").hide();
      alert(e);
    },
  });
};

$("#direktorat-com-init").on("select2:select", function (e) {
  direktoratParam = e.params.data.id.replace('&', '%26');
  cekDivisi("select", e.params.data.id);
  divisiParam = "";
  getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam);
});

$("#divisi-com-init").on("select2:select", function (e) {
  divisiParam = e.params.data.id;
  getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam);
});

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
    getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam)
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
    getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam)
}

function searchCominit(){
    keywordParam = document.getElementById("searchCominit").value;
    getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam)
}

function sortingBy(params){
    sortParam = document.getElementById(params).getAttribute('data-value')
    if (sortParam !== 'init'){
        getData(1, yearParam, monthParam, direktoratParam, divisiParam, sortParam, keywordParam)
        if (sortParam === 'title'){
            document.getElementById('btn-sort-comsup').innerHTML = "Judul"
        }else if (sortParam === 'created_at'){
            document.getElementById('btn-sort-comsup').innerHTML = "Tanggal"
        }else if (sortParam === 'views'){
            document.getElementById('btn-sort-comsup').innerHTML = "View"
        }
    }else{
        getData(1, yearParam, monthParam, direktoratParam, divisiParam, '', keywordParam)
        document.getElementById('btn-sort-comsup').innerHTML = "Sort By"
    }
}

function getData(page, year, month, direktorat, divisi, sort, search = "") {
  let url = `${getCookie('url_be')}api/get/communicationinitiative/publish/${lastpath}?page=${page}&year=${year}&month=${month}&direktorat=${direktorat}&divisi=${divisi}&sort=${sort}&search=${search}`
  console.log(url);
  $.ajax({
      url: url,
      type: "get",
      beforeSend: function(xhr){
        xhr.setRequestHeader("Authorization", "Bearer "+getCookie('token'));
        $('.senddataloader').show();
        $("#card-content-cominit").empty();
        $('#prev').empty();
        $("#pag").empty();
      },
      success: function(data) {
        $('.senddataloader').hide();
        $("#card-content-cominit").html("");
        if(data.data.data.total !== 0){
          console.log(data.data.data);
          $("#pag").append(data.data.data.paginate);
          for (let index = 0; index < data.data.data.total; index++){
            $("#card-content-cominit").append(`
              <div class="col-lg-4 d-flex justify-content-center shadow-sm mb-3">
                <div class="card" style="border-radius: 16px; width: 100%;">
                  <button type="button" class="btn p-0 text-primary" onclick="openPreview(${data.data.data[index].id})">
                    <img class="card-img-up"
                      src="${uri+'/storage/'+data.data.data[index].thumbnail}"
                      alt="Card image cap" />
                  </button>
                  <div class="card-body">
                    <button type="button" class="btn p-0 text-primary" onclick="openPreview(${data.data.data[index].id})">
                      <h5 class="card-title">${data.data.data[index].title}</h5>
                    </button>
                    <div class="implementation-desc">
                      <p>${data.data.data[index].desc.substring(0,150)+'...'}</p>
                    </div>
                  </div>
                  <div class="card-footer d-flex justify-content-between">
                      <i class="mr-auto p-2 fas fa-eye mt-2">
                        <span id="view-${data.data.data[index].id}">${data.data.data[index].views}</span>
                      </i>
                      <button class="btn p-2 grey" style="font-size: 20px" onclick="download(${data.data.data[index].id})">
                        <img src="${uri+'/assets/img/logo/download_ic.png'}"/>
                      </button>
                      <button class="btn fas grey" style="font-size: 20px" data-toggle="modal" data-target="#berbagi"
                        onclick="migrasi('Eh, liat Konten ini deh. ${data.data.data[index].title} di BRIKNOW. &nbsp;${uri+"/mycomsupport/initiative/"+data.data.data[index].type_file+"?slug="+data.data.data[index].slug}')">
                        <img src="${uri+'/assets/img/logo/share_ic.png'}"/>
                      </button>
                      <button class="btn fas grey" style="font-size: 20px" onclick="saveFavCom(this, ${data.data.data[index].id})">
                        <img src="${uri+(data.data.data[index].favorite_com.length > 0 ? '/assets/img/logo/ic_favorited.png' : '/assets/img/logo/favoriite_ic.png')}"/>
                      </button>
                    </div>
                </div>
              </div>
            `);
          }

          if (slug) {
            const datas = data.data.data.find(i => i.slug === slug)
            if (datas) {
              openPreview(datas.id)
            } else {
              Toast2.fire({icon: 'error',title: 'Content tidak ditemukan!'});
              if (urlParam) {
                if (slug) {
                  window.history.pushState({}, '', url.split("?")[0]);
                }
              }
            }
          }
        } else {
          $("#card-content-cominit").append(`
            <div class="p-2 w-100 pt-5 text-center">
              <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
              <h5 class="font-weight-bold mt-5 mb-1">Oops.. Content tidak ditemukan</h5>
              <p class="w-100 text-center font-weight-bold">Coba cari content lain</p>
            </div>
          `);
        }
      },
      error : function(e){
          alert(e);
      }
  });
}

function openPreview(id) {
    const url = `${uri}/communication/views/content/${id}?public=1`
    let t = "{{$token_auth}}";
    console.log(url);

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

    if (urlParam) {
        if (slug) {
            window.history.pushState({}, '', url.split("?")[0]);

        }
    }

    $('#content-modal').empty();
})

function download(id) {
    // window.location.href = uri+`/attach/download/content/${id}`;
    console.log(window.location.href = uri+`/attach/download/content/${id}`);
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

