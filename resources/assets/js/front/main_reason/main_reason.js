let imageSize = ''

listenChange('#imageMainReason', function () {
    return imageSize = (this.files[0].size)
})

listenSubmit('#addMainReasonForm', function () {
    if (imageSize > 2000000) {
        displayErrorMessage(Lang.get('js.image_size'))
        return false
    }

    if ($('#main_title').val().trim() == '') {
        displayErrorMessage(Lang.get('js.main_title'))
        return false
    }

    if ($('#title_1').val().trim()== '') {
        displayErrorMessage(Lang.get('js.title_1'))
        return false
    }


    if ($('#description_1').val().trim()== '') {
        displayErrorMessage(Lang.get('js.description_1'))
        return false
    }
    else if($('#description_1').val().length>=122)
    {
        displayErrorMessage(Lang.get('js.description_1_length'))
        return false
    }


    if ($('#title_2').val().trim()== '') {
        displayErrorMessage(Lang.get('js.title_2'))
        return false
    }


    if ($('#description_2').val().trim()== '') {
        displayErrorMessage(Lang.get('js.description_2'))
        return false
    }
    else if($('#description_2').val().length>=122)
    {
        displayErrorMessage(Lang.get('js.description_2_length'))
        return false
    }

    if ($('#title_3').val().trim()== '') {
        displayErrorMessage(Lang.get('js.title_3'))
        return false
    }


    if ($('#description_3').val().trim() == '') {
        displayErrorMessage(Lang.get('js.description_3'))
        return false
    } else if ($('#description_3').val().length >= 122) {
        displayErrorMessage(
            Lang.get('js.description_3_length'))
        return false
    }

    $('#mainReasonSaveBtn').attr('disabled',true)
});
