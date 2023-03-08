let uri;

let page = "1";
let tahapParam = "";
let direktoratParam = "";
let divisiParam = "";
let keyParam = "";

const metas = document.getElementsByTagName("meta");
var lastpath = window.location.href.substring(
  window.location.href.lastIndexOf("/") + 1
);

for (let i = 0; i < metas.length; i++) {
  if (metas[i].getAttribute("name") === "pages") {
    uri = metas[i].getAttribute("content");
  }
}
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

$(document).ready(function () {
  $("#direktorat-lesson-init").select2({
    placeholder: "Pilih Direktorat",
  });

  $("#divisi-lesson-init").select2({
    placeholder: "Pilih Unit Kerja",
  });
});

$(document).on('click', '.pagination a', function(event){
  event.preventDefault();
  page = $(this).attr('href').split('page=')[1];
  getData(page, tahapParam, direktoratParam, divisiParam, keyParam);
});

function changeDir() {
  let valDir = $("#direktorat-lesson-init").val();
  if (valDir != "init") {
    $("#direktorat-lesson-init").on("select2:select", function (e) {
      direktoratParam = e.params.data.id.replace('&', '%26');
      cekDivisi("select", e.params.data.id);
      divisiParam = "";
      getData(1, tahapParam, direktoratParam, divisiParam, keyParam);
    });

    $("#divisi-lesson-init").on("select2:select", function (e) {
      divisiParam = e.params.data.id;
      getData(1, tahapParam, direktoratParam, divisiParam, keyParam);
    });

   } else {
    divisiParam = "";
    getData(page, tahapParam, direktoratParam, divisiParam, keyParam);
   }
}

const cekDivisi = (selOrUn, value) => {
  if ($("#divisi-lesson-init").hasClass("is-invalid") || $("#divisi-lesson-init").hasClass("is-valid")) {
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
      // $("#pag").empty();

      $("#divisi-lesson-init option").each(function() {
        $(this).remove();
      });

      $(".senddataloader").show();
    },
    success: function (data) {
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
      $('#divisi-lesson-init').append(option);
    },
    error: function (e) {
      $(".senddataloader").hide();
      alert(e);
    },
  });
};

function sortByTahap(params) {
  tahapParam = document.getElementById(params).getAttribute("data-value");
  if (tahapParam !== "init") {
    if (tahapParam === "Plan") {
      document.getElementById("btn-sort-lesson").innerHTML = "Plan";
      document.getElementById("main-title-lesson").innerHTML = "Plan";
    } else if (tahapParam === "Procurement") {
      document.getElementById("btn-sort-lesson").innerHTML = "Procurement";
      document.getElementById("main-title-lesson").innerHTML = "Procurement";
    } else if (tahapParam === "Development") {
      document.getElementById("btn-sort-lesson").innerHTML = "Development";
      document.getElementById("main-title-lesson").innerHTML = "Development";
    } else if (tahapParam === "Pilot Run") {
      document.getElementById("btn-sort-lesson").innerHTML = "Pilot Run";
      document.getElementById("main-title-lesson").innerHTML = "Pilot Run";
    } else if (tahapParam === "Implementation") {
      document.getElementById("btn-sort-lesson").innerHTML = "Implementation";
      document.getElementById("main-title-lesson").innerHTML = "Implementation";
    }
    getData(1, tahapParam, direktoratParam, divisiParam, keyParam);
  } else {
    tahapParam = "";
    getData(page, tahapParam, direktoratParam, divisiParam, keyParam);
    document.getElementById("btn-sort-lesson").innerHTML = "All Tahap Proyek";
    document.getElementById("main-title-lesson").innerHTML = "All";
  }
}

function searchLesson() {
  keyParam = document.getElementById("searchLessoninit").value;
  getData(1, tahapParam, direktoratParam, divisiParam, keyParam);
}

function formatCapitalize(string) {
  return string
    .split("")
    .map((e, i) => (i === 0 ? e.toUpperCase() : e.toLowerCase()))
    .join("");
}

function toKatalogD(t) {
    localStorage.removeItem("fil_thn");
    localStorage.removeItem("fil_div");
    localStorage.removeItem("fil_kon");
    localStorage.removeItem("fil_les");
    localStorage.setItem("fil_div", t);
}

function urlSave() {
  localStorage.setItem("url", "/managelesson/review")
}

