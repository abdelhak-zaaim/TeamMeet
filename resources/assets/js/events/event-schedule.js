document.addEventListener('turbo:load', loadEventScheduleData)

let isEdit
let eventId

function loadEventScheduleData () {
    isEdit = $('#eventIsEdit').val()
    eventId = $('#eventIdEdit').val()

    let defaultUserSchedule = $('#defaultScheduleId').val()

    if (isEdit) {
        $('.change-schedule').val(defaultUserSchedule).trigger('change')
    }

    if (!$('#scheduleNameId').length || !$('#scheduleId').length ||
        !$('#timeZoneId').length) {
        return
    }

    $('#scheduleNameId').select2()
    $('#scheduleId').select2()
    $('#timeZoneId').select2()
}

listenClick('.add-session-time', function () {
    let selectedIndex = 0
    if ($(this).
        parent().
        prev().
        children('.session-times').
        find('.timeSlot:last-child').length > 0) {
        selectedIndex = $(this).
            parent().
            prev().
            children('.session-times').
            find('.timeSlot:last-child').
            children('.add-slot').
            find('select[name^="to_time"] option:selected')[0].index
    }

    let day = $(this).closest('.weekly-content').attr('data-day')
    let $ele = $(this)
    let weeklyEle = $(this).closest('.weekly-content')
    $.ajax({
        url: route('get.slot.by.gap'),
        data: { day: day },
        success: function (data) {
            weeklyEle.find('.unavailable-time').html('')
            weeklyEle.find('input[name="checked_week_days[]"').
                prop('checked', true).prop('disabled', false)
            $ele.closest('.weekly-content').
                find('.session-times').
                append(data.data)
            weeklyEle.find('.time').select2()
            let startTimeOptions = $('.add-session-time').
                parent().
                prev().
                children('.session-times').
                find('.timeSlot:last-child').
                children('.add-slot').
                find('select[name^="from_time"] option')
            startTimeOptions.each(function (index) {
                if (index <= selectedIndex) {
                    $(this).attr('disabled', true)
                } else {
                    $(this).attr('disabled', false)
                }
            })
        },
    })
})

// copy slot day time
listenClick('.copy-btn', function () {
    $(this).closest('.copy-card').removeClass('show')
    let selectEle = $(this).
        closest('.weekly-content').
        find('.session-times').
        find('select')
    // check for slot is empty
    if (selectEle.length == 0) {
        $(this).
            closest('.menu-content').
            find('.copy-label .form-check-input:checked').
            each(function () {
                let weekEle = $(`.weekly-content[data-day="${$(this).val()}"]`)
                $(weekEle).find('.session-times').html('')
                weekEle.find('.weekly-row').find('.unavailable-time').remove()
                weekEle.find('.weekly-row').
                    append('<div class="unavailable-time">Unavailable</div>')
                let dayChk = $(weekEle).
                    find('.weekly-row').
                    find('input[name="checked_week_days[]"')
                dayChk.prop('checked', false).prop('disabled', true)
            })
    } else {
        selectEle.each(function () {
            $(this).select2('destroy')
        })
        let selects = $(this).
            closest('.weekly-content').
            find('.session-times').
            find('select')
        let $cloneEle = $(this).
            closest('.weekly-content').
            find('.session-times').
            clone()
        $(this).
            closest('.menu-content').
            find('.copy-label .form-check-input:checked').
            each(function () {
                let $cloneEle2 = $cloneEle
                let currentDay = $(this).val()
                let weekEle = `.weekly-content[data-day="${currentDay}"]`
                $cloneEle2.find('select[name^="from_time"]').
                    attr('name', `from_time[${currentDay}][]`)
                $cloneEle2.find('select[name^="to_time"]').
                    attr('name', `to_time[${currentDay}][]`)
                $(weekEle).find('.unavailable-time').html('')
                $cloneEle2.find('.error-msg').html('')
                $(weekEle).find('.session-times').html($cloneEle2.html())
                $(weekEle).find('.session-times select').select2()
                $(weekEle).
                    find('input[name="checked_week_days[]"').
                    prop('disabled', false).prop('checked', true)
                $(selects).each(function (i) {
                    let select = this
                    $(weekEle).
                        find('.session-times').
                        find('select').
                        eq(i).
                        val($(select).val()).
                        trigger('change')
                })
            })

        $(this).
            closest('.weekly-content').
            find('.session-times').
            find('select').
            each(function () {
                $(this).select2()
            })
        $('.copy-check-input').prop('checked', false)
    }
    $('.copy-menu, .copy-days-btn').removeClass('show')
})

