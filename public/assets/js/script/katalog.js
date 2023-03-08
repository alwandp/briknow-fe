let uri;
let sort = '';
let csrf = '';
let page = '1';
//  divisi
let filter_divisi = [];
filter_divisi = localStorage.getItem('fil_div') ?? [];
console.log(`filter_divisi : ${filter_divisi}`);
if (filter_divisi === "" || typeof (filter_divisi) === null) {
  filter_divisi = [];
} else {
  try {
    filter_divisi = filter_divisi.split(',') === [""] ? [] : filter_divisi.split(',');
  } catch (error) {
    filter_divisi = [];
  }
}
if (filter_divisi.length > 0) {
  for (let index = 0; index < filter_divisi.length; index++) {
    $(`.fil_div[value="${filter_divisi[index]}"]`).prop('checked', true);
    $(`.fil_div_d[value="${filter_divisi[index]}"]`).prop('checked', true);
  }
}

//  konsultan
let filter_konsultant = [];
filter_konsultant = localStorage.getItem('fil_kon') ?? [];
console.log(`filter_konsultant : ${filter_konsultant}`);
if (filter_konsultant === "" || typeof (filter_konsultant) === null) {
  filter_konsultant = [];
} else {
  try {
    filter_konsultant = filter_konsultant.split(',') === [""] ? [] : filter_konsultant.split(',');
  } catch (error) {
    filter_konsultant = [];
  }
}
if (filter_konsultant.length > 0) {
  for (let index = 0; index < filter_konsultant.length; index++) {
    $(`.fil_kon[value="${filter_konsultant[index]}"]`).prop('checked', true);
    $(`.fil_kon_d[value="${filter_konsultant[index]}"]`).prop('checked', true);
  }
}

//  Tahun
let filter_tahun = [];
filter_tahun = localStorage.getItem('fil_thn') ?? [];
console.log(`filter_tahun : ${filter_tahun}`);
if (filter_tahun === "") {
  filter_tahun = [];
} else {
  try {
    filter_tahun = filter_tahun.split(',') === [""] ? [] : filter_tahun.split(',');
  } catch (error) {
    filter_tahun = [];
  }
}
if (filter_tahun.length > 0) {
  for (let index = 0; index < filter_tahun.length; index++) {
    $(`.fil_thn[value="${filter_tahun[index]}"]`).prop('checked', true);
    $(`.fil_thn_d[value="${filter_tahun[index]}"]`).prop('checked', true);
  }
}
// console.log(`filter Tahun : ${filter_tahun}`);

//  Lesson learne
let filter_lessonlearn = [];
filter_lessonlearn = localStorage.getItem('fil_les') ?? [];
console.log(`filter_lessonlearn : ${filter_lessonlearn}`);
if (filter_lessonlearn === "" || typeof (filter_lessonlearn) === null) {
  filter_lessonlearn = [];
} else {
  try {
    filter_lessonlearn = filter_lessonlearn.split(',') === [""] ? [] : filter_lessonlearn.split(',');
  } catch (error) {
    filter_lessonlearn = [];
  }
}
if (filter_lessonlearn.length > 0) {
  for (let index = 0; index < filter_lessonlearn.length; index++) {
    $(`.fil_les[value="${filter_lessonlearn[index]}"]`).prop('checked', true);
    $(`.fil_les_d[value="${filter_lessonlearn[index]}"]`).prop('checked', true);
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
      search = `*${search}*`;
    }
  }

  if (metas[i].getAttribute('name') === "csrf") {
    csrf = metas[i].getAttribute('content');
  }
}

// filter
let centang = `<svg class="w-6 h-6 mr-2 centang float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
let centang2 = `<svg class="w-6 h-6 mr-2 centang2 float-right" width="20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;

// Logic Ascending
$("#az").click(function (e) {
  from = 0;
  all = 0;
  data_inpage = 0;
  page_active = 0;
  $('.centang2').remove();
  if (sort == 'asc') {
    sort = '';
  } else {
    sort = 'asc';
    $('#az').append(centang2);
  }
  getData(page);
});
$("#za").click(function (e) {
  from = 0;
  all = 0;
  data_inpage = 0;
  page_active = 0;
  $('.centang2').remove();
  if (sort == 'desc') {
    sort = '';
  } else {
    sort = 'desc';
    $('#za').append(centang2);
  }
  getData(page);
});

$(document).on('click', '.pagination a', function (event) {
  event.preventDefault();
  page = $(this).attr('href').split('page=')[1];
  getData(page);
});

