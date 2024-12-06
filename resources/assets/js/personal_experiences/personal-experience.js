// open personal experience modal code
listenClick('.add-personal-experience', function () {
    $('#createPersonalExperienceModal').modal('show').appendTo('body')
})

// edit personal experience modal code
listenClick('.personal-exp-edit-btn', function () {
    let editPersonalExpId = $(this).attr('data-id')
    renderData(editPersonalExpId)
})

// render personal experience  code
function renderData (id) {
    $.ajax({
        url: route('personal-experiences.edit', id),
        type: 'GET',
        success: function (result) {
            $('#personalExperienceID').val(result.data.id);
            $('#editName').val(result.data.name);
            $('#editPersonalExperienceModal').modal('show');
        },
    });
}

// add personal experience modal code
listenSubmit('#createPersonalExperienceForm', function (e) {
    e.preventDefault()
    let loadingButton = $(this).find('#btnSave')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)

    $.ajax({
        url: route('personal-experiences.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $('#createPersonalExperienceModal').modal('hide');
                Livewire.dispatch('refresh')
                $(loadingButton).attr('disabled', false);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $(loadingButton).attr('disabled', false);
        },
    });
});

// update personal experience modal code
listenSubmit('#editPersonalExperienceForm', function (e) {
    e.preventDefault()
    let loadingButton = $(this).find('#editBtnSave')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)

    let id = $('#personalExperienceID').val()

    $.ajax({
        url: route('personal-experiences.update', id),
        type: 'PUT',
        data: $(this).serialize(),
        success: function (result) {
            $('#editPersonalExperienceModal').modal('hide')
            $(loadingButton).attr('disabled', false)
            displaySuccessMessage(result.message)
            Livewire.dispatch('refresh')
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
            $(loadingButton).attr('disabled', false)
        },
    });
});

// delete personal experience record code
listenClick('.personal-exp-delete-btn', function () {
    let personalExperienceId = $(this).attr('data-id')
    deleteItem(route('personal-experiences.destroy', personalExperienceId),
        Lang.get('js.personal_experience'))
})

// reset personal experience modal code
listenHiddenBsModal('#createPersonalExperienceModal', function () {
    resetModalForm('#createPersonalExperienceForm',
        '#createPersonalExperienceValidationErrorsBox')
})
