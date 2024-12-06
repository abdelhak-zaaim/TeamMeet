document.addEventListener('turbo:load', loadSubscriptionData)

function loadSubscriptionData () {
    if (!$('#paymentType').length) {
        return
    }

    $('#paymentType').select2()
}

window.paymentMessage = function (data = null) {
    let toastData = $('#toastDataId').val()
    toastData = data != null ? data : toastData
    if (!isEmpty(toastData)) {
        setTimeout(function () {
            swal({
                title: toastData.toastType,
                icon: toastData.toastType,
                text: toastData.toastMessage,
                type: 'success',
                timer: 4000,
            })
        }, 1000)
    }
}
paymentMessage()
