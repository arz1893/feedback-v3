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
                    ]
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
                                fontSize: 10,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }

                                }
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
                        }],
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
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#loading_state').removeClass('invisible');

        function sendRequest() {
            axios.get(url).then(response => {
                if(response.data.error === undefined) {
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    let barChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.data.labels,
                            datasets: [
                                {
                                    label: 'not satisfied',
                                    data: response.data.dissatisfied,
                                    backgroundColor: 'rgba(255, 0, 0, 0.7)',
                                    stack: 'Stack 0',
                                    borderWidth: 1,
                                },
                                {
                                    label: 'neutral',
                                    data: response.data.neutral,
                                    backgroundColor: 'rgba(255, 219, 77, 0.7)',
                                    stack: 'Stack 0',
                                    borderWidth: 1,
                                },
                                {
                                    label: 'satisfied',
                                    data: response.data.satisfied,
                                    backgroundColor: 'rgba(46, 184, 46, 0.7)',
                                    stack: 'Stack 0',
                                    borderWidth: 1,
                                },
                            ]
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
                                        fontSize: 10,
                                        userCallback: function(label, index, labels) {
                                            // when the floored value is the same as the value we have a whole number
                                            if (Math.floor(label) === label) {
                                                return label;
                                            }

                                        },
                                    }
                                }],
                                xAxes: [{
                                    barPercentage: 1.0,
                                    categoryPercentage: 1.0,
                                    ticks: {
                                        display: true,
                                        maxRotation: 90,
                                        fontSize: 9,
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
                    $('#feedback_service_comparison_yearly').css('display', '');
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
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