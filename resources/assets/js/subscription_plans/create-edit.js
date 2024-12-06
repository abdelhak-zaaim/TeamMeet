document.addEventListener('turbo:load', loadSubscriptionPlanCreateEditData)

function loadSubscriptionPlanCreateEditData () {
    $('.price-input').trigger('input')
    $(window).on('beforeunload', function () {
        $('input[type=submit]').prop('disabled', 'disabled')
    })

    $('#createSubscriptionPlanForm, #editSubscriptionPlanForm').
        find('input:text:visible:first').
        focus()

    if (!$('#planType').length || !$('#currency').length) {
        return
    }

    $('#planType').select2()
    $('#currency').select2()
}

listenSubmit('#createSubscriptionPlanForm, #editSubscriptionPlanForm',
    function () {
        $('#btnSave').attr('disabled', true)
    })
