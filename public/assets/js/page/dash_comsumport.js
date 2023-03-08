let selections = [];
var csrf;
let urlBE = "";
var uri;

const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "pages") {
        uri = metas[i].getAttribute('content');
    }

    if (metas[i].getAttribute('name') === "csrf") {
        csrf = metas[i].getAttribute('content');
    }
}

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

getDataInitiative()
getDataStrategic()
getDataImpl()
function getDataInitiative() {
    const url = `${getCookie('url_be')}api/dashboard/initiative`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + getCookie('token'));
            $('.senddataloader').show();
            $('#prev').empty();
        },
        success: function(data) {
            $('.senddataloader').hide();
            if (data.data.length !== 0){
                for (let index=0; index < data.data.length; index++){
                    if (data.data[index].tipe === 'article'){
                        $('#container-article').empty();
                        $("#container-article").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-article').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsArticle" aria-expanded="false"
                                        aria-controls="collapsArticle"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                            $("#most-view-article").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/article?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                            $("#vertical-initiative").append(`
                            <div class="vertical"></div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].downloads_most[indexDownload].downloads > 0){
                            $("#most-download-article").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/article?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-download">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)}
                        }
                    }else if(data.data[index].tipe === 'video'){
                        $('#container-video').empty();
                        $("#container-video").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-video').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsVideo" aria-expanded="false"
                                        aria-controls="collapsVideo"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                            $("#most-view-video").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/video?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].downloads_most[indexDownload].downloads === 0){
				continue;
			    }
                            $("#most-download-video").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/video?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-download">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }else if(data.data[index].tipe === 'instagram'){
                        $('#container-ig').empty();
                        $("#container-ig").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-ig').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsIg" aria-expanded="false"
                                        aria-controls="collapsIg"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                             $("#most-view-ig").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/instagram?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].downloads_most[indexDownload].downloads === 0){
				continue;
			    }
                            $("#most-download-ig").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/instagram?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-download">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }else if(data.data[index].tipe === 'podcast'){
                        $('#container-podcast').empty();
                        $("#container-podcast").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-podcast').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsPodcast" aria-expanded="false"
                                        aria-controls="collapsPodcast"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                            $("#most-view-podcast").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/podcast?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].download_most[indexDownload].download === 0){
				continue;
			    }
                            $("#most-download-podcast").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/podcast?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-downloaad">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }else if(data.data[index].tipe === 'poster'){
                        $('#container-poster').empty();
                        $("#container-poster").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-poster').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsPoster" aria-expanded="false"
                                        aria-controls="collapsPoster"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                            $("#most-view-poster").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/poster?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].download_most[indexDownload].download === 0){
				continue;
			    }
                            $("#most-download-poster").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/poster?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-downloaad">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }else if(data.data[index].tipe === 'infographics'){
                        $('#container-info').empty();
                        $("#container-info").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-info').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsInfo" aria-expanded="false"
                                        aria-controls="collapsInfo"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                            $("#most-view-info").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/infographics?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].downloads_most[indexDownload].downloads === 0){
				continue;
			    }
                            $("#most-download-info").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/infographics?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-download">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }else if(data.data[index].tipe === 'transformation'){
                        $('#container-trans').empty();
                        $("#container-trans").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-trans').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsTrans" aria-expanded="false"
                                        aria-controls="collapsTrans"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views === 0){
				continue;
			    }
                            $("#most-view-trans").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/transformation?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].download_most[indexDownload].download === 0){
				continue;
			    }
                            $("#most-download-trans").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/transformation?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-download">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }else if(data.data[index].tipe === 'logo'){
                        $('#container-logo').empty();
                        $("#container-logo").append(`<p>${data.data[index].search} Pencarian</p>`);
                        $('#button-init-logo').append(`<button class="btn  fas fa-caret-down" data-toggle="collapse"
                                        data-target="#collapsLogo" aria-expanded="false"
                                        aria-controls="collapsLogo"></button>`)
                        for (let indexview=0; indexview < data.data[index].views_most.length; indexview++){
			    if (data.data[index].views_most[indexview].views !== 0){
                            $("#most-view-logo").append(`
                            <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].views_most[indexview].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/logo?slug='+data.data[index].views_most[indexview].slug}" class="p-2 align-items-center">${data.data[index].views_most[indexview].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].views_most[indexview].views}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)}
                        }
                        for (let indexDownload=0; indexDownload < data.data[index].downloads_most.length; indexDownload++){
			    if (data.data[index].downloads_most[indexDownload].downloads === 0){
				continue;
			    }
                            $("#most-download-logo").append(`
                            <div class="row d-flex justify-content-between mr-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                 src="${uri+'/storage/'+data.data[index].downloads_most[indexDownload].thumbnail}"
                                                 alt="Card image cap">
                                            <a href="${uri+ '/mycomsupport/initiative/logo?slug='+data.data[index].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].downloads_most[indexDownload].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-download">
                                                    <span>${data.data[index].downloads_most[indexDownload].downloads}</span>
                                                </div>
                                            </div>
                                        </div>
                            `)
                        }
                    }
                }
            }
        },
        error : function(e){
            alert(e);
        }
    })
}
function getDataStrategic() {
    const url = `${getCookie('url_be')}api/dashboard/strategic`
    console.log(url);
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + getCookie('token'));
            $('.senddataloader').show();
            $('#prev').empty();
        },
        success: function(data) {
            $('.senddataloader').hide();
            if (data.data.length !== 0) {
                for (let index=0; index < data.data.length; index++){
                    $('#container-name-strategic').append(`
                            <div class="row d-flex justify-content-between">
                                <div class="p-2">
                                    <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">${index+1}</p>
                                </div>
                                <div class="mr-auto p-2">
                                    <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">${data.data[index].nama}</p>
                                </div>
                                <div class="p-2">
                                    <p>${data.data[index].search_total+' Pencarian'}</p>
                                </div>
                                <div class="p-2">
                                    <button class="btn fas fa-caret-down" data-toggle="collapse"
                                            data-target="#collapse${data.data[index].id}" aria-expanded="false"
                                            aria-controls="collapse${data.data[index].id}"></button>
                                </div>
                            </div>
                            <div id="collapse${data.data[index].id}">
                            </div>`)
                    for (let iStrategic=0; iStrategic < data.data[index].strategic.length; iStrategic++){
                        $('#collapse'+data.data[index].id).append(`
                        <div class="collapse p-3" id="collapse${data.data[index].id}">
                                    <div id="container-type-strategic" class="row d-flex justify-content-between">
                                        <div class="p-2">
                                            <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">${iStrategic+1}</p>
                                        </div>
                                        <div class="mr-auto p-2">
                                            <p class="font-weight-bold" style="font-size: medium; color: #0b2e13">${data.data[index].strategic[iStrategic].tipe}</p>
                                        </div>
                                        <div class="p-2">
                                            <p>${data.data[index].strategic[iStrategic].search+' Pencarian'}</p>
                                        </div>
                                        <div class="p-2">
                                            <button class="btn  fas fa-caret-down" data-toggle="collapse"
                                                    data-target="#collaps${data.data[index].id+data.data[index].strategic[iStrategic].tipe}" aria-expanded="false"
                                                    aria-controls="collaps${data.data[index].id+data.data[index].strategic[iStrategic].tipe}"></button>
                                        </div>
                                    </div>

                                    <div class="collapse" id="collaps${data.data[index].id+data.data[index].strategic[iStrategic].tipe}">
                                        <div class="row justify-content-start">
                                            <div class="col-5">
                                                <p style="font-size: medium; color: #0b2e13">View Terbanyak</p>
                                            </div>
                                            <div class="col-2 d-flex justify-content-center">
                                                <div class="vertical"></div>
                                            </div>
                                            <div class="col-5">
                                                <p style="font-size: medium; color: #0b2e13">Download Terbanyak</p>
                                            </div>
                                        </div>
                                        <div id="content${data.data[index].id+data.data[index].strategic[iStrategic].tipe}">
					    <div class="row justify-content-start">
						<div class="col-5">
						    <div id="contentView${data.data[index].id+data.data[index].strategic[iStrategic].tipe}">
						    </div>
						</div>
					    	<div class="col-2 d-flex justify-content-center">
						    <div class="vertical"></div>
					    	</div>
				  	    	<div class="col-5">
						    <div id="contentDownload${data.data[index].id+data.data[index].strategic[iStrategic].tipe}">
						    </div>
					    	</div>
					    </div>
                                        </div>
                                    </div>
                                    <hr/>
                                </div>`)

                        for (let imostView=0; imostView < data.data[index].strategic[iStrategic].views_most.length; imostView++){
			    if (data.data[index].strategic[iStrategic].views_most[imostView].views === 0){
				continue;
			    }
                            $('#contentView'+data.data[index].id+data.data[index].strategic[iStrategic].tipe).append(`
                                        <div class="row d-flex justify-content-between ml-3">
                                            <img class="card-img p-2" style="height: auto; width: 4rem"
                                                src="${uri+'/storage/'+data.data[index].strategic[iStrategic].views_most[imostView].thumbnail}"
                                                alt="Card image cap" />
                                            <a href="${uri+ '/mycomsupport/initiative/article?slug='+data.data[index].strategic[iStrategic].views_most[imostView].slug}" class="p-2 align-items-center">${data.data[index].strategic[iStrategic].views_most[imostView].title}</a>
                                            <div class="ml-auto p-2 align-items-center">
                                                <div class="fa fas fa-eye">
                                                    <span>${data.data[index].strategic[iStrategic].views_most[imostView].views}</span>
                                                </div>
					    </div>
                                        </div>
			    `)
			}

			for (let indexDownload = 0; indexDownload < data.data[index].strategic[iStrategic].downloads_most.length; indexDownload++) {
			    if (data.data[index].strategic[iStrategic].downloads_most[indexDownload].downloads === 0){
				continue;
			    }
			    $('#contentDownload'+data.data[index].id+data.data[index].strategic[iStrategic].tipe).append(`
                                            <div class="row d-flex justify-content-between mr-3">
                                                <img class="card-img p-2" style="height: auto; width: 4rem"
                                                    src="${uri+'/storage/'+data.data[index].strategic[iStrategic].downloads_most[indexDownload].thumbnail}"
                                                    alt="Card image cap">
                                                <a href="${uri+ '/mycomsupport/initiative/article?slug='+data.data[index].strategic[iStrategic].downloads_most[indexDownload].slug}" class="p-2 align-items-center">${data.data[index].strategic[iStrategic].downloads_most[indexDownload].title}</a>
                                                <div class="ml-auto p-2 align-items-center">
                                                    <div class="fa fas fa-download">
                                                	<span>${data.data[index].strategic[iStrategic].downloads_most[indexDownload].downloads}</span>
                                                    </div>
                                                </div>
                                            </div>
                            `)
                        }
                    }
                }
            }
        }
    })
}
function getDataImpl(){
    const url = `${getCookie('url_be')}api/dashboard/implementation`
    $.ajax({
        url: url,
        type: "get",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + getCookie('token'));
            $('.senddataloader').show();
            $('#prev').empty();
        },
        success: function (data) {
            $('.senddataloader').hide();
            if (data.data.length !== 0) {
                for (let index = 0; index < data.data.length; index++) {
                    if (data.data[index].tipe === 'piloting'){
                        $('#imp-search-piloting').append(`
                        <p>${data.data[index].search_total+' Pencarian'}</p>`)
                        for (let iroll=0; iroll < data.data[index].search_most.length; iroll++){
			    if (data.data[index].search_most[iroll].views !== 0){
                            $(`#collapsImplementPilot`).append(`<div class="row d-flex justify-content-between">
                                <div class="col-6">
                                    <a href="${uri+ '/view/implementation/'+data.data[index].search_most[iroll].slug}" style="font-size: medium; color: #0b2e13">${iroll+1+'. '+data.data[index].search_most[iroll].title}</a>
                                </div>
                                <div class="col-2 align-items-end">
                                    <p style="font-size: medium; color: #0b2e13">${data.data[index].search_most[iroll].views+' Pencarian'}</p>
                                </div>
                            </div>`)
                        }}
                    }else if (data.data[index].tipe === 'sosialisasi'){
                        $('#imp-search-sosialisasi').append(`
                        <p>${data.data[index].search_total+' Pencarian'}</p>`)
                        for (let iroll=0; iroll < data.data[index].search_most.length; iroll++){
			    if (data.data[index].search_most[iroll].views === 0){
				continue;
			    }
                            $(`#collapsImplementSosialisasi`).append(`<div class="row d-flex justify-content-between">
                                <div class="col-6">
                                    <a href="${uri+ '/view/implementation/'+data.data[index].search_most[iroll].slug}" style="font-size: medium; color: #0b2e13">${iroll+1+'. '+data.data[index].search_most[iroll].title}</a>
                                </div>
                                <div class="col-2 align-items-end">
                                    <p style="font-size: medium; color: #0b2e13">${data.data[index].search_most[iroll].views+' Pencarian'}</p>
                                </div>
                            </div>`)
                        }
                    }else if (data.data[index].tipe === 'rollout'){
                        $('#imp-search-roll').append(`
                        <p>${data.data[index].search_total+' Pencarian'}</p>`)
                        for (let iroll=0; iroll < data.data[index].search_most.length; iroll++){
			    if (data.data[index].search_most[iroll].views === 0){
				continue;
			    }	
                            $(`#collapsImplementRoll`).append(`<div class="row d-flex justify-content-between">
                                <div class="col-6">
                                    <a href="${uri+ '/view/implementation/'+data.data[index].search_most[iroll].slug}" style="font-size: medium; color: #0b2e13">${iroll+1+'. '+data.data[index].search_most[iroll].title}</a>                        
                                </div>
                                <div class="col-2 align-items-end">
                                    <p style="font-size: medium; color: #0b2e13">${data.data[index].search_most[iroll].views+' Pencarian'}</p>
                                </div>
                            </div>`)
                        }
                    }
                }
            }
        }
    })
}
