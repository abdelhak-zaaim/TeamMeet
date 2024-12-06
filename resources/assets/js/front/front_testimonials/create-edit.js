let imageSize = ''

listenChange('#profileImage', function () {
    return imageSize = (this.files[0].size)
})

listenSubmit('#editFrontTestimonialForm, #createFrontTestimonialForm',
    function () {
        if (imageSize > 2000000) {
            displayErrorMessage(Lang.get('js.profile_size'))
            return false
        }

        if ($('#name').val().trim() == '') {
            displayErrorMessage(Lang.get('js.name_required'))

            return false
        }

        if ($('#shortDescription').val().trim() == '') {
            displayErrorMessage(Lang.get('js.short_description'))
            return false
        }

        if ($('#designation').val().trim() == '') {
            displayErrorMessage(Lang.get('js.desig_required'))
            return false
        }

        $('#frontTestimonialSaveBtn').attr('disabled', true)
    })


