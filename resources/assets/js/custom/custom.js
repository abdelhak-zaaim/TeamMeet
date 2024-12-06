document.addEventListener('turbo:load', loadCustomData)

let source = null

document.addEventListener('turbo:load', initAllComponents)

function initAllComponents () {
    refreshCsrfToken()
    alertInitialize()
    modalInputFocus()
    inputFocus()
    tooltip()
}

function alertInitialize () {
    $('.alert').delay(5000).slideUp(300)
}

function refreshCsrfToken () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    })
}

function tooltip () {
    let tooltipTriggerList =
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}

const inputFocus = () => {
    $('input:text:not([readonly="readonly"]):not([name="search"])').
        first().
        focus()
}

const modalInputFocus = () => {
    $(function () {
        $('.modal').on('shown.bs.modal', function () {
            if ($(this).find('input:text')[0]) {
                $(this).find('input:text')[0].focus()
            }
        })
    })
}

window.hideDropdownManually = function (dropdownBtnEle) {
    dropdownBtnEle.removeClass('show')
}

function loadCustomData () {
    // script to active parent menu if sub menu has currently active
    let hasActiveMenu = $(document).
        find('.nav-item.dropdown ul li').
        hasClass('active')
    if (hasActiveMenu) {
        $(document).
            find('.nav-item.dropdown ul li.active').
            parent('ul').
            css('display', 'block')
        $(document).
            find('.nav-item.dropdown ul li.active').
            parent('ul').
            parent('li').
            addClass('active')
    }

    let timezone_offset_minutes = new Date().getTimezoneOffset()
    timezone_offset_minutes = timezone_offset_minutes === 0
        ? 0
        : -timezone_offset_minutes
    document.cookie = 'timezone_offset_minutes=' + timezone_offset_minutes
}

listen('select2:open', () => {
    let allFound = document.querySelectorAll(
        '.select2-container--open .select2-search__field')
    allFound[allFound.length - 1].focus()
})

listen('focus', '.select2.select2-container', function (e) {
    let isOriginalEvent = e.originalEvent // don't re-open on closing focus event
    let isSingleSelect = $(this).find('.select2-selection--single').length > 0 // multi-select will pass focus to input

    if (isOriginalEvent && isSingleSelect) {
        $(this).siblings('select:enabled').select2('open')
    }
})

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

window.resetModalForm = function (formId, validationBox) {
    $(formId)[0].reset();
    $('select.select2Selector').each(function (index, element) {
        let drpSelector = '#' + $(this).attr('id');
        $(drpSelector).val('');
        $(drpSelector).trigger('change');
    });
    $(validationBox).hide();
};

window.printErrorMessage = function (selector, errorResult) {
    $(selector).show().html('');
    $(selector).text(errorResult.responseJSON.message);
};

window.manageAjaxErrors = function (data) {
    let errorDivId = arguments.length > 1 && arguments[1] !== undefined
        ? arguments[1]
        : 'editValidationErrorsBox'
    if (data.status == 404) {
        toastr.error(data.responseJSON.message);
    } else {
        printErrorMessage('#' + errorDivId, data);
    }
};

window.displaySuccessMessage = function (message) {
    toastr.success(message, Lang.get('js.successful'))
};

window.displayErrorMessage = function (message) {
    toastr.error(message, Lang.get('js.something_went_wrong'))
};

window.deleteItem = function (url, header) {
    let callFunction = arguments.length > 3 && arguments[3] !== undefined
        ? arguments[3]
        : null
    swal({
        title: Lang.get('js.delete'),
        text: Lang.get('js.sure_delete') + ' "' + header +
            '"  ?',
        buttons: {
            confirm: Lang.get('js.yes'),
            cancel: Lang.get('js.no'),
        },
        icon: sweetAlertIcon,
        reverseButtons: true,
    }).then(function (willDelete) {
        if (willDelete) {
            deleteItemAjax(url, header, callFunction)
        }
    })
};

