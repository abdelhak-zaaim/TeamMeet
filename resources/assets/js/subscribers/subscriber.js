// subscriber record delete code
listenClick('.subscribe-delete-btn', function () {
    let deleteSubscriberId = $(this).attr('data-id')
    deleteItem(route('subscribers.destroy', deleteSubscriberId),
        Lang.get('js.subscriber'))
})
