if($('#feedback_product_chart_all_monthly').length > 0) {
    $('#current_year').text($('#select_year').val());
    $('#current_month').text($('#select_month option:selected').text());

    let ctx = document.getElementById("feedback_product_chart_all_monthly");
    let tenantId = $('#tenantId').val();
    let year = $('#select_year').val();
    let month = $('#select_month').val();

    console.log({year: year, month: month});

    window.myChart = '';
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + tenantId + '/get-all-report-monthly/'+ year + '/' + month;

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.data,
                        backgroundColor: 'rgba(102, 179, 255, 0.7)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                fontSize: 10
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                maxRotation: 90,
                                fontSize: 10,
                                autoSkip: false
                            }
                        }]
                    }
                }
            });
            window.myChart = myChart;
        } else {
            $('#not_found').css('display', '');
            $('#loading_state').addClass('invisible');
            $('#feedback_product_chart_all_yearly').css('display', 'none');
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
        let ctx = document.getElementById("feedback_product_chart_all_monthly");
        let tenantId = $('#tenantId').val();
        let year = $('#select_year').val();
        let month = $('#select_month').val();
        let count = $('#show_data').val();
        console.log({tenantId: tenantId, year: year, month: month, count: count});
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + tenantId + '/get-all-report-monthly/' + year + '/' + month;
        $('#loading_state').removeClass('invisible');

        function sendRequest() {
            axios.get(url).then(response => {
                if(response.data.error === undefined) {
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.data.labels,
                            datasets: [{
                                label: 'Feedback',
                                data: response.data.data,
                                backgroundColor: "rgba(102, 179, 255, 0.7)",
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true,
                                        fontSize: 10
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        maxRotation: 90,
                                        fontSize: 10,
                                        autoSkip: false
                                    }
                                }]
                            }
                        }
                    });
                    window.myChart = myChart;
                    $('#feedback_product_chart_all_monthly').css({'display': ''});
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#feedback_product_chart_all_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }
}