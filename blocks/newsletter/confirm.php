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
 * @copyright  2011 Darryl Pogue
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 */

require('../../config.php');

$secret = required_param('confirm', PARAM_TEXT);

$PAGE->set_url('/blocks/newsletter/confirm.php', array('confirm' => $secret));
$PAGE->set_course($SITE);

if (!$row = $DB->get_record('newsletter_email', array('secret' => $secret))) {
    print_error(get_string('wrongtoken', 'block_newsletter'));
}

$row->confirm = true;

if (!$DB->update_record('newsletter_email', $row)) {
    print_error(get_string('wrongtoken', 'block_newsletter'));
}

echo $OUTPUT->header();
echo $OUTPUT->notification('You will now receive email notifications when newsletters are published.', 'notifysuccess');
echo $OUTPUT->continue_button($CFG->wwwroot);
echo $OUTPUT->footer();
