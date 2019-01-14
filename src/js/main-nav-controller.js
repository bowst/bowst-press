var bMobile; // true if in mobile mode

// Initiate event handlers
function initNav() {
    'use strict';
    // .navbar-toggle is only visible in mobile mode
    bMobile = jQuery('.navbar-toggler').is(':visible');
    var oMenus = jQuery('.navbar-nav .dropdown'),
        nTimer;
    if (bMobile) {
        // Disable hover events for mobile
        oMenus.off();
    } else {
        oMenus.on({
            mouseenter: function(event) {
                event.preventDefault();
                clearTimeout(nTimer);
                oMenus.removeClass('show');
                jQuery(this).addClass('show');
            },
            mouseleave: function(event) {
                nTimer = setTimeout(function() {
                    oMenus.removeClass('show');
                }, 500);
            }
        });
    }

    jQuery('li.menu-item-has-children .toggle').on('click touchend', function(e) {
        e.preventDefault();

        jQuery(this)
            .toggleClass('active')
            .parent()
            .parent()
            .find('.dropdown-menu')
            .toggleClass('show');
    });
}

jQuery(document).ready(function($) {
    initNav();

    $(window).resize(initNav);
});
