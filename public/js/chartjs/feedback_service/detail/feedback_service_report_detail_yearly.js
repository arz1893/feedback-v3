if($('#feedback_service_chart_detail_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("feedback_service_chart_detail_yearly");
    var service_id = $('#serviceId').val();
    var year = $('#select_year').val();

    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + service_id + '/get-report-detail-yearly/' + year;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: response.data.rating,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.rating_value[0],
                        backgroundColor: [
                            'rgba(255, 0, 0, 0.7)',
                            'rgba(255, 219, 77, 0.7)',
                            'rgba(46, 184, 46, 0.7)'
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    pieceLabel: {
                        render: 'percentage',
                        precision: 2
                    }
                }
            });
            window.myChart = myChart;
        } else {
            $('#not_found').css('display', '');
            $('#feedback_service_chart_detail_yearly').addClass('invisible');
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
        let ctx = document.getElementById("feedback_service_chart_detail_yearly");
        let service_id = $('#serviceId').val();
        let year = $('#select_year').val();
        $('#loading_state').removeClass('invisible');
        $('#feedback_service_chart_detail_yearly').css('display', 'none');
        $('#not_found').css('display', 'none');

        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + service_id + '/get-report-detail-yearly/' + year;

        function sendRequest() {
            axios.get(url).then(response => {
                console.log(response.data);
                $('#loading_state').addClass('invisible');
                $('#feedback_service_chart_detail_yearly').css('display', '');
                if(response.data.error === undefined) {
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: response.data.rating,
                            datasets: [{
                                label: 'Feedback',
                                data: response.data.rating_value[0],
                                backgroundColor: [
                                    'rgba(255, 0, 0, 0.7)',
                                    'rgba(255, 219, 77, 0.7)',
                                    'rgba(46, 184, 46, 0.7)'
                                ],
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            pieceLabel: {
                                render: 'percentage',
                                precision: 2
                            }
                        }
                    });
                    window.myChart = myChart;
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }
}