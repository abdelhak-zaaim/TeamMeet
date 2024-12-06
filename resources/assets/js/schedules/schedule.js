document.addEventListener('turbo:load', loadScheduleData)

function loadScheduleData () {
    if (!$('#scheduleNameId').length || !$('.startTimeSlot').length ||
        !$('.endTimeSlot').length) {
        return
    }

    $('#scheduleNameId').select2({
        width: '250px',
    })

    $('.startTimeSlot').select2({
        width: '100%',
    })

    $('.endTimeSlot').select2({
        width: '100%',
    })
}

document.addEventListener('livewire:load', function () {
    window.livewire.hook('message.processed', () => {
        if (!$('.startTimeSlot').length || !$('.endTimeSlot').length) {
            return
        }

        $('.startTimeSlot').each(function () {
            $(this).select2()
        })
        $('.endTimeSlot').each(function () {
            $(this).select2()
        })
    })
})

// Store Schedule
listenSubmit('#addScheduleTimeForm', function (e) {
    e.preventDefault()
    $('#scheduleSaveButton').attr('disabled', true)

    let scheduleId = $('#scheduleNameId').val()
    let formData = new FormData($(this)[0])
    formData.append('schedule_id', scheduleId)

    $.ajax({
        url: route('add.schedule.time.slot'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            displaySuccessMessage(result.message);
            $('#scheduleSaveButton').attr('disabled',false)
            window.location.href = route('schedules.index');
        },
        error: function (result) {
            displayErrorMessage(result.message)
            $('#scheduleSaveButton').attr('disabled',false)
        },
    });
});

listenClick('.edit-schedule', function () {
    let id = $(this).attr('data-id')
    renderData(id)
})

function renderData (id) {
    $.ajax({
        url: route('schedules.edit', id),
        type: 'GET',
        success: function (result) {
            $('#editScheduleId').val(result.data.id);
            $('#isDefaultId').val(result.data.is_default);
            $('#editScheduleNameId').val(result.data.schedule_name);
            if (result.data.status == 1) {
                $('#editStatusId').prop('checked', true);
            } else {
                $('#editStatusId').prop('checked', false);
            }

            $('#editScheduleNameModal').modal('show').appendTo('body')
        },
    });
}

// Edit Schedule
listenSubmit('#editScheduleNameForm', function (e) {
    e.preventDefault()
    let loadingButton = jQuery(this).find('#editScheduleNameBtn')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)
    let formData = $(this).serialize()
    let id = $('#editScheduleId').val()
    let isDefault = $('#isDefaultId').val()

    if (isDefault == 1) {
        displayErrorMessage(
            Lang.get('js.default_schedule'))
        return false;
    }

    $.ajax({
        url: route('schedules.update', id),
        type: 'PUT',
        data: formData,
        success: function (result) {
            $('#scheduleNameId').empty();
            $.each(result.data, function (el, val) {
                $('#scheduleNameId').
                    append(`<option value="${el}">${val}</option>`);
            });
            $('#editScheduleNameModal').modal('hide');
            $(loadingButton).attr('disabled', false);
            displaySuccessMessage(result.message);
            $('#scheduleNameId').val(id).trigger('change');
            Livewire.dispatch('filterUserSchedule', {scheduleId:id});
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $(loadingButton).attr('disabled', false);
        },
    });
});

listenChange('#scheduleNameId', function () {
    setTimeout(function () {
        $('select[name^="from_time"]').trigger('change')
        $('select[name^="to_time"]').trigger('change')
    }, 1000)
    Livewire.dispatch('filterUserSchedule', {scheduleId : $(this).val()});
})

// delete schedule code
listenClick('.delete-schedule', function () {
    let scheduleId = $(this).attr('data-id')

    let callFunction = arguments.length > 3 && arguments[3] !== undefined
        ? arguments[3]
        : null
    swal({
        title: 'Delete !',
        text: Lang.get('js.sure_delete') + ' "' +
            Lang.get('js.schedule') + '"  ?',
        buttons: {
            confirm: Lang.get('js.yes'),
            cancel: Lang.get('js.no'),
        },
        icon: sweetAlertIcon,
        reverseButtons: true,
    }).then(function (willDelete) {
        if (willDelete) {
            $.ajax({
                url: route('schedules.destroy', scheduleId),
                type: 'DELETE',
                dataType: 'json',
                success: function (obj) {
                    if (obj.success) {
                        window.location.reload()
                    }
                    swal({
                        icon: 'success',
                        confirmButtonColor: '#ADB5BD',
                        title: deleteMsg + ' !',
                        text: Lang.get('js.schedule') + ' ' +
                            hasBeenDeleted,
                        timer: 2000,
                    })
                    if (callFunction) {
                        eval(callFunction);
                    }
                },
                error: function (data) {
                    swal({
                        title: 'Error',
                        icon: 'error',
                        text: data.responseJSON.message,
                        type: 'error',
                        timer: 4000,
                    })
                },
            });
        }
    })
})

listenHiddenBsModal('#addScheduleNameModal', function () {
    resetModalForm('#scheduleNameForm', '#scheduleValidationErrorsBox')
})
