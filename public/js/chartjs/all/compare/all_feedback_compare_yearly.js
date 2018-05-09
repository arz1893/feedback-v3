if($('#all_feedback_comparison_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var ctx = document.getElementById('all_feedback_comparison_yearly');
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-all-rating-compare-yearly/' + year;

    axios.get(url).then(response => {
        if(response.data.message === undefined) {
            console.log(response.data);
            let lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.data.labels,
                    datasets: [
                        {
                            fill: false,
                            label: 'not satisfied',
                            data: response.data.dissatisfied,
                            borderColor: 'rgba(255, 0, 0, 0.5)',
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            lineTension: 0,
                            borderWidth: 4,
                        },
                        {
                            fill: false,
                            label: 'neutral',
                            data: response.data.neutral,
                            borderColor: 'rgba(255, 219, 77, 0.5)',
                            backgroundColor: 'rgba(255, 219, 77, 0.5)',
                            lineTension: 0,
                            borderWidth: 4,
                        },
                        {
                            fill: false,
                            label: 'satisfied',
                            data: response.data.satisfied,
                            borderColor: 'rgba(46, 184, 46, 0.5)',
                            backgroundColor: 'rgba(46, 184, 46, 0.5)',
                            lineTension: 0,
                            borderWidth: 4,
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
            window.myChart = lineChart;
            $('#all_feedback_comparison_yearly').css('display', '');
        } else {
            $('#not_found').css('display', '');
            $('#loading_state').addClass('invisible');
            $('#all_feedback_comparison_yearly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function onChangeParameter() {
        $('#current_year').text($('#select_year').val());
        let selectedYear = $('#select_year').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-all-rating-compare-yearly/' + selectedYear;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#loading_state').removeClass('invisible');

        function changeData() {
            axios.get(url).then(response => {
                if(response.data.message === undefined) {
                    let lineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.data.labels,
                            datasets: [
                                {
                                    fill: false,
                                    label: 'not satisfied',
                                    data: response.data.dissatisfied,
                                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                    lineTension: 0,
                                    borderWidth: 2
                                },
                                {
                                    fill: false,
                                    label: 'neutral',
                                    data: response.data.neutral,
                                    backgroundColor: 'rgba(255, 219, 77, 0.5)',
                                    lineTension: 0,
                                    borderWidth: 2,
                                },
                                {
                                    fill: false,
                                    label: 'satisfied',
                                    data: response.data.satisfied,
                                    backgroundColor: 'rgba(46, 184, 46, 0.5)',
                                    lineTension: 0,
                                    borderWidth: 2
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
                    window.myChart = lineChart;
                    $('#all_feedback_comparison_yearly').css('display', '');
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#all_feedback_comparison_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}