document.addEventListener('turbo:load', loadEventData)

let dateRange
let eventType
let afterGap
let eventColor

function loadEventData () {
    dateRange = $('#dateRangeEdit').val()
    eventType = $('#eventTypeEdit').val()
    afterGap = $('#afterGapEdit').val()
    eventColor = $('#colorEdit').val()

    if (currentRouteName == 'events.edit') {
        $('select[name^="from_time"]').each(function () {
            let selectedIndex = $(this)[0].selectedIndex
            let endSelectedIndex = $(this).
                closest('.add-slot').
                find('select[name^="to_time"] option:selected')[0].index
            let endTimeOptions = $(this).
                closest('.add-slot').
                find('select[name^="to_time"] option')
            if (selectedIndex >= endSelectedIndex) {
                endTimeOptions.eq(selectedIndex + 1).
                    prop('selected', true).
                    trigger('change')
            }
            endTimeOptions.each(function (index) {
                if (index <= selectedIndex) {
                    $(this).attr('disabled', true)
                } else {
                    $(this).attr('disabled', false)
                }
            })
        })
        $('select[name^="to_time"]').each(function () {
            let selectedIndex = $(this)[0].selectedIndex
            let startTimeOptions = $(this).
                closest('.timeSlot').
                next().
                find('select[name^="from_time"] option')
            startTimeOptions.each(function (index) {
                if (index <= selectedIndex) {
                    $(this).attr('disabled', true)
                } else {
                    $(this).attr('disabled', false)
                }
            })
        })

        if (!$('#slotTimeId').length || !$('.startTimeSlot').length ||
            !$('.endTimeSlot').length || !$('#withinDateRangeId').length ||
            !$('#afterEventTimeId').length || !$('#eventTimeZoneId').length ||
            !$('#eventScheduleId').length) {
            return
        }

        $('#slotTimeId').select2({
            width: '100%',
        })

        $('#eventTimeZoneId').select2({
            width: '100%',
        })

        $('#eventScheduleId').select2({
            width: '100%',
        })

        $('.startTimeSlot').select2({
            width: '100%',
        })

        $('.endTimeSlot').select2({
            width: '100%',
        })

        $('#afterEventTimeId').select2()

        $('#withinDateRangeId').daterangepicker({
            minDate: new Date(),
            locale: {
                applyLabel: Lang.get('js.apply'),
                cancelLabel: Lang.get('js.cancel'),
                fromLabel: Lang.get('js.from'),
                toLabel: Lang.get('js.to'),
                monthNames: [
                    Lang.get('js.jan'),
                    Lang.get('js.feb'),
                    Lang.get('js.mar'),
                    Lang.get('js.apr'),
                        Lang.get('js.may'),
                        Lang.get('js.jun'),
                        Lang.get('js.jul'),
                        Lang.get('js.aug'),
                        Lang.get('js.sep'),
                        Lang.get('js.oct'),
                        Lang.get('js.nov'),
                        Lang.get('js.dec')
                    ],
                    daysOfWeek: [
                        Lang.get('js.sun'),
                        Lang.get('js.mon'),
                        Lang.get('js.tue'),
                        Lang.get('js.wed'),
                        Lang.get('js.thu'),
                        Lang.get('js.fri'),
                        Lang.get('js.sat')],
                },
        })

        if (dateRange == 0) {
            $('#withinDateRangeId').removeClass('d-none')
            $('#withinDateRangeId').prop('disabled', false)
            $('#scheduleDayId').prop('disabled', true)
        } else {
            $('#withinDateRangeId').addClass('d-none')
            $('#scheduleDayId').prop('disabled', false);
        }

        if (afterGap != '') {
            $('.after-time').prop('checked', true);
            $('#afterEventTimeId').prop('disabled', false)
        } else {
            $('.after-time').prop('checked', false)
            $('#afterEventTimeId').prop('disabled', true)
        }

        if (eventType == 2) {
            $('#payableAmount').removeClass('d-none')
            $('#payableAmountId').prop('disabled', false)
        }
    }

    if (!$('.event-location').length || !$('#paymentTypeId').length ||
        !$('.add-location').length) {
        return
    }

    $('.event-location').select2({
        placeholder: Lang.get('js.add_location'),
    })

    $('#paymentTypeId').select2({
        placeholder: Lang.get('js.select_event_type'),
    })

    $('.add-location').select2()

    if (currentRouteName == 'events.create') {
        const pickr = Pickr.create({
            el: '.color-wrapper',
            theme: 'nano', // or 'monolith', or 'nano'
            closeWithKey: 'Enter',
            autoReposition: true,
            defaultRepresentation: 'HEX',
            position: 'bottom-end',
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 1)',
                'rgba(156, 39, 176, 1)',
                'rgba(103, 58, 183, 1)',
                'rgba(63, 81, 181, 1)',
                'rgba(33, 150, 243, 1)',
                'rgba(3, 169, 244, 1)',
                'rgba(0, 188, 212, 1)',
                'rgba(0, 150, 136, 1)',
                'rgba(76, 175, 80, 1)',
                'rgba(139, 195, 74, 1)',
                'rgba(205, 220, 57, 1)',
                'rgba(255, 235, 59, 1)',
                'rgba(255, 193, 7, 1)',
            ],

            components: {
                // Main components
                preview: true,
                hue: true,

                // Input / output Options
                interaction: {
                    input: true,
                    clear: false,
                    save: false,
                },
            },
        })

        pickr.on('change', function () {
            const color = pickr.getColor().toHEXA().toString()
            if (wc_hex_is_light(color)) {
                $('#validationErrorsBoxForColor').
                    removeClass('d-none').
                    text('Pick a different color')
                $(':input[id="btnSave"]').prop('disabled', true)
                return
            }
            $('#validationErrorsBoxForColor').addClass('d-none')
            $(':input[id="btnSave"]').prop('disabled', false)
            pickr.setColor(color)
            $('#color').val(color)
        })

        $(document).ready(function () {
            pickr.setColor('#d6b71b')
            $('#color').val('#d6b71b')
        })
    }

    if (currentRouteName == 'events.edit') {
        const editPickr = Pickr.create({
            el: '.color-wrapper-edit',
            theme: 'nano', // or 'monolith', or 'nano'
            closeWithKey: 'Enter',
            autoReposition: true,
            defaultRepresentation: 'HEX',
            position: 'bottom-end',
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 1)',
                'rgba(156, 39, 176, 1)',
                'rgba(103, 58, 183, 1)',
                'rgba(63, 81, 181, 1)',
                'rgba(33, 150, 243, 1)',
                'rgba(3, 169, 244, 1)',
                'rgba(0, 188, 212, 1)',
                'rgba(0, 150, 136, 1)',
                'rgba(76, 175, 80, 1)',
                'rgba(139, 195, 74, 1)',
                'rgba(205, 220, 57, 1)',
                'rgba(255, 235, 59, 1)',
                'rgba(255, 193, 7, 1)',
            ],

            components: {
                // Main components
                preview: true,
                hue: true,

                // Input / output Options
                interaction: {
                    input: true,
                    clear: false,
                    save: false,
                },
            },
        })

        setTimeout(function () {
            editPickr.setColor(eventColor)
        }, 10)

        $('#editEventColor').val(eventColor)

        editPickr.on('change', function () {
            const editColor = editPickr.getColor().toHEXA().toString()
            if (wc_hex_is_light(editColor)) {
                $('#editValidationErrorsBoxForColor').
                    addClass('d-block').
                    text('Pick a different color')
                $(':input[id="btnEditSave"]').prop('disabled', true)
                return
            }
            $('#editValidationErrorsBoxForColor').removeClass('d-block')
            $(':input[id="btnEditSave"]').prop('disabled', false)
            editPickr.setColor(editColor)
            $('#editEventColor').val(editColor)
        })
    }

    function wc_hex_is_light (color) {
        const hex = color.replace('#', '')
        const c_r = parseInt(hex.substr(0, 2), 16)
        const c_g = parseInt(hex.substr(2, 2), 16)
        const c_b = parseInt(hex.substr(4, 2), 16)
        const brightness = ((c_r * 299) + (c_g * 587) + (c_b * 114)) / 1000
        return brightness > 240
    }

    if (currentRouteName == 'events.edit') {
        let id = $('.add-location').val()
        let prepareLocationData = []

        if (locationMeta[0] == 1) {
            $('#shortDescLoc').val(locationMeta[1] ? locationMeta[1] : '')
            $('#longDescLoc').val(locationMeta[2] ? locationMeta[2] : '')
            let shortName = $('#shortDescLoc').val()
            let longDesLoc = $('#longDescLoc').val()
            prepareLocationData.push(id)
            prepareLocationData.push(shortName)
            if (longDesLoc != '') {
                prepareLocationData.push(longDesLoc)
            }
        } else if (locationMeta[0] == 2) {
            if (locationMeta[1] == 2) {
                $('#phoneCallOption2').prop('checked', true)
                $('#longDescCall').val(locationMeta[3] ? locationMeta[3] : '')
                let phoneCallOption2 = $('#phoneCallOption2').val()
                let longDescCall = $('#longDescCall').val()
                prepareLocationData.push(id)
                prepareLocationData.push(phoneCallOption2)
                prepareLocationData.push(
                    '+' + $('#prefix_code').val() + $('#phoneNumber').val())
                if (longDescCall != '') {
                    prepareLocationData.push(longDescCall)
                }
            } else {
                $('#phoneCallOption').prop('checked', true)
                let phoneCallOption = $('#phoneCallOption').val()
                prepareLocationData.push(id)
                prepareLocationData.push(phoneCallOption)
            }
        }else {
            $('.add-location-modal').addClass('d-none')
        }

        if(locationMeta[0] == '3') {
            $('#locationAddData').val(JSON.stringify(["3"]));
        }else {
            $('#locationAddData').val(JSON.stringify(prepareLocationData))
        }
    }

    $('.event-location').on('select2:select', function (e) {
        let id = e.params.data.element.value
        $('.add-location').val(id).trigger('change')

        if (id != '') {
            if (currentRouteName == 'events.edit') {
                if (locationMeta[0] == 1) {
                    $('.add-location-modal').removeClass('d-none')
                    $('#shortDescLoc').
                        val(locationMeta[1] ? locationMeta[1] : '')
                    $('#longDescLoc').
                        val(locationMeta[2] ? locationMeta[2] : '')
                    $('.long-desc-loc').addClass('d-none')
                    $('.add-information-loc').removeClass('d-none')
                    if (locationMeta[2] != undefined) {
                        $('.long-desc-loc').removeClass('d-none')
                        $('.add-information-loc').addClass('d-none')
                    }
                } else if (locationMeta[0] == 2 && locationMeta[1] == 2) {
                    $('.add-location-modal').removeClass('d-none')
                    $('#phoneCallOption2').prop('checked', true)
                    $('#callNumber').removeClass('d-none')
                    $('#longDescCall').
                        val(locationMeta[3] ? locationMeta[3] : '')
                    $('.long-desc-call').addClass('d-none')
                    $('.add-information-call').removeClass('d-none')
                    if (locationMeta[3] != undefined) {
                        $('.long-desc-call').removeClass('d-none')
                        $('.add-information-call').addClass('d-none')
                    }
                }else {
                    $('.add-location-modal').addClass('d-none')
                }
            }
            if (id == 1) {
                $('.add-location-modal').removeClass('d-none')
                $('#locationData').removeClass('d-none')
                $('#phoneCallData').addClass('d-none')
            } else if (id == 2) {
                $('.add-location-modal').removeClass('d-none')
                $('#phoneCallData').removeClass('d-none')
                $('#locationData').addClass('d-none')
            }else {
                $('.add-location-modal').addClass('d-none')
            }

            listenClick('.phone-call-option', function () {
                if ($('#phoneCallOption2').is(':checked')) {
                    $('#callNumber').removeClass('d-none')
                } else {
                    $('#callNumber').addClass('d-none')
                }
            })

            if (currentRouteName == 'events.create') {
                $('.long-desc-loc').addClass('d-none')
                $('.add-information-loc').removeClass('d-none')
            }

            listenClick('.add-information-loc', function () {
                $('.long-desc-loc').removeClass('d-none')
                $('.add-information-loc').addClass('d-none')
            })

            if (currentRouteName == 'events.create') {
                $('.long-desc-call').addClass('d-none')
                $('.add-information-call').removeClass('d-none')
            }

            listenClick('.add-information-call', function () {
                $('.long-desc-call').removeClass('d-none')
                $('.add-information-call').addClass('d-none')
            })

            if (id == 1 || id == 2) {
                $('#updateLocation').modal('show').appendTo('body')
            } else {
                $('#locationAddData').val('["' + id + '"]')
            }
        }
    })

    $('.add-location').on('select2:select', function (e) {
        let id = e.params.data.element.value

        if (id == 1) {
            $('#locationData').removeClass('d-none')
            $('#phoneCallData').addClass('d-none')
            setTimeout(function () {
                $('#shortDescLoc').focus()
            }, 500)
        } else if (id == 2) {
            $('#phoneCallData').removeClass('d-none')
            $('#locationData').addClass('d-none')
        }
        if (id != '') {
            if (currentRouteName == 'events.edit') {
                if (locationMeta[0] == 1) {
                    $('#shortDescLoc').
                        val(locationMeta[1] ? locationMeta[1] : '')
                    $('#longDescLoc').
                        val(locationMeta[2] ? locationMeta[2] : '')
                    $('.long-desc-loc').addClass('d-none')
                    $('.add-information-loc').removeClass('d-none')
                    if (locationMeta[2] != undefined) {
                        $('.long-desc-loc').removeClass('d-none')
                        $('.add-information-loc').addClass('d-none')
                    }
                } else if (locationMeta[0] == 2 && locationMeta[1] == 2) {
                    $('#phoneCallOption2').prop('checked', true)
                    $('#callNumber').removeClass('d-none')
                    $('#longDescCall').
                        val(locationMeta[3] ? locationMeta[3] : '')
                    $('.long-desc-call').addClass('d-none')
                    $('.add-information-call').removeClass('d-none')
                    if (locationMeta[3] != undefined) {
                        $('.long-desc-call').removeClass('d-none')
                        $('.add-information-call').addClass('d-none')
                    }
                }
            }
            if (id == 1) {
                $('#locationData').removeClass('d-none')
                $('#phoneCallData').addClass('d-none')
                setTimeout(function () {
                    $('#shortDescLoc').focus()
                }, 500)
            } else if (id == 2) {
                $('#phoneCallData').removeClass('d-none')
                $('#locationData').addClass('d-none')
            }

            listenClick('.phone-call-option', function () {
                if ($('#phoneCallOption2').is(':checked')) {
                    $('#callNumber').removeClass('d-none')
                } else {
                    $('#callNumber').addClass('d-none')
                }
            })
        }

        listenClick('.phone-call-option', function () {
            if ($('#phoneCallOption2').is(':checked')) {
                $('#callNumber').removeClass('d-none')
            } else {
                $('#callNumber').addClass('d-none')
            }
        })

        if (currentRouteName == 'events.create') {
            $('.long-desc-loc').addClass('d-none')
            $('.add-information-loc').removeClass('d-none')
        }

        listenClick('.add-information-loc', function () {
            $('.long-desc-loc').removeClass('d-none')
            $('.add-information-loc').addClass('d-none')
        })

        if (currentRouteName == 'events.create') {
            $('.long-desc-call').addClass('d-none')
            $('.add-information-call').removeClass('d-none')
        }

        listenClick('.add-information-call', function () {
            $('.long-desc-call').removeClass('d-none')
            $('.add-information-call').addClass('d-none')
        })

        if (id == 1 || id == 2) {
            $('#updateLocation').modal('show').appendTo('body')
        }
    })

    $('.payment-type').on('select2:select', function (e) {
        let id = e.params.data.element.value

        if (id == 2) {
            $('#payableAmount').removeClass('d-none')
            $('#payableAmountId').prop('disabled', false)
        } else {
            $('#payableAmount').addClass('d-none')
            $('#payableAmountId').prop('disabled', true)
        }
    })
}

