let mobile; // true if in mobile mode

// Initiate event handlers
function initNav() {
    'use strict';
    // .navbar-toggle is only visible in mobile mode
    let mobile = jQuery('.navbar-toggler').is(':visible'),
        dropdownItems = jQuery('.navbar-nav .dropdown'),
        dropdowns = jQuery('.navbar-nav .dropdown-menu'),
        timer;
    if (mobile) {
        // Disable hover events for mobile
        dropdownItems.off();
        dropdowns.off();
    } else {
        dropdownItems.on({
            mouseenter: function (e) {
                e.preventDefault();
                clearTimeout(timer);
                jQuery(this).addClass('show');
                jQuery(this).find('> .dropdown-menu').addClass('show');
            },
            mouseleave: function (e) {
                let thisMenu = jQuery(this);
                timer = setTimeout(function () {
                    thisMenu.removeClass('show');
                }, 500);

                thisMenu.find('> .dropdown-menu').removeClass('show');
            },
        });

        dropdowns.on({
            mouseleave: function () {
                let thisDropdown = jQuery(this);
                timer = setTimeout(function () {
                    thisDropdown.removeClass('show');
                }, 500);
            },
        });
    }

    jQuery('li.menu-item-has-children .toggle').on(
        'click touchend',
        function (e) {
            e.preventDefault();

            jQuery(this)
                .toggleClass('active')
                .parent()
                .parent()
                .toggleClass('show')
                .find('> .dropdown-menu')
                .toggleClass('show');
        }
    );
}

jQuery(function ($) {
    initNav();

    $(window).on('resize', initNav);
});
