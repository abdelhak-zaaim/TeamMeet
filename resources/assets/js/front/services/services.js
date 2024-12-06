let imageSize = ''

listenChange('.service_image', function () {
    return imageSize = (this.files[0].size)
})

listenSubmit('#addServiceForm', function () {
    if (imageSize > 2000000) {
        displayErrorMessage(Lang.get('js.image_size'))
        return false
    }

    if ($('.main-title').val().trim() == '') {
        displayErrorMessage(Lang.get('js.main_title'))
        return false
    }

    if ($('.service-title-1').val().trim() == '') {
        displayErrorMessage(Lang.get('js.service_title_1'))
        return false
    }

    if ($('.service-description-1').val().trim() == '') {
        displayErrorMessage(Lang.get('js.service_description_1'))
        return false
    } else if ($('.service-description-1').val().length >= 90) {
        displayErrorMessage(
            Lang.get('js.service_description_1_length'))
        return false
    }

    if ($('.service-title-2').val().trim() == '') {
        displayErrorMessage(Lang.get('js.service_title_2'))
        return false
    }

    if ($('.service-description-2').val().trim() == '') {
        displayErrorMessage(Lang.get('js.service_description_2'))
        return false
    } else if ($('.service-description-2').val().length >= 90) {
        displayErrorMessage(
            Lang.get('js.service_description_2_length'))
        return false
    }

    if ($('.service-title-3').val().trim() == '') {
        displayErrorMessage(Lang.get('js.service_title_3'))
        return false
    }

    if ($('.service-description-3').val().trim() == '') {
        displayErrorMessage(Lang.get('js.service_description_3'))
        return false
    } else if ($('.service-description-3').val().length >= 90) {
        displayErrorMessage(
            Lang.get('js.service_description_3_length'))
        return false
    }

    $('#servicesSaveBtn').attr('disabled',true);
});
