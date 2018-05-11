if($('#all_global_feedback_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("all_global_feedback_yearly");
    var year = $('#select_year').val();
    var tenantId = $('#tenantId').val();
    const url = window.location.protocol + "//" + window.location.host + "/api/feedback_report_all/" + tenantId + "/get-all-global-feedback-yearly/" + year;
    window.myChart = "";

    axios.get(url).then(response => {
        console.log(response.data);
        if(response.data.error === undefined) {
            let lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: 'Feedback',
                        fill: false,
                        data: response.data.allDatas,
                        borderColor: "rgba(102, 179, 255, 0.7)",
                        backgroundColor: "rgba(102, 179, 255, 0.3)",
                        lineTension: 0,
                        borderWidth: 4,
                    }]
                },
                options: {
                    maintainAspectRatio:true,
                    responsive: true,
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'total feedback'
                            },
                            ticks: {
                                beginAtZero:true,
                                fontSize: 10
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'month'
                            },
                            ticks: {
                                maxRotation: 90,
                                fontSize: 10,
                                autoSkip: false
                            }
                        }]
                    },
                }
            });
            window.myChart = lineChart;
        }
    }).catch(error => {
        console.log(error);
    });
}