listenClick('.add-location-modal', function () {
    let id = $('.event-location').val()
    if (id == '' || id == 1) {
        $('#locationData').removeClass('d-none')
        $('#phoneCallData').addClass('d-none')
    } else if (id == 2) {
        $('#locationData').addClass('d-none')
        $('#phoneCallData').removeClass('d-none')
    }

    $('#updateLocation').modal('show').appendTo('body')

    if (id != '') {
        if (currentRouteName == 'events.edit') {
            if (locationMeta[0] == 1) {
                $('.add-location').val(id).trigger('change')
                $('#shortDescLoc').val(locationMeta[1] ? locationMeta[1] : '')
                $('#longDescLoc').val(locationMeta[2] ? locationMeta[2] : '')
                $('.long-desc-loc').addClass('d-none')
                $('.add-information-loc').removeClass('d-none')
                if (locationMeta[2] != undefined) {
                    $('.long-desc-loc').removeClass('d-none')
                    $('.add-information-loc').addClass('d-none');
                }
            } else if (locationMeta[0] == 2 && locationMeta[1] == 2) {
                $('.add-location').val(id).trigger('change');
                $('#phoneCallOption2').prop('checked', true);
                $('#callNumber').removeClass('d-none');
                $('#longDescCall').val(locationMeta[3] ? locationMeta[3] : '');
                $('.long-desc-call').addClass('d-none');
                $('.add-information-call').removeClass('d-none');
                if (locationMeta[3] != undefined){
                    $('.long-desc-call').removeClass('d-none');
                    $('.add-information-call').addClass('d-none');
                }
            }
        }
        if (id == 1) {
            $('#locationData').removeClass('d-none');
            $('#phoneCallData').addClass('d-none');
        } else if(id == 2){
            $('#phoneCallData').removeClass('d-none');
            $('#locationData').addClass('d-none');
        }

        listenClick('.phone-call-option', function () {
            if ($('#phoneCallOption2').is(':checked')) {
                $('#callNumber').removeClass('d-none')
            } else {
                $('#callNumber').addClass('d-none')
            }
        })

        if (currentRouteName == 'events.create') {
            $('.long-desc-loc').addClass('d-none');
            $('.add-information-loc').removeClass('d-none');
        }

        $(document).on('click', '.add-information-loc', function () {
            $('.long-desc-loc').removeClass('d-none')
            $('.add-information-loc').addClass('d-none')
        })

        if (currentRouteName == 'events.create') {
            $('.long-desc-call').addClass('d-none')
            $('.add-information-call').removeClass('d-none')
        }

        listenClick('.add-information-call', function () {
            $('.long-desc-call').removeClass('d-none')
            $('.add-information-call').addClass('d-none')
        })

        if (id == 1 || id == 2) {
            $('#updateLocation').modal('show').appendTo('body')
        } else {
            $('#locationAddData').val('["' + id + '"]')
        }
    }
});

