// meta url
var uri;

const monthAll = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
let currentYear = new Date().getFullYear()
let currentMonth = new Date().getMonth()

let meta = document.getElementsByTagName('meta');
for (let i = 0; i < meta.length; i++) {
    if (meta[i].getAttribute('name') === "pages") {
        uri = meta[i].getAttribute('content');
    }
}

//baru getDataVisitor doang sisanya dummy blom berfungsi, dan getDataVisitor masih bug

const getDataAll = () =>{
    $.ajax({
        url: uri+"/dashboard/getalldata",
        type: "get",
        beforeSend: function()
        {
            $('.senddataloader').show();
        }
    })
    .done(function(data){
        if(data== ""){
            $('.senddataloader').hide();
            return;
        }

        $('.senddataloader').hide();
        renderChartVisitor(data);
        renderChartProjectK(data);
        renderChartProjectD(data.out.divisi);
        renderChartProjectT(data);
    })
    .fail(function(jqXHR, ajaxOptions, thrownError){
        $('.senddataloader').hide();
        alert('Server Not Responding.. , Please Refresh');
    });
}

// const getDataVisitor = () =>{
//     $.ajax({
//         url: uri+"/dashboard/getprojectvisitor",
//         type: "get",
//         beforeSend: function()
//         {
//             $('.senddataloader').show();
//         }
//     })
//     .done(function(data){
//         if(data== ""){
//             $('.senddataloader').hide();
//             return;
//         }

//         $('.senddataloader').hide();
//         renderChartVisitor(data);
//     })
//     .fail(function(jqXHR, ajaxOptions, thrownError){
//         $('.senddataloader').hide();
//         alert('Server Not Responding.. , Please Refresh');
//     });
// }
// const getDataProjectK = () =>{
//     $.ajax({
//         url: uri+"/dashboard/getprojectconsultant",
//         type: "get",
//         beforeSend: function()
//         {
//             $('.senddataloader').show();
//         }
//     })
//     .done(function(data){
//         console.log(data.out.data);
//         if(data== ""){
//             $('.senddataloader').hide();
//             return;
//         }
        
//         $('.senddataloader').hide();
//         renderChartProjectK(data);
//     })
//     .fail(function(jqXHR, ajaxOptions, thrownError){
//         $('.senddataloader').hide();
//         alert('Server Not Responding.. , Please Refresh');
//     });
// }

// const getDataProjectD = () =>{
//     $.ajax({
//         url: uri+"/dashboard/getprojectdivisi",
//         type: "get",
//         beforeSend: function()
//         {
//             $('.senddataloader').show();
//         }
//     })
//     .done(function(data){
//         if(data== ""){
//             $('.senddataloader').hide();
//             return;
//         }
        
//         $('.senddataloader').hide();
//         renderChartProjectD(data);
//     })
//     .fail(function(jqXHR, ajaxOptions, thrownError){
//         $('.senddataloader').hide();
//         alert('Server Not Responding.. , Please Refresh');
//     });
// }
// const getDataProjectT = () =>{
//     $.ajax({
//         url: uri+"/dashboard/getprojecttahun",
//         type: "get",
//         beforeSend: function()
//         {
//             $('.senddataloader').show();
//         }
//     })
//     .done(function(data){
//         if(data== ""){
//             $('.senddataloader').hide();
//             return;
//         }
        
//         $('.senddataloader').hide();
//         renderChartProjectT(data);
//     })
//     .fail(function(jqXHR, ajaxOptions, thrownError){
//         $('.senddataloader').hide();
//         alert('Server Not Responding.. , Please Refresh');
//     });
// }

