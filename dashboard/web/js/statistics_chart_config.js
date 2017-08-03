var config2 = {
    type: 'pie',
    data: {
        datasets: [{
            data: pie_chart_data ,
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
            label: 'Visit',
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
    var ctx2 = document.getElementById("chart_pie").getContext("2d");
    // alert(config2);
    window.myPie = new Chart(ctx2, config2);
    // window.myPie.update();

    var ctx = document.getElementById("line").getContext("2d");
    window.line = new Chart(ctx,config3);
    // window.line.update();
};