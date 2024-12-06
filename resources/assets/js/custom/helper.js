window.listen = function (event, selector, callback) {
    $(document).on(event, selector, callback)
}

window.listenClick = function (selector, callback) {
    $(document).on('click', selector, callback)
}

window.listenSubmit = function (selector, callback) {
    $(document).on('submit', selector, callback)
}

window.listenChange = function (selector, callback) {
    $(document).on('change', selector, callback)
}

window.listenKeyup = function (selector, callback) {
    $(document).on('keyup', selector, callback)
}

window.listenHiddenBsModal = function (selector, callback) {
    $(document).on('hidden.bs.modal', selector, callback)
}
