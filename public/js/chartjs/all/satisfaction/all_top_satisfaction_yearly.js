if($('#all_top_satisfaction_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("all_top_satisfaction_yearly");
    var year = $('#select_year').val();
    var count = $('#show_data').val();
    var tenantId = $('#tenantId').val();
    window.rating = 3;
    window.feedbackLabel = "Satisfied";
    window.bgColor = "rgba(46, 184, 46, 0.7)";
    window.myChart = "";
    window.showXLabel = true;
    const url = window.location.protocol + "//" + window.location.host + "/api/feedback_report_all/" + tenantId + "/get-all-top-satisfaction-yearly/" + rating + '/' + year + '/' + count;

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
            window.dataIds = response.data.allIds;
            window.dataMarkers = response.data.allMarkers;
            let barChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: response.data.allLabels,
                    datasets: [{
                        label: feedbackLabel,
                        data: response.data.allDatas,
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
                    onClick: handleClick
                }
            });
            window.myChart = barChart;
        } else {
            $('#not_found').css('display', '');
            $('#all_top_satisfaction_yearly').css('display', 'none');
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
        var ctx = document.getElementById("all_top_satisfaction_yearly");
        var year = $('#select_year').val();
        var count = $('#show_data').val();
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/api/feedback_report_all/" + tenantId + "/get-all-top-satisfaction-yearly/" + rating + '/' + year + '/' + count;

        $('#loading_state').removeClass('invisible');

        function changeData() {
            axios.get(url).then(response => {
                console.log(response.data);
                if(response.data.error === undefined) {
                    window.dataIds = response.data.allIds;
                    window.dataMarkers = response.data.allMarkers;
                    let barChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: response.data.allLabels,
                            datasets: [{
                                label: feedbackLabel,
                                data: response.data.allDatas,
                                backgroundColor: bgColor,
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            maintainAspectRatio:true,
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    barPercentage: 0.4,
                                    categoryPercentage: 1.0,
                                    ticks: {
                                        beginAtZero:true,
                                        fontSize: 8,
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
                            onClick: handleClick
                        }
                    });
                    window.myChart = barChart;
                    $('#loading_state').addClass('invisible');
                    $('#all_top_satisfaction_yearly').css('display', '');
                    $('#not_found').css('display', 'none');
                } else {
                    $('#not_found').css('display', '');
                    $('#all_top_satisfaction_yearly').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(changeData, 1000);
        debounceFunction();
    }

    function handleClick(evt) {
        let firstPoint = myChart.getElementAtEvent(evt)[0];
        if (firstPoint) {
            let year = $('#select_year').val();
            let customer_rating = $("input[name='customer_rating']:checked").val();
            if(dataMarkers[firstPoint._index] === 1) {
                const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product/' + dataIds[firstPoint._index] + '/get-customer-feedback/yearly/'+ customer_rating + '/' + year;
                $('#feedback_content').empty();
                $('#item_name').text(myChart.data.labels[firstPoint._index]);

                axios.get(url).then(response => {
                    for(let i=0;i<response.data.allFeedback.length;i++) {
                        let template = "     <div class=\"direct-chat-msg\">\n" +
                            "                  <div class=\"direct-chat-info clearfix\">\n" +
                            "                    <span class=\"direct-chat-name pull-left\">"+ response.data.allFeedback[i].customer_name + "</span>\n" +
                            "                    <span class=\"direct-chat-timestamp pull-right\">" + response.data.allFeedback[i].created_at + "</span>\n" +
                            "                  </div>\n" +
                            "                  <img class=\"direct-chat-img\" src="+ window.location.protocol + "//" + window.location.host  + '/default-images/default-user.png' +"> \n" +
                            "                  <div class=\"direct-chat-text\">\n" +
                            "                    "+ response.data.allFeedback[i].customer_feedback + "\n" +
                            "                  </div>\n" +
                            "                </div>";
                        $('#feedback_content').append(template);
                    }
                }).catch(error => {
                    console.log(error);
                });
            } else if(dataMarkers[firstPoint._index] === 0) {
                const url = window.location.protocol + "//" + window.location.host + '/api/feedback_service/' + dataIds[firstPoint._index] + '/get-customer-feedback/yearly/'+ customer_rating + '/' + year;
                $('#feedback_content').empty();
                $('#item_name').text(myChart.data.labels[firstPoint._index]);

                axios.get(url).then(response => {
                    for(let i=0;i<response.data.allFeedback.length;i++) {
                        let template = "     <div class=\"direct-chat-msg\">\n" +
                            "                  <div class=\"direct-chat-info clearfix\">\n" +
                            "                    <span class=\"direct-chat-name pull-left\">"+ response.data.allFeedback[i].customer_name + "</span>\n" +
                            "                    <span class=\"direct-chat-timestamp pull-right\">" + response.data.allFeedback[i].created_at + "</span>\n" +
                            "                  </div>\n" +
                            "                  <img class=\"direct-chat-img\" src="+ window.location.protocol + "//" + window.location.host  + '/default-images/default-user.png' +"> \n" +
                            "                  <div class=\"direct-chat-text\">\n" +
                            "                    "+ response.data.allFeedback[i].customer_feedback + "\n" +
                            "                  </div>\n" +
                            "                </div>";
                        $('#feedback_content').append(template);
                    }
                }).catch(error => {
                    console.log(error);
                });
            }

            $('#modal_customer_feedback').modal('show');
        }
    }
}