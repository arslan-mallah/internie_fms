 function filterDataa(){
    var start = $("#start").val();
    var end = $("#end").val();
    var category_w = document.getElementById('cat_graph3').innerHTML;
    // $('.fcRxvB').html();
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"graphss",
        type:"POST",
        data:{
            start:start,
            end:end,
            category_w:category_w,
        },

        beforeSend: function() {
            $('.fcRxvB').html('<span>Working............</span>');

        },
        success:function(data){
            var html ='';
            var btn ='';

            html +='<div class="sc-AxjAm imVUDT ml-4 mr-4 ">\
            <div data-id="metric-wrapper" class="sc-AxjAm sc-AxiKw krvuUX">\
            <span data-id="metric" id="cat_graph3" class="sc-AxhCb jXrfzm mx-4 check">'+data.cat+' </span>\
            <span data-id="metric" id="debit_graph3" class="sc-AxhCb jXrfzm mx-4">Debit: '+data.total_d+'</span>\
            <span data-id="metric" id="credit_graph3" class="sc-AxhCb jXrfzm mx-4">Credit: '+data.total_c+'</span>\
            </div>\
            <div class="sc-AxjAm sc-prOVx eopTOK ">\
            <canvas id="myChart3"></canvas>\
            </div>\
            <div class="w-75">\
                Start date:<input type="text" id="start" value="'+data.firstDate+'">\
                End date: <input type="text" id="end" value="'+data.lastDate+'">\
                <button class="btn btn-primary mx-2" onclick="filterDataa()">Filter</button>\
                <button class="btn btn-danger mx-2" onclick="resetDataa()">Reset</button>\
            </div>\
            </div>';

    btn +='<button type="submit" onclick="debit8()" name="t_debit" id="t_debit"  class="btn btn-primary mx-2 active">Bar chart</button>\
    <button type="submit" onclick="credit8()" name="t_credit" id="t_credit" class="btn btn-warning">Line chart</button>\
    ';

            $('#btn').html(btn);
            $('.fcRxvB').html(html);
            $('#start').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day == 0];
                }
            });
            $('#end').datepicker({
                dateFormat: 'yy-mm-dd',
            
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day == 0];
                }
            });
            
            var type4 =data.type4;
            var expenses3 = data.expenses4;
            var revenue3 = data.revenue4;
            
             
                // 
///////////////start config////////////////


var dates = type4;
var datapoints1 = expenses3;
var datapoints2 = revenue3;
var convertedDates = dates.map(date => new Date(date).setHours(0, 0, 0, 0));
var data = {
    labels: dates,
    datasets: [{

            label: 'Debit by week',
            data: datapoints1,
            backgroundColor: 'rgba(128,0,128,1)',
            borderColor: 'rgba(25,25,25,1)',
            borderRadius: 10,
            borderWidth: 1,
            tension: 0.6,

            pointHoverBorderColor: 'white',
            pointHoverBackgroundColor: 'rgba(25,25,25,1)',
            pointBorderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 8

        }


        , {

            label: 'Credit by week',
            data: datapoints2,

            backgroundColor: 'rgba(25, 260, 10, 0.6)',

            borderColor: 'rgba(25,25,25,1)',
            borderRadius: 10,
            borderWidth: 1,
            tension: 0.6,


            pointHoverBorderColor: 'white',
            pointHoverBackgroundColor: 'rgba(25,25,25,1)',
            pointBorderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 8

        },

    ]
};



//config block
const config7 = {
    type: 'bar',
    data,
    options: {
        maintainAspectRatio: false,
        responsive: true,

        interaction: {
            intersect: false,
            mode: 'index',
        },
        barValueSpacing: 1,
        barDatasetSpacing: 1,
        barPercentage: 1,
        categoryPercentage: 1,
        scales: {

            x: {
                type: 'time',
                time: {
                    unit: 'week',
                },
                stacked: true,
                ticks: {

                    color: 'rgba(15, 10, 222, 1)'
                },
                grid: {
                    display: false
                }
            },

            y: {
                stacked: true,

                ticks: {
                    color: 'rgba(15, 10, 222, 1)'
                },

                beginAtZero: true,
                grid: {
                    display: false
                }
            },

        },
    },

    
   
};







///////////////////////////////////////////
                const myChart3 = new Chart(
                document.getElementById('myChart3'),
                config7
                );



        },
        error:function(){ 
            alert("error!!!!");
        },
        async: false

    })
}