function deleteItemAjax (url, header, callFunction = null) {
    $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'json',
        success: function (obj) {
            if (obj.success) {
                Livewire.dispatch('refresh')
                Livewire.dispatch('resetPageTable')
            }
            swal({
                icon: 'success',
                confirmButtonColor: '#ADB5BD',
                title: deleteMsg + ' !',
                text: header + ' ' +
                    hasBeenDeleted,
                buttons: {
                     confirm: Lang.get("js.ok"),
                },
                timer: 2000,
            })
            if (callFunction) {
                eval(callFunction);
            }
        },
        error: function (data) {
            swal({
                title: 'Error',
                icon: 'error',
                text: data.responseJSON.message,
                type: 'error',
                timer: 4000,
            })
        },
    });
}

window.format = function (dateTime) {
    let format = arguments.length > 1 && arguments[1] !== undefined
        ? arguments[1]
        : 'DD-MMM-YYYY'
    return moment(dateTime).format(format);
};

window.processingBtn = function (selecter, btnId, state = null) {
    let loadingButton = $(selecter).find(btnId)
    if (state === 'loading') {
        loadingButton.button('loading')
    } else {
        loadingButton.button('reset')
    }
}

window.setBtnLoader = function (btnLoader) {
    if (btnLoader.attr('data-old-text')) {
        btnLoader.html(btnLoader.attr('data-old-text')).prop('disabled', false)
        btnLoader.removeAttr('data-old-text')
        return
    }
    btnLoader.attr('data-old-text', btnLoader.text())
    btnLoader.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').
        prop('disabled', true)
}

window.prepareTemplateRender = function (templateSelector, data) {
    let template = jsrender.templates(templateSelector)
    return template.render(data)
}

window.isValidFile = function (inputSelector, validationMessageSelector) {
    let ext = $(inputSelector).val().split('.').pop().toLowerCase()
    if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        $(inputSelector).val('')
        $(validationMessageSelector).removeClass('d-none');
        $(validationMessageSelector).
            html('The image must be a file of type: jpeg, jpg, png.').
            show();
        $(validationMessageSelector).delay(5000).slideUp(300);

        return false;
    }
    $(validationMessageSelector).hide();
    return true;
};

window.displayPhoto = function (input, selector) {
    let displayPreview = true;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                $(selector).attr('src', e.target.result);
                displayPreview = true;
            };
        };
        if (displayPreview) {
            reader.readAsDataURL(input.files[0]);
            $(selector).show();
        }
    }
};

window.removeCommas = function (str) {
    return str.replace(/,/g, '');
};

window.DatetimepickerDefaults = function (opts) {
    return $.extend({}, {
        sideBySide: true,
        ignoreReadonly: true,
        icons: {
            close: 'fa fa-times',
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-arrow-up',
            down: 'fa fa-arrow-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-clock-o',
            clear: 'fa fa-trash-o',
        },
    }, opts);
};

window.isEmpty = (value) => {
    return value === undefined || value === null || value === '';
};

window.urlValidation = function (value, regex) {
    let urlCheck = (value == '' ? true : (value.match(regex)
        ? true
        : false));
    if (!urlCheck) {
        return false;
    }

    return true;
};

if ($(window).width() > 992) {
    $('.no-hover').on('click', function () {
        $(this).toggleClass('open');
    });
}

window.preparedTemplate = function () {
    source = $('#actionTemplate').html()
    window.preparedTemplate = Handlebars.compile(source)
};

window.ajaxCallInProgress = function () {
    ajaxCallIsRunning = true;
};

window.ajaxCallCompleted = function () {
    ajaxCallIsRunning = false;
};

window.avoidSpace = function (event) {
    let k = event ? event.which : window.event.keyCode;
    if (k == 32) {
        return false;
    }
};