listenSubmit('#addLocationInfo', function (e) {
    e.preventDefault()
    let id = $('.add-location').val()
    let prepareLocationData = []
    let radio = $('#phoneCallOption').val()
    if ($('#phoneCallOption2').prop('checked') == true) {
        radio = $('#phoneCallOption2').val()
    }

    if (id == 1) {
        let shortName = $('#shortDescLoc').val()
        let empty = shortName.trim().replace(/ \r\n\t/g, '') === ''

        if (shortName == '') {
            $('#shortDescLoc').focus()
            displayErrorMessage(Lang.get('js.location'))
            return false
        }

        if (empty) {
            displayErrorMessage(Lang.get('js.location_white'))
            return false
        }

        prepareLocationData.push(id)
        prepareLocationData.push($('#shortDescLoc').val())
        if ($('#longDescLoc').val() != '') {
            prepareLocationData.push($('#longDescLoc').val())
        }
    }

    if (id == 2) {
        if ($('#phoneCallOption').prop('checked') == true) {
            prepareLocationData.push(id);
            prepareLocationData.push(radio);
            $('#updateLocation').modal('hide');
        } else {
            if ($('#phoneNumber').val() == '') {
                $('#phoneNumber').focus()
                displayErrorMessage(Lang.get('js.phone'))
                return false;
            }
            prepareLocationData.push(id);
            prepareLocationData.push(radio);
            prepareLocationData.push(
                '+' + $('#prefix_code').val() + $('#phoneNumber').val());
            if ($('#longDescCall').val() != '') {
                prepareLocationData.push($('#longDescCall').val());
            }
        }
    }

    $('#locationAddData').val(JSON.stringify(prepareLocationData));
    $('#updateLocation').modal('hide');
    $('.event-location').val($('.add-location').val()).trigger('change');
});

