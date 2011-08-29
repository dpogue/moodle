function update_weather() {
    if (document.hidden || document.webkitHidden) {
        return;
    }

    var cb = function(data) {
        if (data.error) { return; }

        $('#temperature').html(data.temperature);
        $('#humidity').html(data.humidity);
        $('#precip_daily').html(data.precip_daily);
        $('#precip_hourly').html(data.precip_hourly);
        $('#pressure').html(data.pressure);
        $('#uv_index').html(data.uv_index);
        $('#dewpoint').html(data.dewpoint);

        $('#winddir').text(data.wind_dir);
        $('#windspeed').text(data.wind_speed);
        $('#winddirrot').attr('transform', 'rotate('+data.wind_rot+', 32, 64)');
    };

    $.ajax({
        url: '/theme/thss/weather.php',
        method: 'GET',
        success: cb
    });
}

$(function() {
    window.setInterval(update_weather, 30000);
    update_weather();
});
