let passed = false

listenSubmit('#checkOTPForm', function (e) {
    if (!passed) {
        e.preventDefault()
    } else {
        return true
    }

    passed = true

    $('#checkOTPForm')[0].submit()

    $('#checkOTP').prop('disabled', true)
})
