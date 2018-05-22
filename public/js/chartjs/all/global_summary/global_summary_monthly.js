if($('#global_summary_monthly').length > 0) {
    $('#current_month').text($('#select_month option:selected').text());
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('global_summary_monthly');
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-global-summary-monthly/' + year + '/' + month;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            let pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.feedbackRatings,
                        backgroundColor: [
                            'rgba(0, 153, 0, 0.7)',
                            'rgba(51, 204, 51, 0.7)',
                            'rgba(121, 255, 77, 0.7)',
                            'rgba(0, 0, 179, 0.7)',
                            'rgba(51, 51, 255, 0.7)',
                            'rgba(102, 153, 255, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        position: 'left',
                        align: 'center'
                    },
                    maintainAspectRatio:true,
                    responsive: true,
                    pieceLabel: {
                        render: 'percentage',
                        precision: 2,
                        position: 'outside'
                    }
                }
            });
            window.myChart = pieChart;
            $('#not_found').css('display', 'none');
            $('#loading_state').addClass('invisible');
            $('#global_summary_monthly').css('display', '');
        } else {
            $('#not_found').css('display', '');
            $('#loading_state').addClass('invisible');
            $('#global_summary_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function changeParameter() {
        $('#current_month').text($('#select_month option:selected').text());
        $('#current_year').text($('#select_year').val());
        let selectedYear = $('#select_year').val();
        let selectedMonth = $('#select_month').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-global-summary-monthly/' + selectedYear + '/' + selectedMonth;
        $('#loading_state').removeClass('invisible');

        if(myChart instanceof Chart) {
            myChart.destroy();
        }

        function changeData() {
            axios.get(url).then(response => {
                if(response.data.error === undefined) {
                    let pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: response.data.labels,
                            datasets: [{
                                label: 'Feedback',
                                data: response.data.feedbackRatings,
                                backgroundColor: [
                                    'rgba(0, 153, 0, 0.7)',
                                    'rgba(51, 204, 51, 0.7)',
                                    'rgba(121, 255, 77, 0.7)',
                                    'rgba(0, 0, 179, 0.7)',
                                    'rgba(51, 51, 255, 0.7)',
                                    'rgba(102, 153, 255, 0.7)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            legend: {
                                position: 'left',
                                align: 'center'
                            },
                            maintainAspectRatio:true,
                            responsive: true,
                            pieceLabel: {
                                render: 'percentage',
                                precision: 2,
                                position: 'outside'
                            }
                        }
                    });
                    window.myChart = pieChart;
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    $('#global_summary_monthly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#global_summary_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}