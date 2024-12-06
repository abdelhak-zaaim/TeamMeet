// document.addEventListener('turbo:load', loadSubscriptionPlanData)

Livewire.hook("element.init", () => {
    loadSubscriptionPlanData();
});
function loadSubscriptionPlanData () {
    if (!$('#planTypeFilter').length) {
        return
    }

    $('#planTypeFilter').select2({
        placeholder: Lang.get('js.select_status'),
    })
}

// delete subscription record code
listenClick('.subscription-plan-delete-btn', function () {
    let deleteSubscriptionId = $(this).attr('data-id')
    let deleteSubscriptionUrl = route('subscription-plans.index') + '/' +
        deleteSubscriptionId
    deleteItem(deleteSubscriptionUrl,
        Lang.get('js.subscription_plan'))
})

listenChange('.is_default', function (event) {
    let subscriptionPlanId = $(event.currentTarget).data('id')
    updateStatusToDefault(subscriptionPlanId)
})

window.updateStatusToDefault = function (id) {
    $.ajax({
        url: route('subscription-plans.index') + '/' + id +
            '/make-plan-as-default',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                Livewire.dispatch('refresh')
            }
        },
    });
};

// reset filter modal code
listenClick('#resetFilter', function () {
    $('#planTypeFilter').val(0).trigger('change')
    $('#subscriptionPlanFilterBtn').dropdown('toggle')
})

// call filter data code
listenChange('#planTypeFilter', function () {
    Livewire.dispatch('changeFilter', {value:$(this).val()})
})
