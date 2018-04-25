var validator = $('#form_add_faq_product').validate({
    errorClass: "my-error-class",
    validClass: "my-valid-class",
    rules: {
        question: 'required',
        answer: 'required'
    },
    messages: {
        question: 'Please enter question',
        answer: 'Please enter the answer'
    },

    submitHandler: function (form) {
        form.submit();
    }
});

$('#modal_add_faq_product').on('hidden.bs.modal', function () {
    validator.resetForm();
});