const renderChartVisitor = (data) => {
    $('#chart_visitor').remove();

    if (data.out.visitor.length == 0) {
        return;
    }
    
    $('#graph_visitor').append('<div id="chart_visitor" style="height: 350px;" class="pr-4 pt-0"><div>');
    am4core.ready(function() {
        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chart_visitor", am4charts.XYChart);

        // Add data
        chart.data = data.out.visitor;
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "Riwayat Total Pengunjung"; 
        chart.exporting.timeoutDelay = 60000;
        chart.exporting.menu.items = [{
            "label": `<i class="fas fa-image m-0"></i>`,
            "menu": [
                { "type": "png", "label": "PNG" },
                { "type": "jpg", "label": "JPG" },
                { "type": "svg", "label": "SVG" },
                // { "type": "pdf", "label": "PDF" },
                // { "type": "xlsx", "label": "XLSX" },
                { "label": "Print", "type": "print" }
            ]
          }];

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.grid.template.location = 0;
        dateAxis.renderer.minGridDistance = 50;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "jumlahpengunjung";
        series.dataFields.dateX = "date";
        series.strokeWidth = 3;
        series.fillOpacity = 0.5;

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "zoomY";
        chart.cursor.lineX.disabled = true;

    }); // end am4core.ready()
}
const renderChartProjectK = (data) => {
    $('#chart_projectK').remove();

    if (data.out.consultant.length == 0) {
        return;
    }

    $('#graph_projectK').append('<div id="chart_projectK" style="height: 350px;" class="pr-4 pt-0"><div>');
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        
        var chart = am4core.create("chart_projectK", am4charts.XYChart);
        chart.scrollbarX = new am4core.Scrollbar();
        
        chart.data = data.out.consultant;
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "project per konsultant";
        chart.exporting.timeoutDelay = 60000;
        chart.exporting.menu.items = [{
            "label": `<i class="fas fa-image m-0"></i>`,
            "menu": [
                { "type": "png", "label": "PNG" },
                { "type": "jpg", "label": "JPG" },
                { "type": "svg", "label": "SVG" },
                // { "type": "pdf", "label": "PDF" },
                // { "type": "xlsx", "label": "XLSX" },
                { "label": "Print", "type": "print" }
            ]
        }];
            
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "nama_consultant";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 60;
        categoryAxis.tooltip.disabled = true;

        // truncate "..."
        var label = categoryAxis.renderer.labels.template;
        label.truncate = true;
        label.maxWidth = 150;
        label.ellipsis = "...";
        
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.maxPrecision = 0
        valueAxis.renderer.minWidth = 50;
        valueAxis.min = 0;
        valueAxis.cursorTooltipEnabled = false;
        
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.sequencedInterpolation = true;
        series.dataFields.valueY = "jumlah_project";
        series.dataFields.categoryX = "nama_consultant";
        series.dataFields.urlField= "url";
        series.dataFields.urlTarget= "_blank";
        series.tooltip.label.interactionsEnabled = true;
        series.tooltip.keepTargetHover = true;
        // series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
        series.columns.template.strokeWidth = 0;
        series.columns.template.tooltipHTML =
            `<a class="text-decoration-none" href="${uri}/katalog" target="_blank" onclick="toKatalogK({url})"><b>{categoryX} : {valueY}</b></a>`;
        // series.columns.template.tooltipHTML = '<a class="text-decoration-none" href="{urlField}" target="_blank"><b>{categoryX} : {valueY}</b></a>';

        series.tooltip.pointerOrientation = "vertical";
        
        series.columns.template.column.cornerRadiusTopLeft = 10;
        series.columns.template.column.cornerRadiusTopRight = 10;
        series.columns.template.column.fillOpacity = 0.8;
        
        // on hover, make corner radiuses bigger
        var hoverState = series.columns.template.column.states.create("hover");
        hoverState.properties.cornerRadiusTopLeft = 10;
        hoverState.properties.cornerRadiusTopRight = 10;
        hoverState.properties.fillOpacity = 2;
        
        series.columns.template.adapter.add("fill", function(fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
        })
        
        // Cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panX";

        series.columns.template.events.on("hit", function(ev) {
            localStorage.removeItem("fil_thn");
            localStorage.removeItem("fil_div");
            localStorage.removeItem("fil_kon");
	    localStorage.removeItem("fil_les");

            let source = ev.target.dataItem._dataContext;
            localStorage.setItem("fil_kon",source.url);
            open(uri+'/katalog', '_blank');
        }, this);
    }); // end am4core.ready()
}

