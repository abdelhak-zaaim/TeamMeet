document.addEventListener('turbo:load', loadFrontCustomData)

function loadFrontCustomData () {
    loadTestimonialCarousel()
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': true,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'onclick': null,
        'showDuration': '300',
        'hideDuration': '1000',
        'timeOut': '5000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }

    window.displaySuccessMessage = function (message) {
        toastr.success(message)
    }

    window.displayErrorMessage = function (message) {
        toastr.error(message)
    }
}
listenClick('.languageSelection', function () {
    let languageName = $(this).data('prefix-value')

    $.ajax({
        type: 'POST',
        url: route('front.change.language'),
        data: { '_token': csrfToken, languageName: languageName },
        success: function () {
            location.reload()
        },
    })
})

listenClick('#month-tab', function () {
    $('#month').removeClass('d-none')
    $('#year').addClass('d-none')
    $('#unlimited').addClass('d-none')
})

listenClick('#year-tab', function () {
    $('#year').removeClass('d-none')
    $('#month').addClass('d-none')
    $('#unlimited').addClass('d-none')
})

listenClick('#unlimited-tab', function () {
    $('#unlimited').removeClass('d-none')
    $('#month').addClass('d-none')
    $('#year').addClass('d-none')
})

listenClick('.collapse-btn', function () {
    $('.collapse-btn').removeClass('show')
    if ($('.faq-collapse').hasClass('show')) {
        $(this).addClass('show')
    }
})

function loadTestimonialCarousel(){
    $('.testimonial-carousel').slick({
        dots: false,
        centerPadding: '0',
        slidesToShow: 1,
        slidesToScroll: 1,
    })
}


listenClick(".copy-link", function () {
    let $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(this).attr("data-link")).select();
    document.execCommand("copy");
    $temp.remove();
    $(this).html('<i class="fa fa-copy me-1" style="color: #009ef7"></i> ' + Lang.get("js.copied"));
    $(this).children().css("color", "#8BC34A");
    $(this).children().removeClass("fa-copy");
    $(this).children().addClass("fa-check");
    displaySuccessMessage(Lang.get("js.linked_copy_successfully"));
    setTimeout(function () {
        $(".copy-link").html('<i class="fa fa-copy me-1" style="color: #009ef7"></i> ' + Lang.get("js.copy_link"));
        $(".copy-link").children().removeClass("fa-check");
        $(".copy-link").children().addClass("fa-copy");
        $(".fa-copy").css("color", "#8BC34A");
    }, 2000);
});
