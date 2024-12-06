document.addEventListener("turbo:load", loadUserCreateEditData);

function loadUserCreateEditData() {
    if (!$("#personalExperienceId").length) {
        return;
    }

    $("#personalExperienceId").select2({
        width: "100%",
        placeholder: Lang.get("js.select_personal_experience"),
    });
    $("#subscriptionPlansId").select2({
        width: "100%",
        placeholder: Lang.get("js.select_subscription_plans"),
    });
}

listenSubmit("#createUserForm", function () {
    if ($("#error-msg").text() !== "") {
        $("#phoneNumber").focus();
        displayErrorMessage(Lang.get("js.contact_number_is_invalid_number"));
        return false;
    }
    $("#createUserSaveBtn").attr("disabled", true);
});

listenSubmit("#editUserForm", function () {
    if ($("#error-msg").text() !== "") {
        $("#phoneNumber").focus();
        displayErrorMessage(`Contact number is ` + $("#error-msg").text());
        return false;
    }
    $("#createUserSaveBtn").attr("disabled", true);
});
