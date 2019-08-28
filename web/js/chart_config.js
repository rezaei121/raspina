var config = {
    type: 'line',
    data : {
        labels: chart_labels,
        datasets: [
            {
                label: visitor_labels,
                fill: false,
                data: visitor_data,
                borderColor: 'rgba(255,153,51,0.5)',
                backgroundColor: 'rgba(255,153,51,0.5)',
                pointBorderColor: 'rgba(255,140,26,0.8)',
                pointBackgroundColor: 'rgba(255,140,26,1)',
                pointBorderWidth: 3,
            },
            {
                label: visit_labels,
                data: visit_data,
                fill: false,
                borderColor: 'rgba(153,187,255,0.5)',
                backgroundColor: 'rgba(153,187,255,0.5)',
                pointBorderColor: 'rgba(102,153,255,0.8)',
                pointBackgroundColor: 'rgba(102,153,255,1)',
                pointBorderWidth: 3
            }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            labels: {
                // This more specific font property overrides the global property
                fontSize: 10,
                fontFamily: 'sahel'
            }
        },
        title:{
            display:false,
            text:''
        },
        tooltips: {
            mode: 'label'
        },
        hover: {
            mode: 'dataset'
        },
        scales: {
            xAxes: [{
                display: true,
                stacked: true,
                scaleLabel: {
                    show: true,
                    labelString: 'Month'
                },
                ticks: {
                    fontSize: 10
                }
            }],
            yAxes: [{
                display: true,
                stacked: true,
                scaleLabel: {
                    show: true,
                    labelString: 'Value'
                },
                ticks: {
                    suggestedMin: 0,
                    fontSize: 10
                    // suggestedMax: chart_max_visit + (chart_max_visit / 5),
                }
            }]
        }
    }
};

window.onload = function() {
    createChart();
};

window.onresize = function() {
    createChart();
};

function createChart() {

    var width = $(document).width();
    var datasets_count = 30; // all
    if(width <= 980)
    {
        datasets_count = 20
    }
    if(width <= 650)
    {
        datasets_count = 15
    }
    if(width <= 570)
    {
        datasets_count = 10
    }
    if(width <= 480)
    {
        datasets_count = 5
    }

    var new_chart_labels = chart_labels.slice(chart_labels.length-datasets_count,chart_labels.length);
    var new_visitor_data = visitor_data.slice(visitor_data.length-datasets_count,visitor_data.length);
    var new_visit_data = visit_data.slice(visit_data.length-datasets_count,visit_data.length);

    config.data.labels = new_chart_labels;
    config.data.datasets[0].data = new_visitor_data;
    config.data.datasets[1].data = new_visit_data;
    var ctx = document.getElementById("chart_visitors").getContext("2d");
    window.myLine = new Chart(ctx, config);
}