function checkTenantName(selected) {
    if($('#txt_tenant_email').val().length == 0) {
        $(selected).popover('show');
    } else {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var result = emailReg.test($('#txt_tenant_email').val());
        if(result === true) {
            $('#form-check-tenant').submit();
        } else {
            $(selected).popover('show');
        }
    }
}