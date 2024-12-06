// for next month calendar
listenClick('#nextMonth', function () {
    let nextMonth = {date:$(this).attr('data-next-month')}
    Livewire.dispatch('changeMonth', {date:nextMonth})
})

// for previous month calendar
listenClick('#prevMonth', function () {
    let prevMonth = {date:$(this).attr('data-prev-month')}
    Livewire.dispatch('changeMonth', {date:prevMonth})
})

// get task related date
listenClick('.get-slots', function () {
    let slotDate = $(this).attr('date-slot-date')
    Livewire.dispatch('getSlotTime', {slotDate:moment(slotDate).format('YYYY-MM-DD')})
})
