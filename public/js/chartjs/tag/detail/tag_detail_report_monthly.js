if($('#tag_detail_report_monthly').length > 0) {
    $('#current_month').text($('#select_month option:selected').text());
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('tag_detail_report_monthly');
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var tagId = $('#tagId').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/tag_report/' + tagId + '/get-report-detail-monthly/' + month + '/' + year;
    window.myChart = '';

    axios.get(url).then(response => {
        console.log(response.data);
        if(response.data.error === undefined) {
            let pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: response.data.labels,
                    datasets: [{
                        label: 'Feedback',
                        data: response.data.values,
                        backgroundColor: [
                            'rgba(46, 184, 46, 0.7)',
                            'rgba(255, 219, 77, 0.7)',
                            'rgba(255, 0, 0, 0.7)'
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
        } else {
            $('#not_found').css('display', '');
            $('#tag_detail_report_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function onChangeParameter() {
        $('#current_month').text($('#select_month option:selected').text());
        $('#current_year').text($('#select_year').val());

        let selectedYear = $('#select_year').val();
        let selectedMonth = $('#select_month').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/tag_report/' + tagId + '/get-report-detail-monthly/' + selectedMonth + '/' + selectedYear;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }

        $('#loading_state').removeClass('invisible');

        function changeData() {
            axios.get(url).then(response => {
                console.log(response.data);
                if(response.data.error === undefined) {
                    let pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: response.data.labels,
                            datasets: [{
                                label: 'Feedback',
                                data: response.data.values,
                                backgroundColor: [
                                    'rgba(46, 184, 46, 0.7)',
                                    'rgba(255, 219, 77, 0.7)',
                                    'rgba(255, 0, 0, 0.7)'
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
                    $('#tag_detail_report_monthly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#tag_detail_report_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }
        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}