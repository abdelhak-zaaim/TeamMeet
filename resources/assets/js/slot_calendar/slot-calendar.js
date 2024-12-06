document.addEventListener('DOMContentLoaded', loadSlotCalendarData)

function loadSlotCalendarData () {
    if (!$('#calendar').length) {
        return
    }

    let slotCalendar = $('#calendar').evoCalendar({
        theme: 'Royal Navy',
        format: 'yyyy-mm-dd',
        calendarEvents: eventSchedules,
    })

    $('#calendar').
        evoCalendar('selectDate', moment().tz(currentUTCDate).format('LL'))
    $('#calendar').evoCalendar('selectMonth', months)
    $('#calendar').evoCalendar('selectYear', year)

    let selectedDate = moment().tz(currentUTCDate).format('Y-M-D')
    let selectedYear = year
    let month = parseInt(parseInt(months) + 1)
    let selectedMonth = moment(month, 'M').format('MMMM')

    $(slotCalendar).on('selectMonth', function (event, activeEvent) {
        window.location.href = slotCalendarUrl + '?month=' + activeEvent +
            '&year=' + selectedYear
    })

    $(slotCalendar).on('selectYear', function (event, activeEvent) {
        window.location.href = slotCalendarUrl + '?month=' + selectedMonth +
            '&year=' + activeEvent
    })

    $(slotCalendar).on('selectDate', function (event, activeEvent) {
        selectedDate = activeEvent
    })

    $('#calendar').on('selectEvent', function (event, activeEvent) {
        let activeDate = $('#calendar').evoCalendar('getActiveDate')
        let activeEvents = $('#calendar').evoCalendar('getActiveEvents')
        let id = activeEvent.id
        let selectedTime = ''
        let originalTime = ''

        $.each(activeEvents, function (i, v) {
            if (id === v.id) {
                selectedTime = v.name
                originalTime = v.originalTime
            }
        })

        window.location.href = slotCalendarUrl + '/' + activeDate + '?time=' +
            selectedTime + '&originalTime=' + originalTime
    })
}
