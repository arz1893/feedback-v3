if($('#global_summary_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('global_summary_yearly');
    var year = $('#select_year').val();
    var tenantId = $('#tenantId').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-global-summary-yearly/' + year;
    window.myChart = "";

    axios.get(url).then(response => {
        console.log(response.data);
        if(response.data.error === undefined) {
            let pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.feedbackRatings,
                        backgroundColor: [
                            'rgba(255, 0, 0, 0.7)',
                            'rgba(255, 219, 77, 0.7)',
                            'rgba(46, 184, 46, 0.7)',
                            'rgba(179, 0, 0, 0.7)',
                            'rgba(191, 191, 191, 0.7)',
                            'rgba(128, 212, 255, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
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
        } else {
            $('#not_found').css('display', '');
            $('#global_summary_yearly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function onChangeParameter() {
        let currentYear = $('#select_year').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-global-summary-yearly/' + currentYear;
        $('#loading_state').removeClass('invisible');
        $('#not_found').css('display', 'none');

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
                                    'rgba(255, 0, 0, 0.7)',
                                    'rgba(255, 219, 77, 0.7)',
                                    'rgba(46, 184, 46, 0.7)',
                                    'rgba(179, 0, 0, 0.7)',
                                    'rgba(191, 191, 191, 0.7)',
                                    'rgba(128, 212, 255, 0.7)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
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
                    $('#global_summary_yearly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#global_summary_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}