document.addEventListener('turbo:load', loadCMSData)

let quill1
let quill2

function loadCMSData () {

    if (!$('#termConditionId').length || !$('#privacyPolicyId').length) {
        return
    }

    quill1 = new Quill('#termConditionId', {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
            ],
        },
        placeholder: Lang.get('js.terms_cond'),
        theme: 'snow', // or 'bubble'
    })

    quill1.on('text-change', function (delta, oldDelta, source) {
        if (quill1.getText().trim().length === 0) {
            quill1.setContents([{ insert: '' }])
        }
    })

    quill2 = new Quill('#privacyPolicyId', {
        modules: {
            toolbar: [
                [
                    {
                        header: [1, 2, false],
                    }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
            ],
        },
        placeholder: Lang.get('js.privacy_policy'),
        theme: 'snow', // or 'bubble'
    })

    quill2.on('text-change', function (delta, oldDelta, source) {
        if (quill2.getText().trim().length === 0) {
            quill2.setContents([{ insert: '' }])
        }
    })

    let element = document.createElement('textarea')
    element.innerHTML = $('#termConditionData').val()
    quill1.root.innerHTML = element.value

    element.innerHTML = $('#privacyPolicyData').val()
    quill2.root.innerHTML = element.value

    let imageSize = ''

    listenChange('#frontImage', function () {
        return imageSize = (this.files[0].size)
    })

    listenSubmit('#addCMSForm', function (e) {
        e.stopImmediatePropagation()
        if (imageSize > 2000000) {
            displayErrorMessage(Lang.get('js.image_size'))
            return false
        }

        let emptyTitleField = $('#titleId').val().trim()
        if ($('#titleId').val() == '') {
            displayErrorMessage(Lang.get('js.title_required'))
            return false
        }
        else if(isEmpty(emptyTitleField)) {
            displayErrorMessage(Lang.get('js.title_required'))
            return false;
        }

        let emptyEmailField = $('#email').val().trim();
        if($('#email').val() == ''){
            displayErrorMessage(Lang.get('js.email_required'))
            return false;
        }
        else if(isEmpty(emptyEmailField)) {
            displayErrorMessage(Lang.get('js.email_required'))
            return false;
        }

        if($('#phoneNumber').val() == ''){
            displayErrorMessage(Lang.get('js.phone_required'))
            return false;
        }

        let emptyAddressField = $('#address').val().trim();
        if($('#address').val() == ''){
            displayErrorMessage(Lang.get('js.address_required'))
            return false;
        }
        else if(isEmpty(emptyAddressField)) {
            displayErrorMessage(Lang.get('js.address_required'))
            return false;
        }

        let facebookUrl = $('#facebookUrl').val()
        let twitterUrl = $('#twitterUrl').val()
        let instagramUrl = $('#instagramUrl').val()
        let facebookExp = new RegExp(
            /^(https?:\/\/)?((m{1}\.)?)?((w{2,3}\.)?)facebook.[a-z]{2,3}\/?.*/i)
        let twitterExp = new RegExp(
            /^(https?:\/\/)?((w{2,3}\.)?)twitter\.[a-z]{2,3}\/?.*/i)
        let instagramExp = new RegExp(
            /^(https?:\/\/)?((m{1}\.)?)?((w{2,3}\.)?)instagram.[a-z]{2,3}\/?.*/i)

        let facebookCheck = (facebookUrl == '' ? true : (facebookUrl.match(
            facebookExp) ? true : false))
        if (!facebookCheck) {
            displayErrorMessage(Lang.get('js.enter_valid_facebook_url'))
            return false
        }

        let twitterCheck = (twitterUrl == '' ? true : (twitterUrl.match(
            twitterExp) ? true : false))
        if (!twitterCheck) {
            displayErrorMessage(Lang.get('js.enter_valid_twitter_url'))
            return false
        }

        let instagramCheck = (instagramUrl == '' ? true : (instagramUrl.match(
            instagramExp) ? true : false))
        if (!instagramCheck) {
            displayErrorMessage(Lang.get('js.enter_valid_instagram_url'))
            return false
        }

        if ($('#error-msg').text() !== '') {
            $('#phoneNumber').focus()
            return false
        }

        let element = document.createElement('textarea')
        let editor_content_1 = quill1.root.innerHTML
        element.innerHTML = editor_content_1
        let editor_content_2 = quill2.root.innerHTML

        if (quill1.getText().trim().length === 0) {
            displayErrorMessage(Lang.get('js.terms_condition'))
            return false
        }

        if (quill2.getText().trim().length === 0) {
            displayErrorMessage(Lang.get('js.privacy_policy'))
            return false
        }

        $('#termData').val(JSON.stringify(editor_content_1))
        $('#privacyData').val(JSON.stringify(editor_content_2))
        $('#cmsSaveButton').attr('disabled', true);
    })
}

listenKeyup('#facebookUrl', function () {
    this.value = this.value.toLowerCase()
})

listenKeyup('#twitterUrl', function () {
    this.value = this.value.toLowerCase()
})

listenKeyup('#instagramUrl', function () {
    this.value = this.value.toLowerCase()
})
