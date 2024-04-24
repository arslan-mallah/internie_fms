  const data_p1=expenses_p;
  const data_p2=revenue_p;
// setup 
const data9= {
    labels: category_p,
    datasets:[{
        label: 'Weekly Sales',
        data:expenses_p, 
        backgroundColor:[
            'rgba(255, 26, 104, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(0, 0, 0, 1)'
        ],
        borderColor: [
            'rgba(255, 26, 104, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(0, 0, 0, 0.2)'
        ],
        borderWidth: 0,
        barPercentage: 0.2,
        borderSkipped: false,
        borderRadius: 10,
    }]
};

const roundedProgressBar = {

    id: 'roundedProgressBar',

    beforeDatasetsDraw(chart, args, pluginOptions) {
        const {
            ctx,
            data,
            chartArea: {
                top,
                bottom,
                left,
                right,
                width,
                height
            },
            scales: {
                x,
                y
            }
        } = chart;

        ctx.save();
        const barHeight = height / data.labels.length;

        ///foreachloop////
        chart.getDatasetMeta(0).data.forEach((datapoint, index) => {

            datapoint.y = top + (barHeight * (index + 0.8));
            // text label
            ctx.font = '12px sans-serif';
            ctx.fillStyle = 'rgba(102,102,102,2)';
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'left';

            ctx.fillText(data.labels[index], left, datapoint.y - 15);


            ////textvalue////
            ctx.font = 'bold 15px sans-serif';
            ctx.fillStyle = data.datasets[0].backgroundColor[index];
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'right';
            ctx.fillText(data.datasets[0].data[index], right, datapoint.y - 15);



            // shape

            ctx.beginPath();
            ctx.strokeStyle = data.datasets[0].borderColor[index];
            ctx.fillStyle = data.datasets[0].borderColor[index];
            ctx.lineWidth = datapoint.height * 0.8;
            ctx.lineJoin = 'round';
            ctx.strokeRect(left + 2.5, datapoint.y, width - 5, 1)


        })


    }
}



// config 
const config9= {
    type: 'bar',
    data:data9,
    options: {
        responsive: true,

        indexAxis: 'y',
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    display: false
                }
            },

            y: {
                beginAtZero: true,
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    display: false
                }
            }
        }
    },
    plugins: [roundedProgressBar]
};

// render init block
const myChart9= new Chart(
    document.getElementById('myChart_p'),
    config9
);






//////////////////functions///////////////////
function debit(){
  document.getElementById('progress').innerHTML='<h4>Your debit report:</h4>';

  myChart9.data.datasets[0].data=expenses_p;
 myChart9.update();

}

function credit(){
  document.getElementById('progress').innerHTML='<h4>Your credit report:</h4>';
  myChart9.data.datasets[0].data=revenue_p;
 myChart9.update();

}


