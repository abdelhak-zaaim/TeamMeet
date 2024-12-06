document.addEventListener('turbo:load', loadAboutUsData)

let quill;

function loadAboutUsData () {

    if (!$('#aboutUsDescriptionId').length) {
        return
    }

    quill = new Quill('#aboutUsDescriptionId', {
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
        placeholder: Lang.get('js.description'),
        theme: 'snow', // or 'bubble'
    })

    quill.on('text-change', function (delta, oldDelta, source) {
        if (quill.getText().trim().length === 0) {
            quill.setContents([{ insert: '' }])
        }
    })

    let element = document.createElement('textarea')
    element.innerHTML = $('#aboutUsData').val()
    quill.root.innerHTML = element.value
}

listenSubmit('#aboutUsForm', function () {
    let element = document.createElement('textarea')
    let editor_content = quill.root.innerHTML
    element.innerHTML = editor_content

    if (quill.getText().trim().length === 0) {
        displayErrorMessage(Lang.get('js.description_required'))
        return false
    }
    $('#aboutUsSaveBtn').attr('disabled', true)

    $('#aboutUsDescription').val(JSON.stringify(editor_content))
})