let picked = false;

listenClick('#color', function () {
    picked = true
})

listen('keypress', '#eventLinkId', function (e) {
    if (e.keyCode === 32 || e.keyCode === 95) {
        return false
    }
    let keyCode = e.keyCode || e.which
    let regex = /^[A-Za-z0-9\-]+$/
    let isValid = regex.test(String.fromCharCode(keyCode))
    if (!isValid) {
        return false
    }
})

// Click on within data range checkbox js code
listenClick('input[name=date_range]', function () {
    if ($(this).hasClass('within-date-range')) {
        $('#withinDateRangeId').removeClass('d-none')
        $('#withinDateRangeId').prop('disabled', false)
        $('#scheduleDayId').prop('disabled', true)
    } else {
        $('#withinDateRangeId').addClass('d-none')
        $('#withinDateRangeId').prop('disabled', true)
        $('#scheduleDayId').prop('disabled', false)
    }
})

// Click on additional info link time slide up and down js code
listenClick('.add-rules-info', function () {
    if ($('.additional-event-rules').hasClass('d-none')) {
        $(this).next().removeClass('fa-chevron-right')
        $(this).next().addClass('fa-chevron-down')
        $('.additional-event-rules').removeClass('d-none')
    } else {
        $(this).next().removeClass('fa-chevron-down')
        $(this).next().addClass('fa-chevron-right')
        $('.additional-event-rules').addClass('d-none')
    }
})

