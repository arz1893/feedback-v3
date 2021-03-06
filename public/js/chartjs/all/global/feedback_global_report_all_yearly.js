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
        $('#not_found').css('display', '');
        $('#all_global_feedback_yearly').css('display', 'none');
        console.log(error);
    });

    function onChangeParameter() {
        $('#current_year').text($('#select_year').val());
        let selectedYear = $('#select_year').val();
        const url = window.location.protocol + "//" + window.location.host + "/api/feedback_report_all/" + tenantId + "/get-all-global-feedback-yearly/" + selectedYear;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#loading_state').removeClass('invisible');

        function changeData() {
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
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    $('#all_global_feedback_yearly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#all_global_feedback_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}