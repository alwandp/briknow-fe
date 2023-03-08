var csrf = '';
var uri = '';
var BE = '';
var search  = '*';
var page    = 1;
var sklt = `<div class="col-md-12 sklt mt-2"><div class="ph-item border control list-forum mb-2"><div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3"><div class="ph-picture w-100"></div></div><div class="content-forum-area"><div class="ph-row h-100"><div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div><div class="ph-col-4 h-25 mb-2 thumb-lg"></div><div class="ph-col-12 big"></div><div class="ph-col-8"></div><div class="ph-col-6"></div></div></div><div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg"><div class="ph-picture w-50 h-100"></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-forum mb-2"><div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3"><div class="ph-picture w-100"></div></div><div class="content-forum-area"><div class="ph-row h-100"><div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div><div class="ph-col-4 h-25 mb-2 thumb-lg"></div><div class="ph-col-12 big"></div><div class="ph-col-8"></div><div class="ph-col-6"></div></div></div><div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg"><div class="ph-picture w-50 h-100"></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-forum mb-2"><div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3"><div class="ph-picture w-100"></div></div><div class="content-forum-area"><div class="ph-row h-100"><div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div><div class="ph-col-4 h-25 mb-2 thumb-lg"></div><div class="ph-col-12 big"></div><div class="ph-col-8"></div><div class="ph-col-6"></div></div></div><div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg"><div class="ph-picture w-50 h-100"></div></div></div></div><div class="col-md-12 sklt mt-2"><div class="ph-item border control list-forum mb-2"><div class="ph-col-12 mb-0 d-flex h-50 align-items-center thumb-sm mb-3"><div class="ph-picture w-100"></div></div><div class="content-forum-area"><div class="ph-row h-100"><div class="ph-circle h-25 mx-1 rounded-circle mb-2 thumb-lg"></div><div class="ph-col-4 h-25 mb-2 thumb-lg"></div><div class="ph-col-12 big"></div><div class="ph-col-8"></div><div class="ph-col-6"></div></div></div><div class="ph-col-4 mb-0 d-flex h-100 align-items-center thumb-lg"><div class="ph-picture w-50 h-100"></div></div></div></div>`;

// meta url
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }
    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
    if (metas[i].getAttribute('name') === "BE") {
        BE = metas[i].getAttribute('content');
    }
}

//toast
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

function hapus(a){
    let t = csrf;
    swal.fire({ title: "Yakin Ingin Menghapusnya?", text: "", icon: "warning", showCancelButton: !0, confirmButtonColor: "#3085d6", cancelButtonColor: "#d33", confirmButtonText: "Ya", cancelButtonText: "Tidak" }).then((i) => {
        if(i.isConfirmed){
            $.ajax({
                url: uri+"/forum/destroy"+"/"+ a,
                type: "post",
                data: { _method: "DELETE"},
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-TOKEN",csrf);
                    $('.senddataloader').show();
                },
                success: function () {
                    $('.senddataloader').hide();
                    swal.fire({ title: "Forum Berhasil Di Hapus!", text: "", icon: "success",confirmButtonColor: "#3085d6", confirmButtonText: "Ok"}).then((i) => {
                        if(i.isConfirmed){
                            location.reload();
                        }else{
                            location.reload();
                        }});
                },
                error: function () {
                    $('.senddataloader').hide();
                    Swal.fire({ icon: "error", title: "Oops...", text: "Forum Gagal Di Hapus!" });
                },
            })
        }else{
        }
    });
};

function copyToClipboardFF(text) {
  window.prompt ("Copy to clipboard: Ctrl C, Enter", text);
}

function kopas(temp) {
  var success   = true,
      range     = document.createRange(),
      selection;

  // For IE.
  if (window.clipboardData) {
    window.clipboardData.setData("Text", temp);        
  } else {
    // Create a temporary element off screen.
    var tmpElem = $('<div>');
    tmpElem.css({
      position: "absolute",
      left:     "-1000px",
      top:      "-1000px",
    });
    // Add the input value to the temp element.
    tmpElem.text(temp);
    $("body").append(tmpElem);
    // Select temp element.
    range.selectNodeContents(tmpElem.get(0));
    selection = window.getSelection ();
    selection.removeAllRanges ();
    selection.addRange (range);
    // Lets copy.
    try { 
      success = document.execCommand ("copy", false, null);
    }
    catch (e) {
      copyToClipboardFF(temp);
    }
    if (success) {
      // remove temp element.
      Toast2.fire({icon: 'info',title: 'Link Has Been Copied !!'});
      tmpElem.remove();
    }
  }
}

$("#search").submit(function(e){
  if (!e.isDefaultPrevented()){
      var tampung = e.target[0].value;
      page = 1;
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
  var url = `${uri}/forum/getDataList/${search}?page=${page}`;
  $.ajax({
      url: url,
      headers: {
          "Accept"        :   "application/json",
          "X-CSRF-TOKEN"  :   csrf
      },
      type: "get",
      beforeSend: function()
      {
          $('.forum-content').empty();
          $('.forum-content').append(sklt);
          $('#pag').empty();
      },
      success: function(data){
          if(data.data.html == "" || data.data.html == null){
                $('.sklt').fadeOut().remove();
              return;
          }
          $('.sklt').fadeOut().remove();
          // innert html
          $(".forum-content").append(data.data.html);
          $("#pag").append(data.data.paginate);
      },
      error : function(xhr, status, error){
          console.log(xhr.responseText);
          console.log(error.Message);
            Toast2.fire({icon: 'error',title: 'Get Forum Failed'});
          // alert(e);
          $('.senddataloader').hide();
      }
  });
}

getdatalist();  