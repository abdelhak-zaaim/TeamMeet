document.addEventListener('turbo:load', loadSidebarMenuData)

function loadSidebarMenuData () {
    // image load component
    IOInitImageComponent()
    // SideBar asideMenu initialize
    IOInitSidebar()

    let activeMenu = $(document).find('.sidebar-menu li.active')
    let activeDropdown = $(document).
        find('.sidebar-menu li.active')
    let activeDropdownMenu = $(activeDropdown).
        parents('.nav-item ul')

    let $block = $('.no-results')

    listenKeyup('#searchText', function () {
        let searchText = $(this).val()
        let isMatch = false

        let value = this.value.toLowerCase().trim()

        listenClick('.close-sign', function () {
            $('#searchText').val('')
            $('.nav-item').show().filter(function () {
                if (searchText != '') {
                    $(this).removeClass('active')
                }
            })
            $('.close-sign').hide()
            $('.search-sign').show()
            $('.no-results').addClass('d-none')
            toggleSubMenu()
        });

        $('.nav-item').show().filter(function () {
            $(this).addClass('active');
            if (searchText == '') {
                $(this).removeClass('active');
                $('.close-sign').hide();
                $('.search-sign').show();
                toggleSubMenu();
            }
            if ($(this).text().toLowerCase().trim().indexOf(value) == -1) {
                $(this).hide()
                $('.close-sign').show()
                $('.search-sign').hide()
            } else {
                isMatch = true
                $(this).show()
            }
        });
        $('.no-results').removeClass('d-none')
        $('.no-results').toggle(!isMatch)
    });

    window.toggleSubMenu = function () {
        let hasClassNames = $(document).find('.nav-item');
        if (hasClassNames.hasClass('dropdown-menu'))
            $('.dropdown-menu').css('display', 'none');

        $(activeMenu).addClass('active');
        $(activeDropdown).parents(activeDropdown).addClass('active');
        $(activeDropdownMenu).css({ 'display': 'block' });
    };
}
