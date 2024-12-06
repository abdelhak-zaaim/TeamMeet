document.addEventListener('turbo:load', loadSettingData)

function loadSettingData() {
    let stripeCheckbox = $('#stripeCheckboxBtn').is(':checked');
    if (stripeCheckbox) {
        $('.stripe_div').removeClass('d-none');
    } else {
        $('.stripe_div').addClass('d-none');
    }

    let CaptchaCheckbox = $('#captchaEnableAdmin').is(':checked')
    if (CaptchaCheckbox) {
        $('.captcha-div').removeClass('d-none')
    } else {
        $('.captcha-div').addClass('d-none')
    }

    let paystackCheckbox = $('#paystackCheckboxBtn').is(':checked');
    if (paystackCheckbox) {
        $('.paystack_div').removeClass('d-none');
    } else {
        $('.paystack_div').addClass('d-none');
    }

    let paypalCheckbox = $('#paypalCheckboxBtn').is(':checked');
    if (paypalCheckbox) {
        $('.paypal_div').removeClass('d-none')
    } else {
        $('.paypal_div').addClass('d-none')
    }

    let razorpayCheckbox = $('#razorpayCheckboxBtn').is(':checked');
    if (razorpayCheckbox) {
        $('.razorpay_div').removeClass('d-none');
    } else {
        $('.razorpay_div').addClass('d-none');
    }

    if (!$('#settingCurrencyId').length) {
        return
    }

    $('#settingCurrencyId').select2()

    let input = document.querySelector('#defaultCountryData')
    let intl = window.intlTelInput(input, {
        initialCountry: defaultCountryCodeValue,
        separateDialCode: true,
        preferredCountries: false,
        geoIpLookup: function (success, failure) {
            $.get('https://ipinfo.io', function () {
            }, 'jsonp').always(function (resp) {
                var countryCode = (resp && resp.country)
                    ? resp.country
                    : ''
                success(countryCode)
            })
        },
        utilsScript: '../../public/assets/js/inttel/js/utils.min.js',
    })

    let getCode = intl.selectedCountryData['name'] + '+' +
        intl.selectedCountryData['dialCode']
    $('#defaultCountryData').val(getCode)
}

listenChange('#autoDetectLocation', function () {
    let isChecked = $(this).is(':checked')
    if (isChecked) {
        $('.place-api-div').removeClass('d-none')
    } else {
        $('.place-api-div').addClass('d-none')
    }
})

listenSubmit('#generalSettingForm', function (e) {
    e.preventDefault()

    let checked = $('#autoDetectLocation').is(':checked')
    if (checked && $('#googlePlaceApiKey').val() == '') {
        displayErrorMessage(
            Lang.get('js.enter_google_api'))
        return false
    }
    let captchaCheckbox = $('#captchaEnableAdmin').is(':checked');
    if (captchaCheckbox) {
        if ($('#captchaKey').val().trim() == '') {
            displayErrorMessage(Lang.get('js.captcha_key'))
            return false
        }
        else if ($('#captchaSecret').val().trim() == '') {
            displayErrorMessage(Lang.get('js.captcha_secret'))
            return false
        }
    }

    $('#generalSettingForm')[0].submit()
    $('#settingSaveBtn').attr('disabled', true)
})

listenClick('.iti__standard', function () {
    $('#defaultCountryData').val($(this).text())
    $(this).attr('data-country-code')
    $('#defaultCountryCode').val($(this).attr('data-country-code'))
})

listenChange('#stripeCheckboxBtn', function () {
    let stripeCheckboxIsChecked = $(this).is(':checked')
    if (stripeCheckboxIsChecked) {
        $('.stripe_div').removeClass('d-none')
    } else {
        $('.stripe_div').addClass('d-none')
    }
})

listenChange('#paypalCheckboxBtn', function () {
    let paypalCheckboxIsChecked = $(this).is(':checked')
    if (paypalCheckboxIsChecked) {
        $('.paypal_div').removeClass('d-none')
    } else {
        $('.paypal_div').addClass('d-none')
    }
})


listenChange('#paystackCheckboxBtn', function () {
    let paystackCheckboxIsChecked = $(this).is(':checked');
    if (paystackCheckboxIsChecked) {
        $('.paystack_div').removeClass('d-none');
    } else {
        $('.paystack_div').addClass('d-none');
    }
});

listen('change', '#captchaEnableAdmin', function () {
    let googleCaptcha = $('#captchaEnableAdmin').is(':checked')
    if (googleCaptcha) {
        $('.captcha-div').removeClass('d-none')
    } else {
        $('.captcha-div').addClass('d-none')
    }
})

listenChange('#razorpayCheckboxBtn', function () {
    let razorpayIsChecked = $(this).is(':checked')
    if (razorpayIsChecked) {
        $('.razorpay_div').removeClass('d-none');
    } else {
        $('.razorpay_div').addClass('d-none');
    }
})

listenSubmit('#credentialsSettings', function (e) {
    e.preventDefault()
    let stripeCheckbox = $('#stripeCheckboxBtn').is(':checked')
    let paypalCheckbox = $('#paypalCheckboxBtn').is(':checked')
    let paystackCheckbox = $('#paystackCheckboxBtn').is(':checked');
    let razorpayCheckbox = $('#razorpayCheckboxBtn').is(":checked");


    let emptyStripeKey = $('#stripeKey').val().trim()
    let emptyStripeSecret = $('#stripeSecret').val().trim()

    if (stripeCheckbox) {
        if (isEmpty(emptyStripeKey)) {
            displayErrorMessage(Lang.get('js.stripe_key'))
            return false;
        } else if (isEmpty(emptyStripeSecret)) {
            displayErrorMessage(Lang.get('js.stripe_secret'))
            return false;
        }
    }

    let emptyPaypalId = $('#paypalClientId').val().trim();
    let emptyPaypalSecret = $('#paypalSecret').val().trim();
    let emptyPaypalMode = $('#paypalMode').val().trim();

    if (paypalCheckbox) {
        if (isEmpty(emptyPaypalId)) {
            displayErrorMessage(Lang.get('js.paypal_client'))
            return false;
        } else if (isEmpty(emptyPaypalSecret)) {
            displayErrorMessage(Lang.get('js.paypal_secret'))
            return false;
        } else if (isEmpty(emptyPaypalMode)) {
            displayErrorMessage(Lang.get('js.paypal_mode'))
            return false;
        }
    }

    let emptyPaystackKey = $('#paystackKey').val().trim()
    let emptyPaystackSecret = $('#paystackSecret').val().trim()


    if (paystackCheckbox) {
        if (isEmpty(emptyPaystackKey)) {
            displayErrorMessage(Lang.get('js.paystack_key'))
            return false;
        } else if (isEmpty(emptyPaystackSecret)) {
            displayErrorMessage(Lang.get('js.paystack_secret'))
            return false;
        }
    }

    //RazorPay Field Validation
    let emptyRazorpayKey = $('#razorpayKey').val().trim();
    let emptyRazorpaSecret = $('#razorpaSecret').val().trim();

    if (razorpayCheckbox) {
        if (isEmpty(emptyRazorpayKey)) {
            displayErrorMessage(Lang.get('js.razorpay_key'));
            return false;
        } else if (isEmpty(emptyRazorpaSecret)) {
            displayErrorMessage(Lang.get('js.razorpay_secret'));
            return false;
        }

    }



    $('#credentialSettingBtn').attr('disabled', true)
    $('#credentialsSettings')[0].submit();
});
