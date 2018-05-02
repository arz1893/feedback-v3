if($('#feedback_service_chart_all_yearly').length > 0) {

    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("feedback_service_chart_all_yearly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-all-report-yearly/'+ year;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.data,
                        borderColor: "rgba(102, 179, 255, 0.7)",
                        backgroundColor: "rgba(102, 179, 255, 0.3)",
                        lineTension: 0,
                        borderWidth: 3,
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
                                labelString: 'months'
                            },
                            ticks: {
                                maxRotation: 90,
                                fontSize: 10
                            }
                        }]
                    }
                }
            });
            window.myChart = myChart;
        } else {
            $('#not_found').css('display', '');
            $('#feedback_service_chart_all_yearly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    $('#select_year').change(function () {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#current_year').text($('#select_year').val());
        onChangeParameter();
    });

    function onChangeParameter() {
        var ctx = document.getElementById("feedback_service_chart_all_yearly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-all-report-yearly/' + year;
        $('#loading_state').removeClass('invisible');

        function sendRequest() {
            axios.get(url).then(response => {
                if(response.data.error === undefined) {
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    let myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.data.labels,
                            datasets: [{
                                label: 'Feedback',
                                data: response.data.data,
                                borderColor: "rgba(102, 179, 255, 0.7)",
                                backgroundColor: "rgba(102, 179, 255, 0.3)",
                                lineTension: 0,
                                borderWidth: 3,
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
                                        labelString: 'months'
                                    },
                                    ticks: {
                                        maxRotation: 90,
                                        fontSize: 10
                                    }
                                }]
                            }
                        }
                    });
                    window.myChart = myChart;
                    $('#feedback_service_chart_all_yearly').css({'display': ''});
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#feedback_service_chart_all_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }
}