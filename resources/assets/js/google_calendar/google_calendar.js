// Sync google calendar code
listenClick('#syncGoogleCalendar', function () {
    let btnSubmitEle = $(this)
    setBtnLoader(btnSubmitEle)
    $.ajax({
        url: route('syncGoogleCalendarList'),
        type: 'GET',
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                setTimeout(function () {
                    location.reload()
                }, 1200)
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
        complete: function () {
            setBtnLoader(btnSubmitEle)
        },
    })
})

// Store google calendar code
listenSubmit('#googleCalendarForm', function (e) {
    e.preventDefault()
    if (!$('.google-calendar').is(':checked')) {
        displayErrorMessage(
            Lang.get('js.select_calender'))
        return
    }
    let btnSubmitEle = $('#googleCalendarSubmitBtn')
    setBtnLoader(btnSubmitEle)
    $.ajax({
        url: route('event.google.calendar.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                setTimeout(function () {
                    location.reload()
                }, 1200)
            }
        },
        error: function (error) {
            displayErrorMessage(error.responseJSON.message)
        },
        complete: function () {
            setBtnLoader(btnSubmitEle)
        },
    })
})
