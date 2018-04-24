if($('#feedback_service_chart_all_monthly').length > 0) {
    $('#current_year').text($('#select_year').val());
    $('#current_month').text($('#select_month option:selected').text());

    var ctx = document.getElementById("feedback_service_chart_all_monthly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var count = $('#show_data').val();
    window.rating = 3;
    window.feedbackLabel = "Satisfied";
    window.bgColor = "rgba(109, 167, 247, 0.7)";
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-all-report-monthly/' + rating + '/' + year + '/' + month + '/' + count;
    window.myChart = '';

    axios.get(url).then(response => {
        if(response.data.error === undefined) {
            var myChart = new Chart(ctx, {
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
            $('#feedback_service_chart_all_yearly').css('display', 'none');
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

    function customerRating(selected) {
        $('i.smiley_rating').each(function (index, element) {
            $(element).removeClass('is-selected');
        });
        $(selected).addClass('is-selected');
        let currentRating = $(selected).data('value');
        console.log(currentRating);
        window.rating = currentRating;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        switch (currentRating) {
            case 1 : {
                $('input[name=customer_rating]').attr('checked',false);
                $('#radio_dissatisfied').attr('checked', 'checked');
                window.feedbackLabel = "Dissatisfied";
                window.bgColor = "rgba(255, 77, 77, 0.7)";
                onChangeParameter();
                break;
            }
            case 2: {
                $('input[name=customer_rating]').attr('checked',false);
                $('#radio_neutral').attr('checked', 'checked');
                window.feedbackLabel = "Neutral";
                window.bgColor = "rgba(230, 184, 0, 0.7)";
                onChangeParameter();
                break;
            }
            case 3: {
                $('input[name=customer_rating]').attr('checked',false);
                $('#radio_satisfied').attr('checked', 'checked');
                window.feedbackLabel = "Satisfied";
                window.bgColor = "rgba(109, 167, 247, 0.7)";
                onChangeParameter();
                break;
            }
        }
    }

    function onChangeParameter() {
        var ctx = document.getElementById("feedback_service_chart_all_monthly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        var month = $('#select_month').val();
        var count = $('#show_data').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service_report/' + tenantId + '/get-all-report-monthly/' + rating + '/' + year + '/' + month + '/' + count;
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
                                label: feedbackLabel,
                                data: response.data.data,
                                backgroundColor: bgColor,
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
                    $('#feedback_service_chart_all_yearly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#feedback_service_chart_all_yearly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }
}