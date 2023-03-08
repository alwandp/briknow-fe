<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <p>
                    <b>Pengunjung hari ini</b>
                </p>
                <h4>
                    <div>
                        <i style="font-size: 2rem;" class="fas fa-user-friends fa-lg"></i>
                        120.319
                    </div>
                </h4>
            </div>
            <div>
                <button type="button" class="btn btn-light">Download</button>
                <p class="text-right mt-3 mr-3">{{ date('M Y', strtotime(now())) }}
                </p>
            </div>
        </div>
        <div class="px-0 py-0 mx-0 my-0">
            <canvas id="myChart" width="900" height="400"></canvas>
        </div>
    </div>
</div>