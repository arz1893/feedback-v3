if($('#feedback_service_comparison_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());
    var ctx = document.getElementById("feedback_service_comparison_yearly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var count = $('#show_data').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-feedback-service-compare-yearly/' + year;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            console.log(response.data);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.data.labels,
                    datasets: [
                        {
                            label: 'not satisfied',
                            data: response.data.dissatisfied,
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            lineTension: 0,
                            borderWidth: 2,
                        },
                        {
                            label: 'neutral',
                            data: response.data.neutral,
                            backgroundColor: 'rgba(255, 219, 77, 0.5)',
                            lineTension: 0,
                            borderWidth: 2,
                        },
                        {
                            label: 'satisfied',
                            data: response.data.satisfied,
                            backgroundColor: 'rgba(46, 184, 46, 0.5)',
                            lineTension: 0,
                            borderWidth: 2,
                        },
                    ]
                },
                option: {
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
                            ticks: {
                                display: true,
                                maxRotation: 90,
                                fontSize: 10,
                                autoSkip: false
                            }
                        }]
                    },
                }
            });
            window.myChart = myChart;
        } else {
            $('#not_found').css('display', '');
            $('#feedback_service_comparison_yearly').css('display', 'none');
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
        var ctx = document.getElementById("feedback_service_comparison_yearly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        $('#current_year').text($('#select_year').val());
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-feedback-service-compare-yearly/' + year;
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
                            datasets: [
                                {
                                    label: 'not satisfied',
                                    data: response.data.dissatisfied,
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                    lineTension: 0,
                                    borderWidth: 2,
                                },
                                {
                                    label: 'neutral',
                                    data: response.data.neutral,
                                    backgroundColor: 'rgba(255, 219, 77, 0.5)',
                                    lineTension: 0,
                                    borderWidth: 2,
                                },
                                {
                                    label: 'satisfied',
                                    data: response.data.satisfied,
                                    backgroundColor: 'rgba(46, 184, 46, 0.5)',
                                    lineTension: 0,
                                    borderWidth: 2,
                                },
                            ]
                        },
                        option: {
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
                                    ticks: {
                                        display: true,
                                        maxRotation: 90,
                                        fontSize: 10,
                                        autoSkip: false
                                    }
                                }]
                            },
                        }
                    });
                    window.myChart = myChart;
                    $('#feedback_service_comparison_yearly').css({'display': ''});
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#feedback_service_comparison_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }
}