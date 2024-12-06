document.addEventListener('turbo:load', loadScheduleEventData)

function loadScheduleEventData () {
    let uri = window.location.toString()
    if (uri.indexOf('?') > 0) {
        let clean_uri = uri.substring(0, uri.indexOf('?'))
        window.history.replaceState({}, document.title, clean_uri)
    }
}

// delete schedule event code
listenClick('.scheduled-event-delete-btn', function () {
    let scheduledEventId = $(this).attr('data-id')
    deleteItem(route('scheduled-events.destroy', scheduledEventId),
        'Scheduled Event')
})
