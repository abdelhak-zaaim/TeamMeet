listenClick('#createCurrency', function () {
    $('#createCurrencyModal').modal('show').appendTo('body')
})

listen('hidden.bs.modal', '#createCurrencyModal', function () {
    resetModalForm('#createCurrencyForm', '#createCurrencyValidationErrorsBox')
})

listen('hidden.bs.modal', '#editCurrencyModal', function () {
    resetModalForm('#editCurrencyForm', '#editCurrencyValidationErrorsBox')
})

listenClick('.currency-edit-btn', function () {
    let editCurrencyId = $(this).attr('data-id')
    renderData(editCurrencyId)
})

function renderData (id) {
    $.ajax({
        url: route('currencies.edit', id),
        type: 'GET',
        success: function (result) {
            $('#currencyID').val(result.data.id)
            $('#editCurrency_Name').val(result.data.currency_name)
            $('#editCurrency_Icon').val(result.data.currency_icon)
            $('#editCurrency_Code').val(result.data.currency_code)

            $('#editCurrencyModal').modal('show')
        },
    })
}

listenSubmit('#createCurrencyForm', function (e) {
    e.preventDefault()
    $.ajax({
        url: route('currencies.store'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                $('#createCurrencyModal').modal('hide')
                Livewire.dispatch('refresh')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

listenSubmit('#editCurrencyForm', function (e) {
    e.preventDefault()
    let updateCurrencyId = $('#currencyID').val()
    $.ajax({
        url: route('currencies.update', updateCurrencyId),
        type: 'PUT',
        data: $(this).serialize(),
        success: function (result) {
            $('#editCurrencyModal').modal('hide')
            displaySuccessMessage(result.message)
            Livewire.dispatch('refresh')
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
        complete: function () {
        },
    })
})

listenClick('.currency-delete-btn', function () {
    let currencyRecordId = $(this).attr('data-id')
    deleteItem(route('currencies.destroy', currencyRecordId), Lang.get('js.currency'))
})