// Click on before event checkbox then after select is enabled otherwise disabled js code
listenClick('.before-time', function () {
    if ($(this).prop('checked') == true) {
        $('#beforeEventTimeId').prop('disabled', false)
    } else {
        $('#beforeEventTimeId').prop('disabled', true)
    }
})

// Click on after event checkbox then after select is enabled otherwise disabled js code
listenClick('.after-time', function () {
    if ($(this).prop('checked') == true) {
        $('#afterEventTimeId').prop('disabled', false)
    } else {
        $('#afterEventTimeId').prop('disabled', true)
    }
})

listenKeyup('#scheduleDayId', function () {
    let scheduleDayId = $(this).val()
    scheduleDayId = parseInt(removeCommas(scheduleDayId))
    $(this).val(scheduleDayId)
})

listenKeyup('#maxEventPerDay', function () {
    let maxEventPerDay = $(this).val()
    maxEventPerDay = parseInt(removeCommas(maxEventPerDay))
    $(this).val(maxEventPerDay)
})

listenSubmit('#eventStoreForm', function () {
    if ($('[name="event_location"]').val() == 1 &&
        $('#locationAddData').val() == '') {
        displayErrorMessage(Lang.get('js.location'))
        return false
    } else if ($('[name="event_location"]').val() == 2 &&
        $('#locationAddData').val() == '') {
        displayErrorMessage(Lang.get('js.phone'))
        return false
    }
    $('#btnSave').attr('disabled', true)
})

listenSubmit('#eventEditForm', function () {
    if ($('[name="event_location"]').val() == 1 &&
        $('#locationAddData').val() == '') {
        displayErrorMessage(Lang.get('js.location'))
        return false
    } else if ($('[name="event_location"]').val() == 2 &&
        $('#locationAddData').val() == '') {
        displayErrorMessage(Lang.get('js.phone'))
        return false
    }
    $('#btnSave').attr('disabled', true)
})

listenHiddenBsModal('#addScheduleNameModal', function () {
    resetModalForm('#scheduleNameForm', '#scheduleValidationErrorsBox')
})

if(currentRouteName == 'events.create') {
    listenHiddenBsModal('#updateLocation', function () {
        $('#phoneNumber').val('')
        $('#valid-msg').addClass('hide')
        $('#error-msg').addClass('hide')
        resetModalForm('#addLocationInfo', '#updateLocationValidationErrorsBox')
    })
}
