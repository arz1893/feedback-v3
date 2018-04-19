if($('#feedback_product_chart_all_yearly').length > 0) {

    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("feedback_product_chart_all_yearly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var count = $('#show_data').val();
    console.log({tenantId: tenantId, year: year, count: count });
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + tenantId + '/get-all-report-yearly/' + '3' + '/' + year + '/' + count;

    axios.get(url).then(response => {
        console.log(response.data);
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: response.data.labels,
                datasets: [{
                    label: 'Satisfied',
                    data: response.data.data,
                    backgroundColor: 'rgba(109, 167, 247, 0.7)',
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
                            fontSize: 10
                        }
                    }]
                }
            }
        });
        window.myChart = myChart;
    }).catch(error => {
        console.log(error);
    });

    $('#select_year').change(function () {
        myChart.destroy();
        onChangeParameter();
    });

    $('#show_data').change(function () {
        myChart.destroy();
        onChangeParameter();
    });

    function onChangeParameter() {
        var ctx = document.getElementById("feedback_product_chart_all_yearly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        var count = $('#show_data').val();
        $('#current_year').text($('#select_year').val());
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + tenantId + '/get-all-report-yearly/' + '3' + '/' + year + '/' + count;

        axios.get(url).then(response => {
            if(response.data.error === undefined) {
                $('#not_found').css('display', 'none');
                $('#feedback_product_chart_all_yearly').css({'display': '', 'height': '55vh', 'width': '80vw'});
                let myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Satisfied',
                            data: response.data.data,
                            backgroundColor: 'rgba(109, 167, 247, 0.7)',
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
                                    fontSize: 10
                                }
                            }]
                        }
                    }
                });
                window.myChart = myChart;
            } else {
                $('#not_found').css('display', '');
                $('#feedback_product_chart_all_yearly').css('display', 'none');
            }
        }).catch(error => {
            console.log(error);
        });
    }
}