///////////////for line/////////////
function credit8(){
    var start = $("#start").val();
    var end = $("#end").val();
    var category_w = document.getElementById('cat_graph3').innerHTML;
    // $('.fcRxvB').html();
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"graphssss",
        type:"POST",
        data:{
            start:start,
            end:end,
            category_w:category_w,
        },

        beforeSend: function() {
            $('.fcRxvB').html('<span>Working............</span>');

        },
        success:function(data){
            var html ='';
            var btn ='';

            html +='<div class="sc-AxjAm imVUDT ml-4 mr-4 ">\
            <div data-id="metric-wrapper" class="sc-AxjAm sc-AxiKw krvuUX">\
            <span data-id="metric" id="cat_graph3" class="sc-AxhCb jXrfzm mx-4 check">'+data.cat+' </span>\
            <span data-id="metric" id="debit_graph3" class="sc-AxhCb jXrfzm mx-4">Debit: '+data.total_d+'</span>\
            <span data-id="metric" id="credit_graph3" class="sc-AxhCb jXrfzm mx-4">Credit: '+data.total_c+'</span>\
            </div>\
            <div class="sc-AxjAm sc-prOVx eopTOK ">\
            <canvas id="myChart3"></canvas>\
            </div>\
            <div class="w-75">\
                Start date:<input type="text" id="start" value="'+data.firstDate+'">\
                End date: <input type="text" id="end" value="'+data.lastDate+'">\
                <button class="btn btn-primary mx-2" onclick="filterDataa()">Filter</button>\
                <button class="btn btn-danger mx-2" onclick="resetDataa()">Reset</button>\
            </div>\
            </div>';

btn +='<button type="submit" onclick="debit8()" name="t_debit" id="t_debit"  class="btn btn-primary mx-2 active">Bar chart</button>\
<button type="submit" onclick="credit8()" name="t_credit" id="t_credit" class="btn btn-warning">Line chart</button>\
';

            $('#btn').html(btn);
            $('.fcRxvB').html(html);
            $('#start').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day == 0];
                }
            });
            $('#end').datepicker({
                dateFormat: 'yy-mm-dd',
            
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day == 0];
                }
            });
            
            var type4 =data.type4;
            var expenses3 = data.expenses4;
            var revenue3 = data.revenue4;
            
             
                // 
///////////////start config////////////////


var dates = type4;
var datapoints1 = expenses3;
var datapoints2 = revenue3;
var convertedDates = dates.map(date => new Date(date).setHours(0, 0, 0, 0));
var data = {
    labels: dates,
    datasets: [{

            label: 'Debit by week',
            data: datapoints1,
            backgroundColor: 'rgba(128,0,128,1)',
            borderColor: 'rgba(25,25,25,1)',
            borderRadius: 10,
            borderWidth: 1,
            tension: 0.6,

            pointHoverBorderColor: 'white',
            pointHoverBackgroundColor: 'rgba(25,25,25,1)',
            pointBorderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 8

        }


        , {

            label: 'Credit by week',
            data: datapoints2,

            backgroundColor: 'rgba(25, 260, 10, 0.6)',

            borderColor: 'rgba(25,25,25,1)',
            borderRadius: 10,
            borderWidth: 1,
            tension: 0.6,


            pointHoverBorderColor: 'white',
            pointHoverBackgroundColor: 'rgba(25,25,25,1)',
            pointBorderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 8

        },

    ]
};



//config block
const config7 = {
    type: 'line',
    data,
    options: {
        maintainAspectRatio: false,
        responsive: true,

        interaction: {
            intersect: false,
            mode: 'index',
        },
        barValueSpacing: 1,
        barDatasetSpacing: 1,
        barPercentage: 1,
        categoryPercentage: 1,
        scales: {

            x: {
                type: 'time',
                time: {
                    unit: 'week',
                },
                stacked: true,
                ticks: {

                    color: 'rgba(15, 10, 222, 1)'
                },
                grid: {
                    display: false
                }
            },

            y: {
                stacked: true,

                ticks: {
                    color: 'rgba(15, 10, 222, 1)'
                },

                beginAtZero: true,
                grid: {
                    display: false
                }
            },

        },
    },

    plugins:  [{
  
        afterDraw: chart => {
    
            if (chart.tooltip?._active?.length) {
                let x = chart.tooltip._active[0].element.x;
                let yAxis = chart.scales.y;
                let ctx = chart.ctx;
                ctx.save();
                ctx.beginPath();
                ctx.moveTo(x, yAxis.top);
                ctx.lineTo(x, yAxis.bottom);
                ctx.lineWidth = 1;
                ctx.strokeStyle = '#ff0000';
                ctx.stroke();
                ctx.restore();
            }
        },
    }, 
    {
        beforeDraw: chart => {
            const ctx = chart.ctx;
            if (chart.tooltip._active && chart.tooltip._active.length) {
                const ctx = chart.ctx;
                ctx.save();
                const activePoint = chart.tooltip._active[0];
               
                ctx.beginPath();
                ctx.setLineDash([5, 2]);
                ctx.moveTo(activePoint.element.x, chart.chartArea.top);
                ctx.lineTo(activePoint.element.x, activePoint.element.y)
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'red'
                ctx.stroke()
                ctx.restore()

                ctx.beginPath()
                ctx.setLineDash([1, 2])
                ctx.moveTo(activePoint.element.x, activePoint.element.y)
                ctx.lineTo(activePoint.element.x, chart.chartArea.bottom)
                ctx.lineWidth = 2;
                ctx.strokeStyle = 'rgba(15, 10, 222, 1)';
                ctx.stroke();
                ctx.restore();


            }

        }






    }],

    
};







