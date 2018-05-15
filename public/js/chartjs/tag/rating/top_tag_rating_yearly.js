if($('#top_tag_rating_yearly').length > 0) {
    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById('top_tag_rating_yearly');
    var tenantId = $('#tenantId').val();
    var year = $("#select_year").val();
    const url = window.location.protocol + "//" + window.location.host + '/api/tag_report/' + tenantId + '/get-top-tag-report-yearly/' + year;
    window.myChart = '';

    axios.get(url).then(response => {
        console.log(response.data);
    }).catch(error => {
        console.log(error);
    });
}