function getData(page, tahap, direktorat, divisi, search = "") {
  let url = "";
  url = `${getCookie("url_be")}api/managelessonlearned?page=${page}&tahap=${tahap}&direktorat=${direktorat}&divisi=${divisi}&search=${search}`;
  console.log(url);

  $.ajax({
    url: url,
    type: "get",
    beforeSend: function (xhr) {
      xhr.setRequestHeader("Authorization", "Bearer " + getCookie("token"));
      $(".senddataloader").show();
      $("#pag").empty();
    },
    success: function (data) {
      $(".senddataloader").hide();
      $("#container-review").html("");
      let namaLesson = "";
      let namaTahap = "";
      let descLesson = "";
      if (data.data.data.total !== 0) {
        $("#pag").append(data.data.data.paginate);
        for (let i = 0; i < data.data.data.total; i++) {
          if (data.data.data[i].lesson_learned.length !== 0 ||  data.data.data[i].consultant.length !== 0 ) {
            $("#container-review").append(`
              <div class="card card-lesson-collapse w-100 d-flex mb-4" style="border-radius: 10px">
                <div class="row">
                  <div class="col-3">
                    <a href="${uri + "/katalog"}" class="text-primary">
                      ${data.data.data[i].divisi.direktorat}
                    </a>
                  </div>
                  <div class="col-3">
                    <a href="${uri + "/katalog"}" class="text-primary" onclick="toKatalogD(${data.data.data[i].divisi.id})">
                      ${data.data.data[i].divisi.divisi}
                    </a>
                  </div>
                  <div class="col-2">
                    <a href="${uri + "/project/" + data.data.data[i].slug}">
                      ${data.data.data[i].nama}
                    </a>
                  </div>
                  <div class="col-2">
                    <a href="${data.data.data[i].consultant[0] !== undefined
                      ? uri + "/consultant/" + data.data.data[i].consultant[0].id
                      : '/#'
                    }">
                      ${data.data.data[i].consultant[0] !== undefined ? data.data.data[i].consultant[0].nama : 'Internal'}
                    </a>
                  </div>
                  <div class="col-2">
                    <a href="${uri+ '/kontribusi/'+data.data.data[i].slug}" onclick="urlSave()" class="btn btn-outline-secondary fas fa-pen"></a>
                    <button class="btn btn-outline-secondary fas fa-caret-down" data-toggle="collapse"
                      href="#collapse${data.data.data[i].id}" aria-expanded="false" 
                      aria-controls="collapse${data.data.data[i].id}">
                    </button>
                  </div>
                </div>

                <div class="collapse" id="collapse${data.data.data[i].id}">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-3">
                        <h6>Lesson Learned</h6>
                      </div>
                      <div class="col-3">
                        <h6>Tahap Proyek</h6>
                      </div>
                      <div class="col-6">
                        <h6>Keterangan</h6>
                      </div>
                    </div>
                    <hr/>

                    <div id="container-learned${data.data.data[i].id}">
                    </div>
                  </div>
                </div>

              </div>
            `);

		        for (let ilesson = 0; ilesson < data.data.data[i].lesson_learned.length; ilesson++) {
              namaLesson = data.data.data[i].lesson_learned[ilesson].lesson_learned;
              namaTahap = data.data.data[i].lesson_learned[ilesson].tahap;
              descLesson = data.data.data[i].lesson_learned[ilesson].detail;

              if (tahap == 0) {
			          $(`#container-learned${data.data.data[i].id}`).append(`
		    	        <div class="row">
                    <div class="col-3">
                      <p>${namaLesson}</p>
                    </div>
                    <div class="col-3">
                      <p>${namaTahap}</p>
                    </div>
                    <div class="col-6">
                      <p>${descLesson}</p>
                    </div>
                  </div>
			            <hr/>
		            `);
		          }

		          if (namaTahap === tahap) {
		    	      $(`#container-learned${data.data.data[i].id}`).append(`
		    	        <div class="row">
                    <div class="col-3">
                      <p>${namaLesson}</p>
                    </div>
                    <div class="col-3">
                      <p>${namaTahap}</p>
                    </div>
                    <div class="col-6">
                      <p>${descLesson}</p>
                    </div>
                  </div>
			            <hr/>
		    	      `);
		          }
		        }
          }
        }
      } else {
      	$("#container-review").append(`
	        <div class="p-2 w-100 pt-5 text-center">
		        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content;" />
            <h5 class="font-weight-bold mt-5 mb-1">Oops.. Content tidak ditemukan</h5>
		        <p class="w-100 text-center font-weight-bold">Coba cari content lain</p>
          </div>
	      `);
      }
    },
    error: function (e) {
      alert(e);
    },
  });
}

getData(page, tahapParam, direktoratParam, divisiParam, keyParam);
