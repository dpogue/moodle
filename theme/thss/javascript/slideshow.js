function slideshow_next() {
    if (document.hidden || document.webkitHidden) {
        return;
    }

    var ss = $('#slideshow_current');
    var i = parseInt(ss.attr('data-slideshow-index'));

    i++;
    if (i >= M.thss_slideshow.length) {
        i = 0;
    }
    ss.attr('data-slideshow-index', i);

    ss.fadeOut(1000, function() {
        ss.css({'background-image': 'url(' + M.thss_slideshow[i] + ')'});
        ss.fadeIn(1000, function() {
            $('#slideshow').css({'background-image': 'none'});
        });
    });
}

$(function() {
    if (M.thss_slideshow) {
        window.setInterval(slideshow_next, 7000);
        $(M.thss_slideshow).each(function() {
            $('<img />')[0].src = this;
        });
    }
});
