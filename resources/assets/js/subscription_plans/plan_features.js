document.addEventListener('turbo:load', loadPlanFeatureData)

function loadPlanFeatureData () {
    // features selection script - starts
    let featureLength = $('.feature:checkbox:checked').length
    featureChecked(featureLength)
}

window.featureChecked = function (featureLength) {
    let totalFeature = $('.feature:checkbox').length
    if (featureLength === totalFeature) {
        $('#selectAll').prop('checked', true)
    } else {
        $('#selectAll').prop('checked', false)
    }
}

// script for selecting all features
listenClick('#selectAll', function () {
    if ($('#selectAll').is(':checked')) {
        $('.feature').each(function () {
            $(this).prop('checked', true)
        })
    } else {
        $('.feature').each(function () {
            $(this).prop('checked', false)
        })
    }
})

// script for selecting single feature
listenClick('.feature', function () {
    let featureLength = $('.feature:checkbox:checked').length
    featureChecked(featureLength)
})
