if($('#feedback_product_chart_detail_monthly').length > 0) {
    $('#current_year').text($('#select_year').val());
    $('#current_month').text($('#select_month option:selected').text());

    var ctx = document.getElementById("feedback_product_chart_detail_monthly");
    var product_id = $('#productId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();

    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + product_id + '/get-report-detail-monthly/' + year + '/' + month;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            var pieChart = new Chart(ctx, {
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
            window.myChart = pieChart;
        } else {
            $('#not_found').css('display', '');
            $('#feedback_product_chart_detail_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function changeMonth() {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#current_month').text($('#select_month option:selected').text());
        $('#current_year').text($('#select_year').val());
        onChangeParameter();
    }

    function changeYear() {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#current_month').text($('#select_month option:selected').text());
        $('#current_year').text($('#select_year').val());
        onChangeParameter();
    }

    function onChangeParameter() {
        let ctx = document.getElementById("feedback_product_chart_detail_monthly");
        let product_id = $('#productId').val();
        let year = $('#select_year').val();
        let month = $('#select_month').val();
        $('#loading_state').removeClass('invisible');
        $('#feedback_product_chart_detail_yearly').css('display', 'none');
        $('#not_found').css('display', 'none');

        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + product_id + '/get-report-detail-monthly/' + year + '/' + month;

        function sendRequest() {
            axios.get(url).then(response => {
                console.log(response.data);
                $('#loading_state').addClass('invisible');
                $('#feedback_product_chart_detail_monthly').css('display', '');
                if(response.data.error === undefined) {
                    let pieChart = new Chart(ctx, {
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
                    window.myChart = pieChart;
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