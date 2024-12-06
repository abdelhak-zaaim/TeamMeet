document.addEventListener("turbo:load", loadSubscriptionsData);

function loadSubscriptionsData() {
    loadSelect2();
    if (!$("#paymentType").length) {
        return false;
    }

    $("#paymentType").trigger("change");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

// cash payment JS code
listenClick(".payment-by-cash", function () {
    let formData = new FormData();
    let planID = $(this).data("id");
    let paymentAttachment = $('input[type="file"]')[0].files[0];
    let note = $(".payment-note").val();
    formData.append("plan_id", planID);
    if (typeof paymentAttachment !== "undefined") {
        formData.append("payment_attachment", paymentAttachment);
    }

    formData.append("note", note);
    $(this).attr("disabled", true);

    $.ajax({
        url: route("cash.pay"),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.toastType == "success") {
                window.location.href = result.url;
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            $(this).attr("disabled", false);
        },
    });
});

listenClick(".subscribePlanWithoutPrice", function () {
    let formData = new FormData();
    let planID = $(this).data("id");
    let price = $(this).data("plan-price");
    formData.append("plan_id", planID);
    formData.append("price", price);
    $(this).attr("disabled", true);
    $.ajax({
        url: route("subscribe.plan.without.price"),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.toastType == "success") {
                window.location.href = result.url;
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {
            $(this).attr("disabled", false);
        },
    });
});

// check attachment file validation JS code
listenChange("#paymentAttachment", function () {
    let ext = $(this).val().split(".").pop().toLowerCase();
    if ($.inArray(ext, ["png", "jpg", "jpeg", "pdf"]) == -1) {
        displayErrorMessage(Lang.get("js.valid_file"));
        $(this).val("");

        return false;
    }

    if (this.files[0].size >= 10485760) {
        displayErrorMessage(Lang.get("js.valid_file_size"));
        $(this).val("");

        return false;
    }
});

// stripe payment JS code
listenClick(".makePayment", function () {
    if (
        typeof getLoggedInUserdata != "undefined" &&
        getLoggedInUserdata == ""
    ) {
        window.location.href = logInUrl;
        return true;
    }

    let payloadData = {
        plan_id: $(this).data("id"),
        from_pricing: typeof fromPricing != "undefined" ? fromPricing : null,
        price: $(this).data("plan-price"),
        payment_type: $("#paymentType option:selected").val(),
    };
    $(this).addClass("disabled");
    $.post(route("purchase-subscription"), payloadData)
        .done((result) => {
            if (typeof result.data == "undefined") {
                let toastMessageData = {
                    toastType: "success",
                    toastMessage: result.message,
                };
                paymentMessage(toastMessageData);
                setTimeout(function () {
                    window.location.href = subscriptionPlans;
                }, 5000);

                return true;
            }

            let sessionId = result.data.sessionId;
            stripe
                .redirectToCheckout({
                    sessionId: sessionId,
                })
                .then(function (result) {
                    $(this).html(subscribeText).removeClass("disabled");
                    $(".makePayment").attr("disabled", false);
                    let toastMessageData = {
                        toastType: "error",
                        toastMessage: result.responseJSON.message,
                    };
                    paymentMessage(toastMessageData);
                });
        })
        .catch((error) => {
            $(this).html(subscribeText).removeClass("disabled");
            $(".makePayment").attr("disabled", false);
            let toastMessageData = {
                toastType: "error",
                toastMessage: error.responseJSON.message,
            };
            paymentMessage(toastMessageData);
        });
});

