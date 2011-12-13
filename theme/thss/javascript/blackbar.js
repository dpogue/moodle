$(function() {
    var mouse_in_panel = false;

    $('#blackbar .popup').live('click', function() {
        $(this.parentNode).toggleClass('open');
        mouse_in_panel = $(this.parentNode).hasClass('open');
    });

    $('#blackbar .open').live('mouseenter', function() {
        mouse_in_panel = true;
    });

    $('#blackbar .open').live('mouseleave', function() {
        mouse_in_panel = false;
    });

    $('body').mouseup(function() {
        if (!mouse_in_panel) $('#blackbar .open').removeClass('open');
    });
});