function toKatalogK(t) {
    localStorage.removeItem("fil_thn");
    localStorage.removeItem("fil_div");
    localStorage.removeItem("fil_kon");
    localStorage.removeItem("fil_les");
    localStorage.setItem("fil_kon",t);
}
let div_short;
const renderChartProjectD = (data) => {

    $('#chart_projectD').remove();

    if (data.length === 0) {
        return;
    }

    div_short = [];
    $.each(data, function (i, div) {
        div_short[div.short] = div.nama_divisi
    })

    $('#graph_projectD').append('<div id="chart_projectD" style="height: 350px;" class="pr-4 pt-0"><div>');
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        
        var chart = am4core.create("chart_projectD", am4charts.XYChart);
        chart.scrollbarX = new am4core.Scrollbar();
        
        chart.data = data;
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.filePrefix = "project per Direktorat"; 
        chart.exporting.timeoutDelay = 60000;
        chart.exporting.menu.items = [{
            "label": `<i class="fas fa-image m-0"></i>`,
            "menu": [
                { "type": "png", "label": "PNG" },
                { "type": "jpg", "label": "JPG" },
                { "type": "svg", "label": "SVG" },
                // { "type": "pdf", "label": "PDF" },
                // { "type": "xlsx", "label": "XLSX" },
                { "label": "Print", "type": "print" }
            ]
        }];
            
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "nama_divisi";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 60;
        categoryAxis.tooltip.disabled = true;

        // truncate "..."
        var label = categoryAxis.renderer.labels.template;
        label.truncate = true;
        label.maxWidth = 150;
        label.ellipsis = "...";
        
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.maxPrecision = 0
        valueAxis.renderer.minWidth = 50;
        valueAxis.min = 0;
        valueAxis.cursorTooltipEnabled = false;
        
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.sequencedInterpolation = true;
        series.dataFields.valueY = "jumlah_project";
        series.dataFields.categoryX = "nama_divisi";
        series.dataFields.urlField= "url";
        series.dataFields.urlTarget= "_blank";
        series.tooltip.label.interactionsEnabled = true;
        series.tooltip.keepTargetHover = true;
        // series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
        series.columns.template.strokeWidth = 0;
        series.columns.template.tooltipHTML =
            `<a class="text-decoration-none" href="${uri}/katalog" target="_blank" onclick="toKatalogD({url})"><b>{categoryX} : {valueY}</b></a>`;
        
        series.tooltip.pointerOrientation = "vertical";
        
        series.columns.template.column.cornerRadiusTopLeft = 10;
        series.columns.template.column.cornerRadiusTopRight = 10;
        series.columns.template.column.fillOpacity = 0.8;
        
        // on hover, make corner radiuses bigger
        var hoverState = series.columns.template.column.states.create("hover");
        hoverState.properties.cornerRadiusTopLeft = 10;
        hoverState.properties.cornerRadiusTopRight = 10;
        hoverState.properties.fillOpacity = 2;
        
        series.columns.template.adapter.add("fill", function(fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
        })
        
        // Cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panX";

        series.columns.template.events.on("hit", function(ev) {
            localStorage.removeItem("fil_thn");
            localStorage.removeItem("fil_div");
            localStorage.removeItem("fil_kon");
	    localStorage.removeItem("fil_les");

            let source = ev.target.dataItem._dataContext;
            localStorage.setItem("fil_div",source.url);
            open(uri+'/katalog', '_blank');
        }, this);
    }); // end am4core.ready()
}

function toKatalogD(t) {
    localStorage.removeItem("fil_thn");
    localStorage.removeItem("fil_div");
    localStorage.removeItem("fil_kon");
    localStorage.removeItem("fil_les");
    localStorage.setItem("fil_div",t);
}

const renderChartProjectT = (data) => {

    $('#chart_projectT').remove();

    if (data.out.tahun.length == 0) {
        return;
    }

    $('#graph_projectT').append('<div id="chart_projectT" style="height: 350px;" class="pr-4 pt-0"><div>');

    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create("chart_projectT", am4charts.XYChart);
    
    chart.data = data.out.tahun;

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "tahun";
    categoryAxis.numberFormatter.numberFormat = "#.";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 50;
    categoryAxis.tooltip.disabled = true;

    // truncate "..."
    var label = categoryAxis.renderer.labels.template;
    label.truncate = true;
    label.maxWidth = 140;
    label.ellipsis = "...";
    
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.maxPrecision = 0
    valueAxis.renderer.minWidth = 50;
    valueAxis.min = 0;
    valueAxis.cursorTooltipEnabled = false;
    
    // Create series
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = "jumlah_project";
    series.dataFields.categoryX = "tahun";
    series.strokeWidth = 3;
    series.fillOpacity = 0.5;
    series.tooltip.label.interactionsEnabled = true;
    series.tooltip.keepTargetHover = true;
    // series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
    series.tooltipHTML = `<a class="text-decoration-none" href="${uri}/katalog" target="_blank" onclick="toKatalogT('{categoryX}')"><b>{valueY}</b></a>`;

    // Add vertical scrollbar
    chart.scrollbarX = new am4core.Scrollbar();
    chart.scrollbarX.marginBottom = 0;
    
    // Add cursor
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.behavior = "zoomY";
    chart.cursor.lineX.disabled = true;

    series.segments.template.interactionsEnabled = true;
    series.segments.template.events.on("hit", function(ev) {
        localStorage.removeItem("fil_thn");
        localStorage.removeItem("fil_div");
        localStorage.removeItem("fil_kon");
	localStorage.removeItem("fil_les");

        let item = ev.target.dataItem.component.tooltipDataItem.dataContext;

        let month;
        if (item.tahun.toString() === currentYear.toString()) {
            month = monthAll.map(i => `${item.tahun}-` + i)
        } else {
            month = monthAll.map(i => `${item.tahun}-` + i)
        }
        localStorage.setItem("fil_thn",month.join(','));
        open(uri+'/katalog', '_blank');
    }, this);
    
    }); // end am4core.ready()
}

function toKatalogT(t) {
    localStorage.removeItem("fil_thn");
    localStorage.removeItem("fil_div");
    localStorage.removeItem("fil_kon");
    localStorage.removeItem("fil_les");
    let month;
    if (t.toString() === currentYear.toString()) {
        month = monthAll.map(i => `${t}-` + i)
    } else {
        month = monthAll.map(i => `${t}-` + i)
    }
    localStorage.setItem("fil_thn",month.join(','));
}

getDataAll();
// getDataVisitor();
// // getDataProjectK();
// // getDataProjectD();
// // getDataProjectT();
