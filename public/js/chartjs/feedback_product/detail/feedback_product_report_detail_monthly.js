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
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: response.data.rating,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.rating_value[0],
                        backgroundColor: [
                            'rgba(255, 77, 77, 0.7)',
                            'rgba(230, 184, 0, 0.7)',
                            'rgba(109, 167, 247, 0.7)'
                        ],
                        borderWidth: 1,
                    }]
                },
                // options: {
                //     scales: {
                //         yAxes: [{
                //             ticks: {
                //                 beginAtZero: true,
                //                 fontSize: 10
                //             }
                //         }],
                //         xAxes: [{
                //             ticks: {
                //                 maxRotation: 90,
                //                 fontSize: 10
                //             }
                //         }]
                //     }
                // }
            });
            window.myChart = myChart;
        } else {
            $('#not_found').css('display', '');
            $('#feedback_product_chart_detail_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    $('#select_month').change(function () {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        onChangeParameter();
    });

    $('#select_year').change(function () {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        onChangeParameter();
    });

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
                    let myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: response.data.rating,
                            datasets: [{
                                label: 'Feedback',
                                data: response.data.rating_value[0],
                                backgroundColor: [
                                    'rgba(255, 77, 77, 0.7)',
                                    'rgba(230, 184, 0, 0.7)',
                                    'rgba(109, 167, 247, 0.7)'
                                ],
                                borderWidth: 1,
                            }]
                        },
                        // options: {
                        //     scales: {
                        //         yAxes: [{
                        //             ticks: {
                        //                 beginAtZero: true,
                        //                 fontSize: 10
                        //             }
                        //         }],
                        //         xAxes: [{
                        //             ticks: {
                        //                 maxRotation: 90,
                        //                 fontSize: 10
                        //             }
                        //         }]
                        //     }
                        // }
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