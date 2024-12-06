document.addEventListener("DOMContentLoaded", loadPhoneNumberCountryCode2);

function loadPhoneNumberCountryCode2() {
    if (!$("#phoneNumber").length) {
        return false;
    }

    let input = document.querySelector("#phoneNumber"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

    if ($("#valid-msg").length > 0) {
        setTimeout(function () {
            $("#valid-msg").addClass("d-none");
        }, 10);
    }

    let errorMap = [
        Lang.get("js.invalid_number"),
        Lang.get("js.invalid_country_code"),
        Lang.get("js.too_short"),
        Lang.get("js.too_long"),
        Lang.get("js.invalid_number"),
    ];

    // initialise plugin
    let intl2 = window.intlTelInput(input, {
        initialCountry: defaultCountryCodeValue,
        separateDialCode: true,
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () {}, "jsonp").always(
                function (resp) {
                    let countryCode = resp && resp.country ? resp.country : "";
                    success(countryCode);
                }
            );
        },
        utilsScript: "../../public/assets/js/inttel/js/utils.min.js",
    });

    let reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("d-none");
        validMsg.classList.add("d-none");
    };

    input.addEventListener("blur", function () {
        reset();
        if (input.value.trim()) {
            if (intl2.isValidNumber()) {
                validMsg.classList.remove("d-none");
            } else {
                input.classList.add("error");
                let errorCode = intl2.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("d-none");
            }
        }
    });

    // on keyup / change flag: reset
    input.addEventListener("change", reset);
    input.addEventListener("keyup", reset);

    if (typeof phoneNo != "undefined" && phoneNo !== "") {
        setTimeout(function () {
            $("#phoneNumber").trigger("change");
        }, 500);
    }

    $("#phoneNumber").on("blur keyup change countrychange", function () {
        if (typeof phoneNo != "undefined" && phoneNo !== "") {
            intl2.setNumber("+" + phoneNo);
            phoneNo = "";
        }
        let getCode = intl2.selectedCountryData["dialCode"];
        $("#prefix_code").val(getCode);
    });

    let getCode = intl2.selectedCountryData["dialCode"];
    $("#prefix_code").val(getCode);

    let getPhoneNumber = $("#phoneNumber").val();
    let removeSpacePhoneNumber = getPhoneNumber.replace(/\s/g, "");
    $("#phoneNumber").val(removeSpacePhoneNumber);

    $("#phoneNumber").focus();
    $("#phoneNumber").trigger("blur");
}

let paymentType = "";

listenSubmit("#addEventSlotScheduleForm", function (e) {
    e.preventDefault();
    let eventLocationArr = [];
    if (locationMeta[1] == 1) {
        if ($("#phoneNumber").val() == "") {
            $("#phoneNumber").focus();
            displayErrorMessage(Lang.get("js.phone_required"));
            return false;
        }

        eventLocationArr.push(eventLocation);
        eventLocationArr.push(locationMeta[1]);
        eventLocationArr.push(
            "+" + $("#prefix_code").val() + $("#phoneNumber").val()
        );
        $("#eventLocationPhoneCall").val(JSON.stringify(eventLocationArr));
    }

    paymentType = $("#slotPaymentType").val();
    let btnSubmitEle = $(this).find("#slotPaymentSubmitBtn");
    setBtnLoader(btnSubmitEle);

    $.ajax({
        url: route("scheduled-events.store"),
        type: "POST",
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                let scheduleEventId = result.data.scheduleEventId;
                let confirmPageUrl = result.data.redirectUrl;

                if (result.data.eventType == Paid) {
                    if (paymentType == 1) {
                        // stripe payment gateway
                        let sessionId = result.data[0].sessionId;
                        stripe
                            .redirectToCheckout({
                                sessionId: sessionId,
                            })
                            .then(function (result) {
                                manageAjaxErrors(result.message);
                            });
                    } else if (paymentType == 2) {
                        // Paypal payment gateway
                        $.ajax({
                            type: "GET",
                            url: route("paypal.init"),
                            data: { scheduleEventId: scheduleEventId },
                            success: function (result) {
                                if (result.status == "CREATED") {
                                    let redirectTo = "";

                                    $.each(result.links, function (key, val) {
                                        if (val.rel == "approve") {
                                            redirectTo = val.href;
                                        }
                                    });
                                    location.href = redirectTo;
                                } else {
                                    location.href = result.url;
                                }
                            },
                        });
                    } else if (paymentType == 3) {
                        $.ajax({
                            type: "GET",
                            url: route("paystack.init"),
                            data: { scheduleEventId: scheduleEventId },
                            success: function (result) {
                                if (result.url) {
                                    location.href = result.url;
                                } else {
                                    location.href = result.data.url;
                                }
                            },
                        });
                    }else if( paymentType == 4){
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: "POST",
                            url: route('user.event.razorpay.init'),
                            data: {
                                scheduleEventId: scheduleEventId,
                                _token: csrfToken
                            }, success: function (result) {
                                if (result.url) {
                                    window.location.href = result.url;
                                }
                                if (result.success) {
                                    console.log(result.data);
                                    let { id, amount, name, email, contact, scheduleEventId } = result.data;
                                    options.amount = amount;
                                    options.order_id = id;
                                    options.prefill.name = name;
                                    options.prefill.email = email;
                                    options.prefill.contact = contact;
                                    options.prefill.scheduleEventId = scheduleEventId;
                                    let razorPay = new Razorpay(options);
                                    razorPay.open();
                                }
                            },
                            error: function (result) {
                                displayErrorMessage(result.responseJSON.message);
                            },
                            complete: function () {},
                        });
                    }
                } else {
                    $("#addEventSlotScheduleForm")[0].reset();
                    displaySuccessMessage(result.message);
                    window.location.href = confirmPageUrl;
                }
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            setBtnLoader(btnSubmitEle);
        },
    });
});