function searchProject() {
  let keyParams = $("#search-form").val()
  localStorage.removeItem("key_search");

  if (keyParams.length > 0) {
    localStorage.setItem("key_search", keyParams);
  } else {
    localStorage.setItem("key_search", '');
  }
  getData(page)
}

// filter
// divisi
$(".fil_div_d").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_divisi.push(e.target.value);
    $(`.fil_div[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_div_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_divisi.indexOf(e.target.value);
    if (index > -1) {
      filter_divisi.splice(index, 1);
    }
    $(`.fil_div[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_div_d[value="${e.target.value}"]`).prop('checked', false);
  }
  localStorage.setItem("fil_div", []);
  localStorage.setItem("fil_div", filter_divisi);
  getData(page);
})

$(".fil_div").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_divisi.push(e.target.value);
    $(`.fil_div[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_div_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_divisi.indexOf(e.target.value);
    if (index > -1) {
      filter_divisi.splice(index, 1);
    }
    $(`.fil_div[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_div_d[value="${e.target.value}"]`).prop('checked', false);
  }
})

$(".fil-div-res").click(function (e) {
  $('.fil_div').prop('checked', false);
  $('.fil_div_d').prop('checked', false);
  localStorage.setItem("fil_div", []);
  filter_divisi = [];
  getData(page);
})

$(".fil-div-app").click(function (e) {
  localStorage.setItem("fil_div", []);
  localStorage.setItem("fil_div", filter_divisi);
  getData(page);
})
// consultant
$(".fil_kon_d").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_konsultant.push(e.target.value);
    $(`.fil_kon[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_konsultant.indexOf(e.target.value);
    if (index > -1) {
      filter_konsultant.splice(index, 1);
    }
    $(`.fil_kon[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked', false);
  }
  localStorage.setItem("fil_kon", []);
  localStorage.setItem("fil_kon", filter_konsultant);
  getData(page);
})

