const data4 = {

    labels: type_m,

    datasets: [{

            label: 'expenses by month',
            data: expenses_m,
            backgroundColor: 'rgba(128,0,128,1)',

            borderColor: 'rgb(255,255,255)',
            barPercentage: 1,
            categoryPercentage: 1,
            borderWidth: 1,
            borderRadius: 5


        },
        {
            label: 'revenue by month',
            data: revenue_m,
            backgroundColor: 'rgba(0,255,255)',

            borderColor: 'rgb(255,255,255)',

            barPercentage: 1,
            categoryPercentage: 1,
            borderWidth: 1,
            borderRadius: 10

        },

    ]
};


//config block
const config4 = {
    type: 'bar',
    data: data4,
    options: {
        maintainAspectRatio: false,
        responsive: true,

        interaction: {
            intersect: false,
            mode: 'index',
        },
        //     barValueSpacing : 1,        
        // barDatasetSpacing : 1,
        barPercentage: 1,
        categoryPercentage: 0.8,
        scales: {

            x: {

                stacked: true,
                ticks: {
                    maxTicksLimit: data4.labels.length / 2,
                    color: 'rgba(128,0,128,1)',
                },
                grid: {
                    display: false
                }
            },

            y: {
                stacked: true,
                ticks: {
                    display: true,
                    // color: 'rgba(255,255,0,1)'
                },

                beginAtZero: true,
                grid: {
                    display: false
                }
            },

        },
    },


    plugins: {
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
        }
    },
};

//render block

const myChart4 = new Chart(
    document.getElementById('myChart4'),
    config4
);