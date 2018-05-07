if($('#all_feedback_rating_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('all_feedback_rating_yearly');
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-all-rating-yearly/' + year;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.message === undefined) {
            let barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.data.labels,
                    datasets: [
                        {
                            label: 'not satisfied',
                            data: response.data.dissatisfied,
                            backgroundColor: 'rgba(255, 0, 0, 0.7)',
                            borderWidth: 1,
                        },
                        {
                            label: 'neutral',
                            data: response.data.neutral,
                            backgroundColor: 'rgba(255, 219, 77, 0.7)',
                            borderWidth: 1,
                        },
                        {
                            label: 'satisfied',
                            data: response.data.satisfied,
                            backgroundColor: 'rgba(46, 184, 46, 0.7)',
                            borderWidth: 1,
                        },
                    ],
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
                                ticks: {
                                    display: true,
                                    maxRotation: 90,
                                    fontSize: 10,
                                    autoSkip: false
                                }
                            }]
                        },
                    }
                }
            });
            window.myChart = barChart;
            $('#all_feedback_rating_yearly').css('display', '');
        } else {
            $('#not_found').css('display', '');
            $('#loading_state').addClass('invisible');
            $('#all_feedback_rating_yearly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function onChangeParameter() {
        $('#current_year').text($('#select_year').val());
        let selectedYear = $('#select_year').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-all-rating-yearly/' + selectedYear;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#loading_state').removeClass('invisible');

        function changeData() {
            axios.get(url).then(response => {
                if(response.data.message === undefined) {
                    let barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.data.labels,
                            datasets: [
                                {
                                    label: 'not satisfied',
                                    data: response.data.dissatisfied,
                                    backgroundColor: 'rgba(255, 0, 0, 0.7)',
                                    borderWidth: 1,
                                },
                                {
                                    label: 'neutral',
                                    data: response.data.neutral,
                                    backgroundColor: 'rgba(255, 219, 77, 0.7)',
                                    borderWidth: 1,
                                },
                                {
                                    label: 'satisfied',
                                    data: response.data.satisfied,
                                    backgroundColor: 'rgba(46, 184, 46, 0.7)',
                                    borderWidth: 1,
                                },
                            ],
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
                                        ticks: {
                                            display: true,
                                            maxRotation: 90,
                                            fontSize: 10,
                                            autoSkip: false
                                        }
                                    }]
                                },
                            }
                        }
                    });
                    window.myChart = barChart;
                    $('#not_found').css('display', 'none');
                    $('#all_feedback_rating_yearly').css('display', '');
                    $('#loading_state').addClass('invisible');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#all_feedback_rating_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}