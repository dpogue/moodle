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
 * @package    block_newsletter
 * @copyright  2012 Darryl Pogue
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 */

require_once("../../config.php");

$id  = required_param('id', PARAM_INT);    // Daily News item ID

if (!$daily = $DB->get_record('daily_news', array('id' => $id))) {
    print_error('invalidcoursemodule');
}

$PAGE->set_url('/blocks/newsletter/daily.php', array('id'=>$id));

require_login(SITEID);

$PAGE->set_title(get_string('dailynews', 'block_newsletter'));
$PAGE->set_heading(get_string('dailynews', 'block_newsletter'));
$PAGE->set_pagelayout('popup');

echo $OUTPUT->header();

echo $daily->content;

echo $OUTPUT->footer();