$(".fil_kon").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_konsultant.push(e.target.value);
    $(`.fil_kon[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_konsultant.indexOf(e.target.value);
    if (index > -1) {
      filter_konsultant.splice(index, 1);
    }
    $(`.fil_kon[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_kon_d[value="${e.target.value}"]`).prop('checked', false);
  }
})

$(".fil-kon-res").click(function (e) {
  $('.fil_kon').prop('checked', false);
  $('.fil_kon_d').prop('checked', false);
  localStorage.setItem("fil_kon", []);
  filter_konsultant = [];
  getData(page);
})

$(".fil-kon-app").click(function (e) {
  localStorage.setItem("fil_kon", []);
  localStorage.setItem("fil_kon", filter_konsultant);
  getData(page);
})
// tahun
$(".fil_thn_d").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_tahun.push(e.target.value);
    $(`.fil_thn[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_tahun.indexOf(e.target.value);
    if (index > -1) {
      filter_tahun.splice(index, 1);
    }
    $(`.fil_thn[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked', false);
  }
  localStorage.setItem("fil_thn", []);
  localStorage.setItem("fil_thn", filter_tahun);
  getData(page);
})

$(".fil_thn").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_tahun.push(e.target.value);
    $(`.fil_thn[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_tahun.indexOf(e.target.value);
    if (index > -1) {
      filter_tahun.splice(index, 1);
    }
    $(`.fil_thn[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_thn_d[value="${e.target.value}"]`).prop('checked', false);
  }
})

$(".fil-thn-res").click(function (e) {
  $('.fil_thn').prop('checked', false);
  $('.fil_thn_d').prop('checked', false);
  localStorage.setItem("fil_thn", []);
  filter_tahun = [];
  getData(page);
})

$(".fil-thn-app").click(function (e) {
  localStorage.setItem("fil_thn", []);
  localStorage.setItem("fil_thn", filter_tahun);
  getData(page);
})
// lessonlearn
$(".fil_les_d").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_lessonlearn.push(e.target.value);
    $(`.fil_les[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_les_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_lessonlearn.indexOf(e.target.value);
    if (index > -1) {
      filter_lessonlearn.splice(index, 1);
    }
    $(`.fil_les[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_les_d[value="${e.target.value}"]`).prop('checked', false);
  }
  localStorage.setItem("fil_les", []);
  localStorage.setItem("fil_les", filter_lessonlearn);
  getData(page);
})

$(".fil_les").change(function (e) {
  if ($(this).prop('checked') == true) {
    // add item
    filter_lessonlearn.push(e.target.value);
    $(`.fil_les[value="${e.target.value}"]`).prop('checked', true);
    $(`.fil_les_d[value="${e.target.value}"]`).prop('checked', true);
  } else {
    // remove item
    const index = filter_lessonlearn.indexOf(e.target.value);
    if (index > -1) {
      filter_lessonlearn.splice(index, 1);
    }
    $(`.fil_les[value="${e.target.value}"]`).prop('checked', false);
    $(`.fil_les_d[value="${e.target.value}"]`).prop('checked', false);
  }
})

$(".fil-les-res").click(function (e) {
  $('.fil_les').prop('checked', false);
  $('.fil_les_d').prop('checked', false);
  localStorage.setItem("fil_les", []);
  filter_lessonlearn = [];
  getData(page);
})

$(".fil-les-app").click(function (e) {
  localStorage.setItem("fil_les", []);
  localStorage.setItem("fil_les", filter_lessonlearn);
  getData(page);
})

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
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

// get data
const getData = (page) => {
  // filter
  let h_div = "";
  for (let index = 0; index < filter_divisi.length; index++) {
    if (h_div == "") {
      h_div = `${filter_divisi[index]}`;
    } else {
      h_div += `-${filter_divisi[index]}`;
    }
  }
  let h_kon = "";
  for (let index = 0; index < filter_konsultant.length; index++) {
    if (h_kon == "") {
      h_kon = `${filter_konsultant[index]}`;
    } else {
      h_kon += `-${filter_konsultant[index]}`;
    }
  }
  let h_thn = "";
  for (let index = 0; index < filter_tahun.length; index++) {
    if (h_thn == "") {
      h_thn = `${filter_tahun[index]}`;
    } else {
      h_thn += `,${filter_tahun[index]}`;
    }
  }
  let h_les = "";
  for (let index = 0; index < filter_lessonlearn.length; index++) {
    if (h_les == "") {
      h_les = `${filter_lessonlearn[index]}`;
    } else {
      h_les += `-${filter_lessonlearn[index]}`;
    }
  }

  let key_search = localStorage.getItem('key_search') || '';

  let url;
  url = `${getCookie('url_be')}api/kat?page=${page}&search=${key_search}&tahap=${h_les}&divisi=${h_div}&consultant=${h_kon}&sort=${sort}&tahun=${h_thn}`;
  console.log(url);
  // &tahun=${h_thn}&lesson=${h_les}

  $.ajax({
    url: url,
    type: "get",
    beforeSend: function (xhr) {
      xhr.setRequestHeader("Authorization", "Bearer " + getCookie('token'));
      $('.senddataloader').show();
      $("#pag").empty();
    },
    success: function (data) {
      $('.senddataloader').hide();
      $("#result").html("");
      if (data.data.data.total !== 0) {
        $("#pag").append(data.data.data.paginate);
        for (let i = 0; i < data.data.data.total; i++) {
          let cons = data.data.data[i].consultant;
          let con = cons.map((con) => con.nama).join(', ');
          let namaKonsultan = con.substring(0, 40);
          if (con.length > 40) {
            namaKonsultan += '...';
          }
          let namaProject = data.data.data[i].nama.substring(0, 40);
          if (data.data.data[i].nama.length > 40) {
            namaProject += '...';
          }
          $("#result").append(`
            <div class="col-lg-6 col-sm-12 data">
              <a href="${uri + '/project/' + data.data.data[i].slug}" class="text-decoration-none">
                <div class="card border control list-project mb-2">
                  <div class="row px-3">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-center thumb-katalog">
                      <div class="row d-flex justify-content-center">
                        <img src="${uri + '/storage/' + data.data.data[i].thumbnail}" width="120%" class="card-img-left border-0 rounded thumb">
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1">
                      <div class="card-body content-project">
                        <p class="d-block text-dark header-list-project mb-1">${namaProject}</p>
                        <span>
                          ${data.data.data[i].consultant == '' ? 'Internal' : namaKonsultan}
                        </span>
                        <span class="d-block">${data.data.data[i].project_managers.nama}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          `);
        }
      } else {
        $("#result").append(`
                <div class="p-2 w-100 pt-5 text-center">
                    <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                    <h5 class="font-weight-bold mt-5 mb-1">Oops.. Project tidak ditemukan</h5>
                    <p class="w-100 text-center font-weight-bold">Coba cari project lain</p>
                </div>
                `)
      }
    },
    error: function (e) {
      alert(e);
    }
  });
}

getData(page);
