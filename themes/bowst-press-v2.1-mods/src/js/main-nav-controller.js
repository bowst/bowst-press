let timer;

function initNav() {
    'use strict';

    const toggler = document.querySelector('.navbar-toggler');
    const isMobile = toggler && window.getComputedStyle(toggler).display !== 'none';
    const dropdownItems = document.querySelectorAll('.navbar-nav .dropdown');
    const dropdowns = document.querySelectorAll('.navbar-nav .dropdown-menu');

    // Remove previous event listeners by cloning elements
    dropdownItems.forEach(function (item) {
        const clone = item.cloneNode(true);
        item.parentNode.replaceChild(clone, item);
    });

    // Re-query after cloning
    const freshDropdownItems = document.querySelectorAll('.navbar-nav .dropdown');
    const freshDropdowns = document.querySelectorAll('.navbar-nav .dropdown-menu');

    if (!isMobile) {
        freshDropdownItems.forEach(function (item) {
            item.addEventListener('mouseenter', function (e) {
                e.preventDefault();
                clearTimeout(timer);
                this.classList.add('show');
                const menu = this.querySelector(':scope > .dropdown-menu');
                if (menu) menu.classList.add('show');
            });

            item.addEventListener('mouseleave', function () {
                const self = this;
                timer = setTimeout(function () {
                    self.classList.remove('show');
                }, 500);
                const menu = this.querySelector(':scope > .dropdown-menu');
                if (menu) menu.classList.remove('show');
            });
        });

        freshDropdowns.forEach(function (dropdown) {
            dropdown.addEventListener('mouseleave', function () {
                const self = this;
                timer = setTimeout(function () {
                    self.classList.remove('show');
                }, 500);
            });
        });
    }

    document.querySelectorAll('li.menu-item-has-children .toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            this.classList.toggle('active');
            const parent = this.closest('.menu-item-has-children');
            if (parent) {
                parent.classList.toggle('show');
                const menu = parent.querySelector(':scope > .dropdown-menu');
                if (menu) menu.classList.toggle('show');
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initNav();
    window.addEventListener('resize', initNav);
});
