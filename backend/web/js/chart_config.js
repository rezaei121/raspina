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
        title:{
            display:true,
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
                    // suggestedMax: chart_max_visit + (chart_max_visit / 5),
                }
            }]
        }
    }
};


var config2 = {
    type: 'pie',
    data: {
        datasets: [{
            data: pie_chart_data,
            backgroundColor: [
                "#F46F5A",
                "#52B8DD",
                "#7E86E5",
                "#D0D6B3",
                "#E5C687",
                "#FFCC00",
            ],
        }],
        labels: [
            "google",
            "yahoo",
            "bing",
            "baidu",
            "aol",
            "ask"
        ]
    },
    options: {
        responsive: true,
        legend: {
            position: 'left'
        }
    }
};

var config3 = {
    type: 'horizontalBar',
    data: {
        labels: ["06 - 00", "12 - 06", "18 - 12", "24 - 18"],
        datasets: [{
            label: visit_labels,
            backgroundColor: "rgba(153,187,255,0.5)",
            data: visit_period_data
        }]

    },
    options: {
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each horizontal bar to be 2px wide and green
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                display: true,
                stacked: true,
                scaleLabel: {
                    show: true,
                    labelString: 'Value'
                },
                ticks: {
                    suggestedMin: 0
                }
            }]
        }
    }
};

window.onload = function() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);

    var ctx2 = document.getElementById("chart_pie").getContext("2d");
    window.myPie = new Chart(ctx2, config2);
    window.myPie.update();

    var ctx = document.getElementById("line").getContext("2d");
    window.line = new Chart(ctx,config3);
    window.line.update();
};