// document.addEventListener('turbo:load', loadUserData)

Livewire.hook("element.init", () => {
    loadUserData();
});

function loadUserData () {
    if (!$('#personalExperiences').length) {
        return
    }

    $('#personalExperiences').select2({
        width: '100%',
        placeholder: Lang.get(
            'js.select_personal_experience'),
    })
}

// reset filter modal code
listenClick('#resetFilter', function () {
    Livewire.dispatch('refresh')
    $('#personalExperiences').val('').trigger('change')
    $('#personalExpFilterBtn').dropdown('toggle')
})

// user record delete code
listenClick('.user-delete-btn', function () {
    let deleteUserId = $(this).attr('data-id')
    deleteItem(route('users.destroy', deleteUserId),
        Lang.get('js.user_details'))
})

// admin record delete code
listenClick('.admin-delete-btn', function () {
    let deleteAdminId = $(this).attr('data-id')
    deleteItem(route('admins.destroy', deleteAdminId),
        Lang.get('js.admin'))
})

//  call to filter data code
listenChange('#personalExperiences', function () {
    Livewire.dispatch('changeFilter', {value:$(this).val()})
    hideDropdownManually($('#userFilterBtn'))
})

listen('contextmenu', '.user-impersonate', function (e) {
    e.preventDefault(); // Stop right click on link
    return false;
});

var control = false;
listen('keyup keydown', function (e) {
    control = e.ctrlKey;
});

listenClick( '.user-impersonate', function () {
    if (control) {
        return false; // Stop ctrl + click on link
    }
    let id = $(this).data('id')
    let element = document.createElement('a')
    element.setAttribute('href', route('impersonate', id))
    element.setAttribute('data-turbo', false)
    document.body.appendChild(element)
    element.click()
    document.body.removeChild(element)
    $('.user-impersonate').prop('disabled', true)
});

// Call Email verify JS code for user
listenClick('.user-email-verify', function () {
    let userId = $(this).attr('data-id')
    Livewire.dispatch('userEmailVerify', {id:userId})
})

// Call Email verify JS code for admin
listenClick('.admin-email-verify', function () {
    let adminId = $(this).attr('data-id')
    Livewire.dispatch('adminEmailVerify', {id:adminId})
})

document.addEventListener('email-verify-success', function () {
    displaySuccessMessage(Lang.get('js.email_verified_successfully'))
})
