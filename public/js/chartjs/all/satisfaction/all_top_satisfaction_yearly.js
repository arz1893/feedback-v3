if($('#all_top_satisfaction_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("all_top_satisfaction_yearly");
    var year = $('#select_year').val();
    var tenantId = $('#tenantId').val();
    const url = window.location.protocol + "//" + window.location.host + "/api/feedback_product_report_all/" + tenantId + "/get-all-top-satisfaction/yearly/" + year;
    window.myChart = "";

    axios.get(url).then(response => {
        console.log(response);
    }).catch(error => {
        console.log(error);
    });
}