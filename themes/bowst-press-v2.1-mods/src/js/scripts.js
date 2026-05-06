import { Tooltip } from 'bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new Tooltip(tooltipTriggerEl);
    });
});
