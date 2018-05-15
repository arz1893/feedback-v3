if($('#global_summary_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('global_summary_yearly');
    var year = $('#select_year').val();
    var tenantId = $('#tenantId').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_report_all/' + tenantId + '/get-global-summary-yearly/' + year;
    window.myChart = "";

    axios.get(url).then(response => {
        console.log(response.data);
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
    }).catch(error => {
        console.log(error);
    });
}