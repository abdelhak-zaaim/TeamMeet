document.addEventListener('turbo:load', loadUserSettingData)

function loadUserSettingData() {
    let userStripeCheckbox = $('#userStripeCheckboxBtn').is(':checked')
    if (userStripeCheckbox) {
        $('.user_stripe_div').removeClass('d-none')
    } else {
        $('.user_stripe_div').addClass('d-none')
    }

    let userPaypalCheckbox = $('#userPaypalCheckboxBtn').is(':checked')
    if (userPaypalCheckbox) {
        $('.user_paypal_div').removeClass('d-none')
    } else {
        $('.user_paypal_div').addClass('d-none')
    }

    let userPaystackCheckbox = $('#userPaystackCheckboxBtn').is(':checked')
    if (userPaystackCheckbox) {
        $('.user_paystack_div').removeClass('d-none')
    } else {
        $('.user_paystack_div').addClass('d-none')
    }

    let userRazorpayCheckbox = $('#userRazorpayCheckboxBtn').is(':checked')
    if (userRazorpayCheckbox) {
        $('.user_razorpay_div').removeClass('d-none')
    } else {
        $('.user_razorpay_div').addClass('d-none')
    }
}

listenChange('#userStripeCheckboxBtn', function () {
    let userStripeCheckbox = $('#userStripeCheckboxBtn').is(':checked')
    if (userStripeCheckbox) {
        $('.user_stripe_div').removeClass('d-none')
    } else {
        $('.user_stripe_div').addClass('d-none')
    }
})

listenChange('#userPaypalCheckboxBtn', function () {
    let userPaypalCheckbox = $('#userPaypalCheckboxBtn').is(':checked')
    if (userPaypalCheckbox) {
        $('.user_paypal_div').removeClass('d-none')
    } else {
        $('.user_paypal_div').addClass('d-none')
    }
})


listenChange('#userPaystackCheckboxBtn', function () {
    let userPaystackCheckbox = $('#userPaystackCheckboxBtn').is(':checked')
    if (userPaystackCheckbox) {
        $('.user_paystack_div').removeClass('d-none')
    } else {
        $('.user_paystack_div').addClass('d-none')
    }
})

listenChange('#userRazorpayCheckboxBtn', function () {
    let usesrRazorpayCheckbox = $('#userRazorpayCheckboxBtn').is(':checked')
    if(usesrRazorpayCheckbox){
        $('.user_razorpay_div').removeClass('d-none')
    } else {
        $('.user_razorpay_div').addClass('d-none')
    }
})

// update user credentials setting code
listenSubmit('#UserCredentialsSettings', function (e) {
    e.preventDefault()
    let userStripeCheckbox = $('#userStripeCheckboxBtn').is(':checked')
    let userPaypalCheckbox = $('#userPaypalCheckboxBtn').is(':checked')
    let userPaystackCheckbox = $('#userPaystackCheckboxBtn').is(':checked')
    let userRazorpayCheckbox  = $('#userRazorpayCheckboxBtn').is(':checked')

    if (userStripeCheckbox && $('#UserStripeKey').val() == '') {
        displayErrorMessage(Lang.get('js.stripe_key'))
        return false
    }
    if (userStripeCheckbox && $('#UserStripeSecret').val() == '') {
        displayErrorMessage(Lang.get('js.stripe_secret'))
        return false
    }
    if (userPaypalCheckbox && $('#UserPaypalClientId').val() == '') {
        displayErrorMessage(Lang.get('js.paypal_client'))
        return false
    }
    if (userPaypalCheckbox && $('#userPaypalSecret').val() == '') {
        displayErrorMessage(Lang.get('js.paypal_secret'))
        return false
    }
    if (userPaypalCheckbox && $('#UserPaypalMode').val() == '') {
        displayErrorMessage(Lang.get('js.paypal_mode'))
        return false
    }
    if (userPaystackCheckbox && $('#UserPaystackKey').val() == '') {
        displayErrorMessage(Lang.get('js.paystack_key'))
        return false
    }
    if (userPaystackCheckbox && $('#UserPaystackSeceret').val() == '') {
        displayErrorMessage(Lang.get('js.paystack_secret'))
        return false
    }

    //RazorPay Validation Error Message
    if (userRazorpayCheckbox && $('#userRazorpayKey').val() == '') {
        displayErrorMessage(Lang.get('js.razorpay_key'));
        return false
    }
    if (userRazorpayCheckbox && $('#userRazorpayKey').val() == '') {
        displayErrorMessage(Lang.get('js.razorpay_secret'));
        return false
    }

    $('#credentialSaveBtn').attr('disabled', true)
    $('#UserCredentialsSettings')[0].submit()
})

listenSubmit('#generalUserSettingForm', function () {
    $('#generalSettingSaveBtn').attr('disabled', true)
    let calendarView = $('.img-border').attr('data-calendar-val')
    $('#calendarView').val(calendarView)
})

listenClick('.img-radio', function () {
    $('.img-radio').removeClass('img-border')
    $(this).addClass('img-border')
})