listenClick('.deleteBtn', function () {
    let selectedIndex = 0
    if ($(this).closest('.timeSlot').prev().length > 0) {
        selectedIndex = $(this).
            closest('.timeSlot').
            prev().
            children('.add-slot').
            find('select[name^="to_time"] option:selected')[0].index
    }

    if ($(this).
        closest('.weekly-row').
        find('.session-times').
        find('select').length == 2) {
        let dayChk = $(this).
            closest('.weekly-row').
            find('input[name="checked_week_days[]"')
        dayChk.prop('checked', false).prop('disabled', true)
        $(this).
            closest('.weekly-row').
            append('<div class="unavailable-time">Unavailable</div>')
    }

    let startTimeOptions = $(this).
        closest('.timeSlot').
        next().
        children('.add-slot').
        find('select[name^="from_time"] option')
    startTimeOptions.each(function (index) {
        if (index <= selectedIndex) {
            $(this).attr('disabled', true)
        } else {
            $(this).attr('disabled', false)
        }
    })

    $(this).parent().siblings('.error-msg').remove()
    $(this).parent().closest('.timeSlot').remove()
    $(this).parent().remove()
})

listenChange('select[name^="from_time"]', function () {
    let selectedIndex = $(this)[0].selectedIndex
    let endTimeOptions = $(this).
        closest('.add-slot').
        find('select[name^="to_time"] option')
    let endSelectedIndex = $(this).
        closest('.add-slot').
        find('select[name^="to_time"] option:selected')[0].index
    if (selectedIndex >= endSelectedIndex) {
        endTimeOptions.eq(selectedIndex + 1).
            prop('selected', true).
            trigger('change')
    }
    endTimeOptions.each(function (index) {
        if (index <= selectedIndex) {
            $(this).attr('disabled', true)
        } else {
            $(this).attr('disabled', false)
        }
    })
})

listenChange('select[name^="to_time"]', function () {
    let selectedIndex = $(this)[0].selectedIndex
    let startTimeOptions = $(this).
        closest('.timeSlot').
        next().
        find('select[name^="from_time"] option')
    startTimeOptions.each(function (index) {
        if (index <= selectedIndex) {
            $(this).attr('disabled', true)
        } else {
            $(this).attr('disabled', false)
        }
    })
})

listenClick('.add-schedule-name', function () {
    $('#addScheduleNameModal').modal('show').append('body')
})

listenSubmit('#scheduleNameForm', function (e) {
    e.preventDefault()
    if ($('#scheduleName').val() == '') {
        displayErrorMessage(Lang.get('js.schedule_name'))
        return false
    }

    let checkTab = $('.tab-pane').find('.active').attr('data-id')
    $('#checkTabId').val(checkTab)

    let formData = new FormData
    formData.append('form1', $('#scheduleNameForm').serialize())
    formData.append('form2', $('#addEventScheduleForm').serialize())
    let loadingButton = jQuery(this).find('#scheduleNameBtn')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)

    $.ajax({
        url: route('schedules.store'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            let eventId = result.data.event_id
            let schedule = result.data.schedule
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#addScheduleNameModal').modal('hide')
                $(loadingButton).attr('disabled', false)
                if (result.data.scheduleWithTime === false) {
                    let data = {
                        id: schedule.id,
                        name: schedule.schedule_name,
                    }

                    let newOption = new Option(data.name, data.id, false, true)
                    $('#scheduleNameId').append(newOption).trigger('change')
                    $('#scheduleNameForm')[0].reset()
                    $('#pills-existing-tab').click()
                } else {
                    window.location.href = route('events.edit', eventId)
                }
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $(loadingButton).attr('disabled', false)
        },
    })

})

listenClick('#eventScheduleBtnSave', function (e) {
    e.preventDefault()
    let checkTab = $('.tab-pane').find('.active').attr('data-id')
    $('#checkTabId').val(checkTab)

    if ($('#slotTimeId').val() == '') {
        displayErrorMessage(Lang.get('js.slot_time'))
        return false
    }
    $('#eventScheduleBtnSave').attr('disabled', true)

    $.ajax({
        url: route('add.event.schedule'),
        type: 'POST',
        data: $('#addEventScheduleForm').serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                window.location.href = route('events.index')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $('#eventScheduleBtnSave').attr('disabled', false)
        },
    })

})

listenChange('.change-schedule', function () {
    let scheduleId = $(this).val()

    $.ajax({
        url: route('get.time.by.schedule'),
        data: { schedule_id: scheduleId, event_id: eventId },
        success: function (data) {
            $('.existing-schedule').children('.maincard-section').empty()
            $('.existing-schedule').append(data.data)
        },
    })
})
