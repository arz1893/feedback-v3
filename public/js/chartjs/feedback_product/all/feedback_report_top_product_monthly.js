if($('#feedback_product_all_product_monthly').length > 0) {
    $('.current-year').text($('#select_year').val());
    $('.current-month').text($('#select_month option:selected').text());

    let ctx = document.getElementById("feedback_product_all_product_monthly");
    let tenantId = $('#tenantId').val();
    let year = $('#select_year').val();
    let month = $('#select_month').val();
    let count = $('#show_data').val();

    window.rating = 3;
    window.feedbackLabel = "Satisfied";
    window.bgColor = "rgba(46, 184, 46, 0.7)";
    window.myChart = '';
    window.dataIds = [];
    const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + tenantId + '/get-top-product-report-monthly/' + rating + '/' + year + '/' + month + '/' + count;

    window.showXLabel = true;

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
        if(response.data.error === undefined) {
            window.dataIds = response.data.id;
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
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
                    maintainAspectRatio:true,
                    responsive: true,
                    scales: {
                        yAxes: [{
                            barPercentage: 0.4,
                            categoryPercentage: 1.0,
                            ticks: {
                                beginAtZero:true,
                                fontSize: 8,
                                display: showXLabel
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'total feedback'
                            },
                            ticks: {
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
            window.myChart = myChart;
        } else {
            window.dataIds = [];
            $('#not_found').css('display', '');
            $('#loading_state').addClass('invisible');
            $('#feedback_product_all_product_monthly').css('display', 'none');
        }
    }).catch(error => {
        console.log(error);
    });

    function changeParameter() {
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        $('.current-year').text($('#select_year').val());
        $('.current-month').text($('#select_month option:selected').text());

        let currentRating = $("input[name='customer_rating']:checked").val();
        switch (currentRating) {
            case 1 : {
                window.feedbackLabel = "Dissatisfied";
                window.bgColor = "rgba(255, 0, 0, 0.7)";
                break;
            }
            case 2: {
                window.feedbackLabel = "Neutral";
                window.bgColor = "rgba(255, 219, 77, 0.7)";
                break;
            }
            case 3: {
                window.feedbackLabel = "Satisfied";
                window.bgColor = "rgba(46, 184, 46, 0.7)";
                break;
            }
        }
        onChangeParameter();
    }

    function customerRating(selected) {
        $('i.smiley_rating').each(function (index, element) {
            $(element).removeClass('is-selected');
        });
        $(selected).addClass('is-selected');
        let currentRating = $(selected).data('value');
        window.rating = currentRating;
        if(myChart instanceof Chart) {
            myChart.destroy();
        }
        switch (currentRating) {
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
        let ctx = document.getElementById("feedback_product_all_product_monthly");
        let tenantId = $('#tenantId').val();
        let year = $('#select_year').val();
        let month = $('#select_month').val();
        let count = $('#show_data').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product_report/' + tenantId + '/get-top-product-report-monthly/' + rating + '/' + year + '/' + month + '/' + count;
        $('#loading_state').removeClass('invisible');

        function sendRequest() {
            axios.get(url).then(response => {
                if(response.data.error === undefined) {
                    window.dataIds = response.data.id;
                    $('#not_found').css('display', 'none');
                    $('#loading_state').addClass('invisible');
                    let myChart = new Chart(ctx, {
                        type: 'horizontalBar',
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
                            maintainAspectRatio:true,
                            responsive: true,
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
                    window.myChart = myChart;
                    $('#feedback_product_all_product_monthly').css({'display': ''});
                } else {
                    window.dataIds = [];
                    $('#not_found').css('display', '');
                    $('#loading_state').addClass('invisible');
                    $('#feedback_product_all_product_monthly').css('display', 'none');
                }
            }).catch(error => {
                console.log(error);
            });
        }

        let debounceFunction = _.debounce(sendRequest, 1000);
        debounceFunction();
    }

    function handleClick(evt) {
        let firstPoint = myChart.getElementAtEvent(evt)[0];
        if (firstPoint) {
            let year = $('#select_year').val();
            let month = $('#select_month').val();
            let customer_rating = $("input[name='customer_rating']:checked").val();
            const url = window.location.protocol + "//" + window.location.host + '/api/feedback_product/' + dataIds[firstPoint._index] + '/get-customer-feedback/monthly/'+ customer_rating + '/' + month + '/' + year;
            $('#feedback_content').empty();
            $('#product_name').text(myChart.data.labels[firstPoint._index]);

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

            $('#modal_customer_feedback').modal('show');
        }
    }
}