///////////////////////////////////////////
                const myChart3 = new Chart(
                document.getElementById('myChart3'),
                config7
                );

///////////////////////









        },
        error:function(){ 
            alert("error!!!!");
        },
        async: false

    })
}





////////////////for bar/////////////


function debit8(){
    var start = $("#start").val();
    var end = $("#end").val();
    var category_w = document.getElementById('cat_graph3').innerHTML;
    
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
}),
    $.ajax({
        url:"graphssss",
        type:"POST",
        data:{
            start:start,
            end:end,
            category_w:category_w,
        },

        beforeSend: function() {
            $('.fcRxvB').html('<span>Working............</span>');

        },
        success:function(data){
            var html ='';
            var btn ='';
            html +='<div class="sc-AxjAm imVUDT ml-4 mr-4 ">\
            <div data-id="metric-wrapper" class="sc-AxjAm sc-AxiKw krvuUX">\
            <span data-id="metric" id="cat_graph3" class="sc-AxhCb jXrfzm mx-4 check">'+data.cat+' </span>\
            <span data-id="metric" id="debit_graph3" class="sc-AxhCb jXrfzm mx-4">Debit: '+data.total_d+'</span>\
            <span data-id="metric" id="credit_graph3" class="sc-AxhCb jXrfzm mx-4">Credit: '+data.total_c+'</span>\
            </div>\
            <div class="sc-AxjAm sc-prOVx eopTOK ">\
            <canvas id="myChart3"></canvas>\
            </div>\
            <div class="w-75">\
                Start date:<input type="text" id="start" value="'+data.firstDate+'">\
                End date: <input type="text" id="end" value="'+data.lastDate+'">\
                <button class="btn btn-primary mx-2" onclick="filterDataa()">Filter</button>\
                <button class="btn btn-danger mx-2"onclick="resetDataa()">Reset</button>\
            </div>\
            </div>';

btn +='<button type="submit" onclick="debit8()" name="t_debit" id="t_debit"  class="btn btn-primary mx-2 active">Bar chart</button>\
<button type="submit" onclick="credit8()" name="t_credit" id="t_credit" class="btn btn-warning">Line chart</button>\
';

            $('#btn').html(btn);
            $('.fcRxvB').html(html);
            $('#start').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day == 0];
                }
            });
            $('#end').datepicker({
                dateFormat: 'yy-mm-dd',
            
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day == 0];
                }
            });
            
            var type4 =data.type4;
            var expenses3 = data.expenses4;
            var revenue3 = data.revenue4;
            
             
                // 
///////////////start config////////////////


var dates = type4;
var datapoints1 = expenses3;
var datapoints2 = revenue3;
var convertedDates = dates.map(date => new Date(date).setHours(0, 0, 0, 0));
var data = {
    labels: dates,
    datasets: [{

            label: 'Debit by week',
            data: datapoints1,
            backgroundColor: 'rgba(128,0,128,1)',
            borderColor: 'rgba(25,25,25,1)',
            borderRadius: 10,
            borderWidth: 1,
            tension: 0.6,

            pointHoverBorderColor: 'white',
            pointHoverBackgroundColor: 'rgba(25,25,25,1)',
            pointBorderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 8

        }


        , {

            label: 'Credit by week',
            data: datapoints2,

            backgroundColor: 'rgba(25, 260, 10, 0.6)',

            borderColor: 'rgba(25,25,25,1)',
            borderRadius: 10,
            borderWidth: 1,
            tension: 0.6,


            pointHoverBorderColor: 'white',
            pointHoverBackgroundColor: 'rgba(25,25,25,1)',
            pointBorderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 8

        },

    ]
};



//config block
const config7 = {
    type: 'bar',
    data,
    options: {
        maintainAspectRatio: false,
        responsive: true,

        interaction: {
            intersect: false,
            mode: 'index',
        },
        barValueSpacing: 1,
        barDatasetSpacing: 1,
        barPercentage: 1,
        categoryPercentage: 1,
        scales: {

            x: {
                type: 'time',
                time: {
                    unit: 'week',
                },
                stacked: true,
                ticks: {

                    color: 'rgba(15, 10, 222, 1)'
                },
                grid: {
                    display: false
                }
            },

            y: {
                stacked: true,

                ticks: {
                    color: 'rgba(15, 10, 222, 1)'
                },

                beginAtZero: true,
                grid: {
                    display: false
                }
            },

        },
    },

    
   
};







///////////////////////////////////////////
                const myChart3 = new Chart(
                document.getElementById('myChart3'),
                config7
                );


        },
        error:function(){ 
            alert("error!!!!");
        },
        async: false

    })
}