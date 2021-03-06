if($('#all_feedback_rating_monthly').length > 0) {
    $('#current_month').text($('#select_month option:selected').text());
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('all_feedback_rating_monthly');
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var tenantId = $('#tenantId').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-all-rating-monthly/' + year + '/' + month;
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
                            barPercentage: 1.0,
                            categoryPercentage: 1.0,
                            ticks: {
                                display: true,
                                maxRotation: 90,
                                fontSize: 10,
                                autoSkip: false
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'label',
                        callbacks: {
                            label: function(t, d) {
                                var dstLabel = d.datasets[t.datasetIndex].label;
                                var yLabel = t.yLabel;
                                return dstLabel + ': ' + yLabel;
                            }
                        }
                    }
                }
            });
            window.myChart = barChart;
        } else {
            $('#not_found').css('display', '');
            $('#all_feedback_rating_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });
    
    function onChangeParameter() {
        $('#current_month').text($('#select_month option:selected').text());
        $('#current_year').text($('#select_year').val());

        let year = $('#select_year').val();
        let month = $('#select_month').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-all-rating-monthly/' + year + '/' + month;

        $('#loading_state').removeClass('invisible');

        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        
        function changeData() {
            axios.get(url).then(response => {
                console.log(response.data);
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
                                    barPercentage: 1.0,
                                    categoryPercentage: 1.0,
                                    ticks: {
                                        display: true,
                                        maxRotation: 90,
                                        fontSize: 10,
                                        autoSkip: false
                                    }
                                }]
                            },
                            tooltips: {
                                mode: 'label',
                                callbacks: {
                                    label: function(t, d) {
                                        var dstLabel = d.datasets[t.datasetIndex].label;
                                        var yLabel = t.yLabel;
                                        return dstLabel + ': ' + yLabel;
                                    }
                                }
                            }
                        }
                    });
                    window.myChart = barChart;
                    $('#all_feedback_rating_monthly').css('display', '');
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#all_feedback_rating_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}