document.addEventListener('turbo:load', loadUserProfileData)

function loadUserProfileData () {
    if (!$('.select-language').length) {
        return
    }

    $('.select-language').select2({
        dropdownParent: $('#changeLanguageModal')
    })

    if (!$('#userTimeZoneId').length) {
        return
    }

    $('#userTimeZoneId').select2()
}

listenClick('#changePassword', function () {
    $('#changePasswordModal').modal('show').appendTo('body')
})

listenClick('#changeLanguage', function () {
    $('#changeLanguageModal').modal('show').appendTo('body')
})

listenSubmit('#changeLanguageForm', function (event) {
    event.preventDefault()
    let loadingButton = jQuery(this).find('#languageChangeBtn')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)
    $.ajax({
        url: route('update-language'),
        type: 'PUT',
        data: $('#changeLanguageForm').serialize(),
        success: function (result) {
            $('#changeLanguageModal').modal('hide')
            $(loadingButton).attr('disabled', false);
            displaySuccessMessage(result.message);
            setTimeout(function () {
                location.reload()
            }, 1000)
            $('#selectLanguage').trigger('change');
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message);
            $(loadingButton).attr('disabled', false);
        },
    });
});

listenClick('#passwordChangeBtn', function () {
    let loadingButton = jQuery(this).find('#passwordChangeBtn')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)
    $.ajax({
        url: route('user.changePassword'),
        type: 'PUT',
        data: $('#changePasswordForm').serialize(),
        success: function (result) {
            $('#changePasswordModal').modal('hide')
            $(loadingButton).attr('disabled', false)
            displaySuccessMessage(result.message)
        },
        error: function error (result) {
            displayErrorMessage(result.responseJSON.message)
            $(loadingButton).attr('disabled', false)

        },
    });
});

window.printErrorMessage = function (selector, errorResult) {
    $(selector).show().html('');
    $(selector).text(errorResult.responseJSON.message);
};

listenClick('.changeLanguage', function () {
    let languageName = $(this).data('prefix-value')

    $.ajax({
        type: 'POST',
        url: updateLanguageURL,
        data: { languageName: languageName },
        success: function (result) {
            displaySuccessMessage(result.message)
            setTimeout(function () {
                location.reload()
            }, 1000)
        },
    });
});

listenSubmit('#profileId', function () {
    if ($('#error-msg').text() !== '') {
        $('#phoneNumber').focus()
        displayErrorMessage(Lang.get('js.contact_number_is') + $('#error-msg').text())
        return false
    }
    $('#profileSaveBtn').attr('disabled', true)
})

// change password modal reset code
listenHiddenBsModal('#changePasswordModal', function () {
    resetModalForm('#changePasswordForm',
        '#editPasswordValidationErrorsBox')
})

listenClick('#emailNotification', function () {
    $('#emailNotificationModal').modal('show').appendTo('body')
})
