$(document).ready(function () {
    if(window.location.hash) {
        $(window.location.hash).scrollTo(1000);
    }

    $('a.scroll-to').on('click', function (e) {
        e.preventDefault();
        let id = $(this).attr('href');
        $(id).scrollTo(1000);
    });

    $('[data-confirm]').confirmAction();
    $('nav.sidebar').autoCollapse();
    $('[role="tablist"]').autoOpenTabOnError();
    $('[data-copy]').copyText();

    $('a[data-content]').popover({
        'trigger': 'click',
        'placement': 'auto',
        'html' : true,
        'template' : '<div class="popover info-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
    });
    $('.filter-helper').filterHelper('init', {toggleDuration: 400, expValue: true, minValue: true, maxValue: true});
    $('select.styled-select').customSelect();
});

window.onbeforeunload = function (e) {
    showOverlay();
};