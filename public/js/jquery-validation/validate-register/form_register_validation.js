$(document).ready(function () {
    $('#form_register').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",
        rules: {
            name: 'required',
            category_id: 'required',
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4
            },
            password_confirmation: {
                required: true,
                minlength: 4,
                equalTo: '#txt_password'
            },
            country: 'required'
        },
        messages: {
            name: 'please enter your business / company name',
            email: {
                required: 'please enter your email',
                email: 'email format is invalid'
            },
            category_id: 'please select your business type',
            password: {
                required: 'please enter your password',
                minlength: jQuery.validator.format("At least {0} characters required!")
            },
            password_confirmation: {
                required: 'please re enter your password',
                minlength: jQuery.validator.format("At least {0} characters required!"),
                equalTo: 'your password didn\'t match'
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});