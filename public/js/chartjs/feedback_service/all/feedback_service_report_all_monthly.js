if($('#feedback_service_chart_all_monthly').length > 0) {
    $('#current_year').text($('#select_year').val());
    $('#current_month').text($('#select_month option:selected').text());

    var ctx = document.getElementById("feedback_service_chart_all_monthly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var count = $('#show_data').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-all-report-monthly/' + year + '/' + month;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            var myChart = new Chart(ctx, {
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
                            scaleLabel: {
                                display: true,
                                labelString: 'days'
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
            $('#feedback_service_chart_all_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function changeParameter() {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#current_year').text($('#select_year').val());
        $('#current_month').text($('#select_month option:selected').text());
        onChangeParameter();
    }

    function onChangeParameter() {
        var ctx = document.getElementById("feedback_service_chart_all_monthly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        var month = $('#select_month').val();
        var count = $('#show_data').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-all-report-monthly/' + year + '/' + month;
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
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'days'
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
                    $('#feedback_service_chart_all_monthly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#feedback_service_chart_all_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }
}