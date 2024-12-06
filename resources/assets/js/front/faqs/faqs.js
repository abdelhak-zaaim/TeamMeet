// delete faq record code
listenClick('.faq-delete-btn', function () {
    let deleteFaqId = $(this).attr('data-id')
    deleteItem(route('faqs.destroy', deleteFaqId),
        Lang.get('js.faq'))
})
