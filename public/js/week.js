var dates = type3;
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
const config3 = {
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

//render block

const myChart3 = new Chart(
    document.getElementById('myChart3'),
    config3
);


////////////js for buttons////////////////

function debit7() {
    myChart3.config.type = 'bar';

    myChart3.update();

}

function credit7() {
    myChart3.config.type = 'line';

    myChart3.update();

}





///////////js for filter/////

function filterDate(){
 


    var start1 = new Date(document.getElementById('start').value);
    start = start1.setHours(0, 0, 0, 0);
    var end1 = new Date(document.getElementById('end').value);
    end = end1.setHours(0, 0, 0, 0);

    var filterDates = convertedDates.filter(date => date >= start && date <= end);
    myChart3.data.labels = filterDates;


    // /working on the data/////////
    var startArray = convertedDates.indexOf(filterDates[0]);
    var endArray = convertedDates.indexOf(filterDates[filterDates.length - 1]);
    var copydatapoints1 = [...datapoints1];
    var copydatapoints2 = [...datapoints2];
    copydatapoints1.splice(endArray + 1, filterDates.length);
    copydatapoints1.splice(0, startArray);
    myChart3.data.datasets[0].data = copydatapoints1;

    // myChart3.datapoints1=copydatapoints1;

    copydatapoints2.splice(endArray + 1, filterDates.length);
    copydatapoints2.splice(0, startArray);
    // myChart3.datapoints2=copydatapoints2;
    myChart3.data.datasets[1].data = copydatapoints2;



    //////to update debit and credit dashboard////////////

    var debit_dashboard =
        copydatapoints1
        .map(function(elt) { // assure the value can be converted into an integer
            return /^\d+$/.test(elt) ? parseInt(elt) : 0;
        })
        .reduce(function(a, b) { // sum all resulting numbers
            return a + b
        });


    var credit_dashboard =
        copydatapoints2
        .map(function(elt) { // assure the value can be converted into an integer
            return /^\d+$/.test(elt) ? parseInt(elt) : 0;
        })
        .reduce(function(a, b) { // sum all resulting numbers
            return a + b
        });


    document.getElementById('debit_graph3').innerHTML = 'Debit :' + debit_dashboard;
    document.getElementById('credit_graph3').innerHTML = 'Credit :' + credit_dashboard;




    ///////////////////////
    myChart3.update();








};

///////////js for reset////////////

function resetDate(){
    myChart3.data.labels = convertedDates;
    myChart3.data.datasets[0].data = datapoints1;
    myChart3.data.datasets[1].data = datapoints2;

   
    const debit_dashboard1 =
        datapoints1
        .map(function(elt) { // assure the value can be converted into an integer
            return /^\d+$/.test(elt) ? parseInt(elt) : 0;
        })
        .reduce(function(a, b) { // sum all resulting numbers
            return a + b
        });


    const credit_dashboard1 =
        datapoints2
        .map(function(elt) { // assure the value can be converted into an integer
            return /^\d+$/.test(elt) ? parseInt(elt) : 0;
        })
        .reduce(function(a, b) { // sum all resulting numbers
            return a + b
        });


    document.getElementById('debit_graph3').innerHTML = 'Debit :' + debit_dashboard1;
    document.getElementById('credit_graph3').innerHTML = 'Credit :' + credit_dashboard1;
    document.getElementById("start").value = type3[0];
    document.getElementById("end").value = type3[type3.length-1];

    myChart3.update();
    }
