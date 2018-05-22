if($('#top_tag_satisfaction_monthly').length > 0) {
    $('#current_month').text($("input[name='select_month'] option:selected").text());
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('top_tag_satisfaction_monthly');
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var count = $('#show_data').val();
    window.rating = 3;
    window.feedbackLabel = "Satisfied";
    window.bgColor = "rgba(46, 184, 46, 0.7)";
    window.myChart = "";
    window.showXLabel = true;
    const url = window.location.protocol + "//" + window.location.host + '/api/tag_report/' + tenantId + '/get-tag-top-satisfaction-monthly/' + rating + '/' + year + '/' + month + '/' + count;

    var deviceAgent = navigator.userAgent.toLowerCase();
    var isTouchDevice = Modernizr.touch ||
        (deviceAgent.match(/(iphone|ipod|ipad)/) ||
            deviceAgent.match(/(android)/)  ||
            deviceAgent.match(/(iemobile)/) ||
            deviceAgent.match(/iphone/i) ||
            deviceAgent.match(/ipad/i) ||
            deviceAgent.match(/ipod/i) ||
            deviceAgent.match(/blackberry/i) ||
            deviceAgent.match(/bada/i));
    if(isTouchDevice) {
        // window.showXLabel = false;
    }

    axios.get(url).then(response => {
        console.log(response.data);
        if(response.data.error === undefined) {
            let barChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: response.data.allTags,
                    datasets: [{
                        label: feedbackLabel,
                        data: response.data.tagValues,
                        backgroundColor: bgColor,
                        borderWidth: 1,
                    }]
                },
                options: {
                    maintainAspectRatio:true,
                    responsive: true,
                    tooltips: {
                        mode: 'index'
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.4,
                            categoryPercentage: 1.0,
                            ticks: {
                                beginAtZero:true,
                                fontSize: 8
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'total feedback'
                            },
                            ticks: {
                                display: showXLabel,
                                maxRotation: 90,
                                fontSize: 10,
                                autoSkip: false,
                                beginAtZero:true,
                                userCallback: function(label, index, labels) {
                                    // when the floored value is the same as the value we have a whole number
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }

                                },
                            }
                        }]
                    },
                    // onClick: handleClick
                }
            });
            window.myChart = barChart;
        } else {
            $('#not_found').css('display', '');
            $('#top_tag_satisfaction_monthly').css('display', 'none');
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

    $('#select_month').change(function () {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#current_month').text($("input[name='select_month'] option:selected").text());
        onChangeParameter();
    });

    $('#show_data').change(function () {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('#current_year').text($('#select_year').val());
        onChangeParameter();
    });

    function customerRating(selected) {
        $('i.smiley_rating').each(function (index, element) {
            $(element).removeClass('is-selected');
        });
        $(selected).addClass('is-selected');
        let rating = $(selected).data('value');
        window.rating = rating;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        switch (rating) {
            case 1 : {
                $('input[name=customer_rating]').attr('checked',false);
                $('#radio_dissatisfied').attr('checked', 'checked');
                window.feedbackLabel = "Dissatisfied";
                window.bgColor = "rgba(255, 0, 0, 0.7)";
                onChangeParameter();
                break;
            }
            case 2: {
                $('input[name=customer_rating]').attr('checked',false);
                $('#radio_neutral').attr('checked', 'checked');
                window.feedbackLabel = "Neutral";
                window.bgColor = "rgba(255, 219, 77, 0.7)";
                onChangeParameter();
                break;
            }
            case 3: {
                $('input[name=customer_rating]').attr('checked',false);
                $('#radio_satisfied').attr('checked', 'checked');
                window.feedbackLabel = "Satisfied";
                window.bgColor = "rgba(46, 184, 46, 0.7)";
                onChangeParameter();
                break;
            }
        }
    }

    function onChangeParameter() {
        $('#current_month').text($("input[name='select_month'] option:selected").text());
        $('#current_year').text($('#select_year').val());
        let selectedYear = $('#select_year').val();
        let selectedMonth = $('#select_month').val();
        let currentCount = $('#show_data').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/tag_report/' + tenantId + '/get-tag-top-satisfaction-monthly/' + rating + '/' + selectedYear + '/' + selectedMonth + '/' + currentCount;
        $('#loading_state').removeClass('invisible');

        function changeData() {
            axios.get(url).then(response => {
                if(response.data.error === undefined) {
                    let barChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: response.data.allTags,
                            datasets: [{
                                label: feedbackLabel,
                                data: response.data.tagValues,
                                backgroundColor: bgColor,
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            maintainAspectRatio:true,
                            responsive: true,
                            tooltips: {
                                mode: 'index'
                            },
                            scales: {
                                yAxes: [{
                                    barPercentage: 0.4,
                                    categoryPercentage: 1.0,
                                    ticks: {
                                        beginAtZero:true,
                                        fontSize: 8
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'total feedback'
                                    },
                                    ticks: {
                                        display: showXLabel,
                                        maxRotation: 90,
                                        fontSize: 10,
                                        autoSkip: false,
                                        beginAtZero:true,
                                        userCallback: function(label, index, labels) {
                                            // when the floored value is the same as the value we have a whole number
                                            if (Math.floor(label) === label) {
                                                return label;
                                            }

                                        },
                                    }
                                }]
                            },
                            // onClick: handleClick
                        }
                    });
                    window.myChart = barChart;
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    $('#top_tag_satisfaction_monthly').css('display', '');
                } else {
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#top_tag_satisfaction_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }
}