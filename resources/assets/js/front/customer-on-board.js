'use strict'

$(document).ready(function () {
    $('#fromTime, #toTime').select2()
    $('#customerTimeZoneId').select2()
})

// timezone detect automatic
let timezone = jstz.determine();
document.cookie = 'timezoneName=' + timezone.name();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
})

listenSubmit('#frontCustomerOnBoardForm1', function (e) {
    e.preventDefault()
    if ($('#domainUrlId').val() == '') {
        displayErrorMessage(Lang.get('js.domain_url'))
        return false
    } else if ($('#timeZoneId').val() == '') {
        displayErrorMessage(Lang.get('js.timezone'))
        return false
    }

    $.ajax({
        url: route('customer.onboard.store'),
        type: 'POST',
        data: $('#frontCustomerOnBoardForm1').serialize(),
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                if (result.message != '') {
                    displaySuccessMessage(result.message)
                }
                window.location.reload()
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenSubmit('#frontCustomerOnBoardForm2', function (e) {
    e.preventDefault()
    if ($('#domainUrlId').val() == '') {
        displayErrorMessage(Lang.get('js.domain_url'))
        return false
    } else if ($('#timeZoneId').val() == '') {
        displayErrorMessage(Lang.get('js.timezone'))
        return false
    }
    if ($('#fromTime').val() == '') {
        displayErrorMessage(Lang.get('js.from_time'))
        return false
    } else if ($('#toTime').val() == '' || $('#toTime').val() == null) {
        displayErrorMessage(Lang.get('js.to_time'))
        return false
    } else if ($('input[name="day_of_week[]"]:checked').length === 0) {
        displayErrorMessage(Lang.get('js.day_of_week'))
        return false
    }

    $.ajax({
        url: route('customer.onboard.store'),
        type: 'POST',
        data: $('#frontCustomerOnBoardForm2').serialize(),
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                if (result.message != '') {
                    displaySuccessMessage(result.message)
                }
            }
            window.location.reload()
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenSubmit('#frontCustomerOnBoardForm3', function (e) {
    e.preventDefault()
    if ($('#domainUrlId').val() == '') {
        displayErrorMessage(Lang.get('js.domain_url'))
        return false
    } else if ($('#timeZoneId').val() == '') {
        displayErrorMessage(Lang.get('js.timezone'))
        return false
    }
    if ($('#fromTime').val() == '') {
        displayErrorMessage(lang.get('js.from_time'))
        return false
    } else if ($('#toTime').val() == '' || $('#toTime').val() == null) {
        displayErrorMessage(Lang.get('js.to_time'))
        return false
    } else if ($('input[name="day_of_week[]"]:checked').length === 0) {
        displayErrorMessage(Lang.get('js.day_of_week'))
        return false
    }
    if ($('input[name="personal_experience_id"]:checked').length === 0) {
        displayErrorMessage(Lang.get('js.personal_experience'))
        return false
    }

    $.ajax({
        url: route('customer.onboard.store'),
        type: 'POST',
        data: $('#frontCustomerOnBoardForm3').serialize(),
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                if (result.message != '') {
                    displaySuccessMessage(result.message)
                }
                if (userRole) {
                    window.location.href = route('dashboard')
                } else {
                    window.location.href = route('admin.dashboard')
                }
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listen('keypress', '#domainUrlId', function (e) {
    if (e.keyCode === 32 || e.keyCode === 95) {
        return false
    }
    let keyCode = e.keyCode || e.which
    let regex = /^[A-Za-z0-9\-]+$/
    let isValid = regex.test(String.fromCharCode(keyCode))
    if (!isValid) {
        return false
    }
})

listenClick('#checkAllDays', function () {
    if ($(this).is(':checked')) {
        $('.day-of-week').each(function () {
            $(this).prop('checked', true)
        })
    } else {
        $('.day-of-week').each(function () {
            $(this).prop('checked', false)
        })
    }
})

listenChange('select[name^="from_time"]', function (e) {
    let selectedIndex = $(this)[0].selectedIndex
    let endTimeOptions = $(this).
        closest('.on-board-time').
        find('select[name^="to_time"] option')
    let endSelectedIndex = $(this).
        closest('.on-board-time').
        find('select[name^="to_time"] option:selected')[0].index
    if (selectedIndex === 24) {
        endTimeOptions.eq(0).
            prop('selected', true).
            trigger('change');
    }
    if (selectedIndex >= endSelectedIndex) {
        endTimeOptions.eq(selectedIndex + 1).
            prop('selected', true).
            trigger('change');
    }
    endTimeOptions.each(function (index) {
        if (index <= selectedIndex) {
            $(this).attr('disabled', true);
        } else {
            $(this).attr('disabled', false);
        }
    });
});

listenChange('[name^="day_of_week[]"]', function () {
    let checkBoxCheck = $('[name^="day_of_week[]"]:checked').length
    if (checkBoxCheck == 7) {
        $('#checkAllDays').prop('checked', true)
    } else {
        $('#checkAllDays').prop('checked', false)
    }
})
