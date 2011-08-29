<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The weather-fetching AJAX page for the thss theme.
 *
 * @copyright 2011 Darryl Pogue
 * @license   http://www.gnu.org/copyleft/gpl.html
 * @since     Moodle 2.0
 */
require_once('../../config.php');
require_once($CFG->libdir.'/filelib.php');

header('Content-Type: application/json');

try {
    $xml = download_file_content('http://api.wunderground.com/weatherstation/WXCurrentObXML.asp?ID=IBCMAPLE3');

    $dom = new DOMDocument();
    $dom->loadXML($xml);
    $xpath = new DOMXPath($dom);

    $temperature  = $xpath->query('//temp_c')->item(0)->textContent;
    $temperature .= ' &deg;C';

    $humidity  = $xpath->query('//relative_humidity')->item(0)->textContent;
    $humidity .= '%';

    $pressure  = $xpath->query('//pressure_mb')->item(0)->textContent;
    $pressure .= ' mb';

    $dewpoint  = $xpath->query('//dewpoint_c')->item(0)->textContent;
    $dewpoint .= ' &deg;C';

    $hourly  = $xpath->query('//precip_1hr_metric')->item(0)->textContent;
    $hourly .= ' mm';

    $daily  = $xpath->query('//precip_today_metric')->item(0)->textContent;
    $daily .= ' mm';

    $wind_dir = $xpath->query('//wind_dir')->item(0)->textContent;

    $wind_rot = $xpath->query('//wind_degrees')->item(0)->textContent;

    $wind_speed  = floatval($xpath->query('//wind_mph')->item(0)->textContent);
    $wind_speed *= 1.609344;
    $wind_speed .= ' km/h';

    $uv = $xpath->query('//UV')->item(0)->textContent;

    echo  '{'
         .'"temperature":"'.$temperature.'",'
         .'"humidity":"'.$humidity.'",'
         .'"pressure":"'.$pressure.'",'
         .'"dewpoint":"'.$dewpoint.'",'
         .'"precip_hourly":"'.$hourly.'",'
         .'"precip_daily":"'.$daily.'",'
         .'"wind_dir":"'.$wind_dir.'",'
         .'"wind_rot":"'.$wind_rot.'",'
         .'"wind_speed":"'.$wind_speed.'",'
         .'"uv_index":"'.$uv.'"'
         .'}';
} catch (Exception $e) {
    echo '{"error":true}';
}
