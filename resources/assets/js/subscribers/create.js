listenSubmit('#subscribeForm', function (e) {
    e.preventDefault()
    let loadingButton = jQuery(this).find('#btnSaveSubscribe')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)

    $.ajax({
        url: route('subscribe.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#subscribeForm')[0].reset()
                $(loadingButton).attr('disabled', false);
            }
        },
        error: function (error) {
            displayErrorMessage(error.responseJSON.message)
            $('#subscribeForm')[0].reset()
            $(loadingButton).attr('disabled', false);
        },
    })
})
