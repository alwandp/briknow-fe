<div class="navbar-bg sticky-top navbar-gray bg-gray pr-0 mr-0">
    <div class="d-flex justify-content-between header-nav">
      <div class="d-flex align-items-center pl-3">
        <button type="button" class="close d-inline bg-tranparent text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div>
          <nav class="navbar navbar-expand-lg main-navbar">
              <ul class="navbar-nav navbar-right">
                  <li class="dropdown">
                    @if(Session()->get('role') == 0)
                      <button class="btn btn-light box-shadow-none btn-sm mx-1" data-dismiss="modal" aria-label="Close"><i class="fas fa-pencil-alt mr-1"></i> Edit</button>
                      <button class="btn btn-success box-shadow-none btn-sm mx-1" id="save"><i class="fas fa-save mr-1"></i> Save</button>
                      <button class="btn btn-primary btn-sm mx-1" id="send" value="1"><i class="fas fa-paper-plane mr-1"></i> Send</button>
                    @elseif(Session()->get('role') == 3)
                      <button class="btn btn-light box-shadow-none btn-sm mx-1" data-dismiss="modal" aria-label="Close"><i class="fas fa-pencil-alt mr-1"></i> Edit</button>
                      <button class="btn btn-success box-shadow-none btn-sm mx-1" id="save"><i class="fas fa-save mr-1"></i> Save</button>
                      <button class="btn btn-primary btn-sm mx-1" id="send" value="2"><i class="fas fa-paper-plane mr-1"></i> Publish</button>
                    @endif
                  </li>
              </ul>
          </nav>
      </div>
    </div>
</div>
<div class="cardbg-white bg-white w-100 px-3 pb-5">
  <div class="row judul mt-4">
      <div class="col-md-2 col-sm-12 d-flex justify-content-center mb-2">
          <img src="{{asset_app('assets/img/boxdefault.svg')}}" alt="" id="prev_thumbnail" class="img-detail">
      </div>
      <div class="col-md-10 col-sm-12 pr-0 header-detail">
        <div class="row mt-4">
          <div class="col-md-8 col-sm-12 mb-2">
            <div class="col-sm-12 px-0">
              <h2 class="d-block" id="prev_namaproject">-</h2>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <span class="d-block font-weight-bold">Konsultan</span>
                <div class="w-100" id="prev_konsultant">-</div>
              </div>
              <div class="col-md-5 col-sm-6">
                <span class="d-block font-weight-bold">Project Manager</span>
                <span id="prev_pm"></span>
                <span class="d-block" id="prev_emailpm">-</span>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="row judul">
    <hr width="100%">
  </div>
  <div class="row judul">
    <div class="col-lg-3 col-md-4 col-sm-12">
      <div class="row">
        <h6 class="font-weight-bolder">Detail</h6>
      </div>
      <div class="row">
        <div class="row col-md-12 col-sm-6 col-xs-6 mt-2 pr-0">
          <div class="col-md-4 px-0">Pemilik Proyek</div>
          <div class="col-md-8 px-0 pl-3 d-min font-weight-bold" id="prev_divisi">-</div>
        </div>
        <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
          <div class="col-md-4 px-0">Tanggal Mulai</div>
          <div class="col-md-8 px-0 pl-3 d-min font-weight-bold" id="prev_tglmulai">-</div>
        </div>
        <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
          <div class="col-md-4 px-0">Tanggal Selesai</div>
          <div class="col-md-8 px-0 pl-3 d-min font-weight-bold" id="prev_tglselesai">-</div>
        </div>
        <div class="row col-md-12 col-sm-6 col-xs-6 mt-2">
          <div class="col-md-4 px-0">Status</div>
          <div class="col-md-8 px-0 pl-3 d-min font-weight-bold" id="prev_status">-</div>
        </div>
      </div>
      <div class="row mt-4">
        <h6 class="font-weight-bolder">Tags</h6>
        <div class="row col-md-12 px-3 font-weight-normal mb-4" id="prev_keyword">
          <span class="badge badge-cyan-light text-dark mr-1">-</span>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 px-0 text-justify">
      <div class="row">
        <div class="col-md-12 d-block w-100 mb-4 mt-2">
          <h6>Deskripsi</h6>
          <div class="metodologi-isi wrap" id="prev_deskripsi">-</div>
        </div>
        <div class="col-md-12 d-block w-100 mb-4 mt-2">
          <h6>Metodologi</h6>
          <div class="metodologi-isi wrap" id="prev_metodologi">-</div>
        </div>
        <div class="col-md-12 d-block w-100 mb-4 mt-2">
          <h6>Lesson Learned</h6>
          <div class="table-responsive" id="table-responsive-metodologi">
            <table class="table table-bordered">
              <thead class="text-center">
                  <th id="th-metodologi" style="min-width: 20px;">No</th>
                  <th id="th-metodologi" style="min-width: 400px;">Lesson Learned</th>
                  <th id="th-metodologi" style="min-width: 80px;">Tahap</th>
                  <th id="th-metodologi" style="min-width: 400px;">Detail Keterangan</th>
              </thead>
              <tbody class="text-center" id="prev_lessonlearned">
                <tr>
                  <td id="td-nolesson"><span>-</span></td>
                  <td id="td-lesson"><span>-</span></td>
                  <td id="td-tahap"><span>-</span></td>
                  <td id="td-deskripsi-lesson"><span>-</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 d-block w-100">
          <h6>Attachment</h6>
          <div class="card-body p-0 mt-2">
            <div class="row">
              <div class="col-md-12">
                <form action="#" class="w-100" id="search">
                  <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text search-sm attr_input">
                          <i class="fa fa-search fa-sm" aria-hidden="true"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control search-sm" placeholder="Search files..." aria-describedby="inputGroup-sizing-sm" disabled>
                  </div>
                </form>
              </div>
            </div>
            <div class="table-responsive no-radius">
              <table class="table table-sm" id="table-attachment">
                <thead>
                  <tr>
                    <th id="th-attachment">Files</th>
                    <th id="th-attachment">Type</th>
                    <th id="th-attachment">Size</th>
                  </tr>
                </thead>
                <tbody id="prev_document">
                  <tr class="rowdoc">
                    <td id="td-files" class="d-flex align-items-center">-</td>
                    <td id="td-attachment">-</td>
                    <td id="td-attachment">-</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
