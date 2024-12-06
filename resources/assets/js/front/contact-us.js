// add enquiry code
listenSubmit('#contactForm', function (e) {
    e.preventDefault()

    $('#contactSubmitBtn').prop('disabled', true)
    $.ajax({
        url: route('enquiries.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#contactForm')[0].reset()
                $('#contactSubmitBtn').prop('disabled', false)
            }
        }, error: function (error) {
            displayErrorMessage(error.responseJSON.message)
            $('#contactForm')[0].reset()
            $('#contactSubmitBtn').prop('disabled', false)
        },
    })
})