$('input[type=radio][name=gender]').on('change', function () {
    let file = $('#profilePicture').val();
    if (isEmpty(file)) {
        if (this.value == 1) {
            $('.image-input-wrapper').
                attr('style', 'background-image:url(' + manAvatar + ')');
        } else if (this.value == 2) {
            $('.image-input-wrapper').
                attr('style', 'background-image:url(' + womanAvatar + ')');
        }
    }
});

window.setBtnLoader = function (btnLoader) {
    if (btnLoader.attr('data-old-text')) {
        btnLoader.html(btnLoader.attr('data-old-text')).prop('disabled', false);
        btnLoader.removeAttr('data-old-text');
        return;
    }
    btnLoader.attr('data-old-text', btnLoader.text());
    btnLoader.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').
        prop('disabled', true);
};

window.addCommas = function (nStr) {
    nStr += '';
    let x = nStr.split('.');
    let x1 = x[0];
    let x2 = x.length > 1 ? '.' + x[1] : '';
    let rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
};

window.getFormattedPrice = function (price) {
    if (price != '' || price > 0) {
        if (typeof price !== 'number') {
            price = price.replace(/,/g, '');
        }
        return addCommas(price);
    }
};

listenClick('.change-type', function (e) {
    let inputField = $(this).siblings()
    let oldType = inputField.attr('type')
    let type = !isEmpty(oldType) ? oldType : 'password'
    if (type == 'password') {
        $(this).children().addClass('fa-eye')
        $(this).children().removeClass('fa-eye-slash')
        inputField.attr('type', 'text')
    } else {
        $(this).children().removeClass('fa-eye')
        $(this).children().addClass('fa-eye-slash')
        inputField.attr('type', 'password')
    }
})

$('.dropdown-menu a').on('click', function () {
    $(this).closest('.dropdown-menu').prev().dropdown('toggle')
})

// cancel schedule event modal code
listenClick('.cancel-scheduled-event', function () {
    let scheduledEventId = $(this).attr('data-id')
    $('#scheduleEventId').val(scheduledEventId)
    $('#cancelScheduleEventModal').modal('show').appendTo('body')
})

//Custom cancel schedule event toaster
window.customDisplayErrorMessage = function (message) {
    toastr.error(message, Lang.get('Error'))
};

// cancel schedule event code
listenSubmit('#cancelScheduleEventForm', function (e) {
    e.preventDefault()

   var cancelReason = $('#cancelReason').val();
   if (isEmpty(cancelReason)) {
    customDisplayErrorMessage(Lang.get('js.cancel_reason_required'));
      return false;
   } else if (!/\S/.test(cancelReason)) {
    customDisplayErrorMessage(Lang.get('js.cancel_reason_cannot_space'));
      return false;
   }
    let scheduledEventId = $('#scheduleEventId').val()

    $.ajax({
        url: route('cancel.scheduled.event', scheduledEventId),
        type: 'POST',
        data: $(this).serialize(),
        success: function (result) {
            if (result.success) {
                Livewire.dispatch('refresh')
                $('#cancelScheduleEventModal').modal('hide')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
})

// cancel modal reset data code
listenHiddenBsModal('#cancelScheduleEventModal', function () {
    resetModalForm('#cancelScheduleEventForm', '#cancelValidationErrorsBox')
})

listenClick('.copy-google-meet-link', function () {
    let $temp = $('<input>')
    $('body').append($temp)
    $temp.val($(this).attr('data-link')).select()
    document.execCommand('copy')
    $temp.remove()

    $(this).children().css('color', '#8BC34A')
    $(this).children().removeClass('fa-copy')
    $(this).children().addClass('fa-check')
    displaySuccessMessage(Lang.get('js.linked_copy_successfully'))
    setTimeout(function () {
        $('.copy-google-meet-link').children().removeClass('fa-check')
        $('.copy-google-meet-link').children().addClass('fa-copy')
        $('.copy-google-meet-link').children().css('color', '#009ef7')
    }, 2000)
})
