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
require('locallib.php');

$email = required_param('email', PARAM_EMAIL);

$PAGE->set_url('/blocks/newsletter/subscribe.php', array('email' => $email));
$PAGE->set_course($SITE);

if ($DB->get_record('newsletter_email', array('email' => $email))) {
    print_error('emailexists');
}

$data = new stdClass();
$data->email = $email;
$data->confirm = false;
$data->secret = random_string(10);

if (!$DB->insert_record('newsletter_email', $data)) {
    print_error(get_string('wrongtoken', 'block_newsletter'));
}

$text = subscription_verification_text($data);
if (!email_to_address($email, null, 'THSS Newsletter Registration', $text)) {
    print_error('Failed to send email verification');
}

echo $OUTPUT->header();
echo $OUTPUT->notification('Please check your email for a confirmation link', 'notifysuccess');
echo $OUTPUT->continue_button($CFG->wwwroot);
echo $OUTPUT->footer();
