// open brand modal code
listenClick('.add-brand', function () {
    $('#createBrandModal').modal('show').appendTo('body')
})

// edit brand modal code
listenClick('.brand-edit-btn', function () {
    let id = $(this).attr('data-id')
    renderData(id)
})

function renderData (id) {
    $.ajax({
        url: route('brands.edit', id),
        type: 'GET',
        success: function (result) {
            if (result.success) {
                $('#brandID').val(result.data.id)
                let brandLogo = result.data.brand_logo
                $('#editBrandLogo').
                    css('background-image', 'url("' + brandLogo + '")')
                $('#editBrandModal').modal('show').appendTo('body')
            }
        },
    })
}

// add brand modal code
listenSubmit('#createBrandForm', function (e) {
    e.preventDefault()
    let loadingButton = jQuery(this).find('#addBrandBtn')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)
    let formData = new FormData(this)

    $.ajax({
        url: route('brands.store'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#createBrandModal').modal('hide')
                $(loadingButton).attr('disabled', false)
                Livewire.dispatch('refresh')
            }
        },
        error: function (result) {
            $(loadingButton).attr('disabled', false);
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

// update brand modal code
listenSubmit('#editBrandForm', function (e) {
    e.preventDefault()
    let loadingButton = jQuery(this).find('#editBrandBtn')
    loadingButton.button('loading')
    $(loadingButton).attr('disabled', true)

    let formData = new FormData(this)
    let id = $('#brandID').val()

    $.ajax({
        url: 'brands/' + id + '/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
            $('#editBrandModal').modal('hide')
            $(loadingButton).attr('disabled', false);
            displaySuccessMessage(result.message)
            Livewire.dispatch('refresh')
        },
        error: function (result) {
            $(loadingButton).attr('disabled', false)
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

// delete brand record code
listenClick('.brand-delete-btn', function () {
    let recordId = $(this).attr('data-id')
    deleteItem(route('brands.destroy', recordId),
        Lang.get('js.front_band'))
})

// reset brand modal code
listenHiddenBsModal('#createBrandModal', function () {
    $('#bgImage').css('background-image', 'url(' + defaultImage + ')')
    resetModalForm('#createBrandForm', '#createBrandValidationErrorsBox')
})

listenHiddenBsModal('#editBrandModal', function () {
    resetModalForm('#editBrandForm', '#editBrandValidationErrorsBox')
})