listenChange("#paymentType", function () {
    let paymentType = $(this).val();
    if (paymentType == 1) {
        $(".proceed-to-payment").addClass("d-none");
        $(".cash-payment").addClass("d-none");
        $(".stripePayment").removeClass("d-none");
        $(".cash-payment-note").addClass("d-none");
        $(".paystackPayment").addClass("d-none");
    }
    if (paymentType == 2) {
        $(".proceed-to-payment").addClass("d-none");
        $(".cash-payment").addClass("d-none");
        $(".paypalPayment").removeClass("d-none");
        $(".cash-payment-note").addClass("d-none");
        $(".paystackPayment").addClass("d-none");
    }
    if (paymentType == 3) {
        $(".stripePayment").addClass("d-none");
        $(".paypalPayment").addClass("d-none");
        $(".cash-payment").removeClass("d-none");
        $(".cash-payment-note").removeClass("d-none");
        $(".paystackPayment").addClass("d-none");
    }
    if (paymentType == 4) {
        $(".proceed-to-payment").addClass("d-none");
        $(".cash-payment").addClass("d-none");
        $(".paypalPayment").addClass("d-none");
        $(".cash-payment-note").addClass("d-none");
        $(".stripePayment").addClass("d-none");
        $(".paystackPayment").removeClass("d-none");
    }

    if(paymentType == 5){
        $('.proceed-to-payment').addClass('d-none');
        $('.cash-payment').addClass('d-none');
        $('.paypalPayment').addClass('d-none');
        $('.cash-payment-note').addClass('d-none');
        $('.stripePayment').addClass('d-none')
        $('.razorpayPayment').removeClass('d-none');
    }
});

// paypal payment JS code
listenClick(".paymentByPaypal", function () {
    let pricing = typeof fromPricing != "undefined" ? fromPricing : null;
    $(this).addClass("disabled");
    $.ajax({
        type: "GET",
        url: route("user.paypal.init"),
        data: {
            planId: $(this).data("id"),
            from_pricing: pricing,
            payment_type: $("#paymentType option:selected").val(),
        },
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
        error: function (result) {},
        complete: function () {},
    });
});

listenClick(".paymentByPaystack", function () {
    let pricing = typeof fromPricing != "undefined" ? fromPricing : null;
    $(this).addClass("disabled");
    $.ajax({
        type: "GET",
        url: route("paystack.init"),
        data: {
            planId: $(this).data("id"),
            from_pricing: pricing,
            payment_type: $("#paymentType option:selected").val(),
        },
        success: function (result) {
            if (result.url) {
                location.href = result.url;
            } else {
                location.href = result.data.url;
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

// RazorPay Payment for User subscription
listenClick(".paymentByRazorpay", function () {
    $(this).addClass('disabled');
    $.ajax({
        type: "POST",
        url: razorpayURL,
        data: {
            'planId': $(this).data('id'),
            'from_pricing':
                typeof fromPricing != "undefined" ? fromPricing : null,
        },
        success: function (result) {
            if (result.url) {
                window.location.href = result.url;
            }
            if (result.success) {
                console.log(result.data);
                let { id, amount, name, email, contact, planID } = result.data;
                options.amount = amount;
                options.order_id = id;
                options.prefill.name = name;
                options.prefill.email = email;
                options.prefill.contact = contact;
                options.prefill.planID = planID;
                let razorPay = new Razorpay(options);
                razorPay.open();
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
        complete: function () {},
    });
});

function loadSelect2()
{
    if (!$('.subscription-status').length) {
        return false
    }

    $(".subscription-status").select2();
}

listenChange(".change-subscription-status", function () {
    let id = $(this).data("id");
    let status = $(this).val();

    Livewire.dispatch("changeStatus", { id: id, status: status });
});

window.addEventListener("changeStatusEvent", (event) => {
    displaySuccessMessage(
        Lang.get("js.subscription_status_changed_successfully")
    );
});

listenClick(".get-cash-payment-note", function () {
    let userTransactionId = $(this).data("id");
    Livewire.dispatch("getNoteData", { userTransactionId: userTransactionId });
});

window.addEventListener("retrieveNoteData", (event) => {
    $(".cash-payment-note").text(event.detail);
    $("#cashPaymentNoteModal").modal("show");
});
