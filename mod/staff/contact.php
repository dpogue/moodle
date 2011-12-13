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
 * Staff List module version info
 *
 * @package    mod
 * @subpackage staff list
 * @copyright  2011 onwards Darryl Pogue  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");

$id  = required_param('id', PARAM_INT);    // Course Module ID
$uid = required_param('uid', PARAM_INT);    // User ID

if (! $cm = get_coursemodule_from_id('staff', $id)) {
    print_error('invalidcoursemodule');
}

if (! $course = $DB->get_record("course", array("id"=>$cm->course))) {
    print_error('coursemisconf');
}

if (! $list = $DB->get_record("staff", array("id"=>$cm->instance))) {
    print_error('invalidcoursemodule');
}

if (! $user = $DB->get_record("user", array('id'=>$uid))) {
    print_error('invaliduserid');
}

$PAGE->set_url('/mod/staff/contact.php', array('id'=>$id, 'uid'=>$uid));

require_course_login($course->id, true, $cm);

if ($course->id != SITEID) {
    require_login($course->id);
}

$PAGE->set_title(get_string('contactstaff', 'staff', fullname($user)));
$PAGE->set_heading(get_string('contactstaff', 'staff', fullname($user)));
$PAGE->set_pagelayout('popup');
    
    
require_once('contact_form.php');
$mform = new staff_contact_form('contact.php');

echo $OUTPUT->header();
    
    if ($fromform = $mform->get_data()) {
        if (!email_to_user($user, $fromform->email, $fromform->subject, stripslashes($fromform->content))) {
            print_error('emailfail');
            die;
        }
        
?>
    <p style="text-align: center;">
        <?php echo get_string('mailsent', 'message'); ?>
        <br><br>
        <a href="javascript:window.close()" onclick="window.close();">Continue</a>
    </p>
<?php
        die;
    }
?>
<div class="staff">
    <?php echo $OUTPUT->user_picture($user, array('size' => 50, 'link' => false, 'class' => 'img')); ?>
    <div class="body">
        <h3><?php echo fullname($user); ?></h3>
    </div>
</div>
<?php 

$mform->set_data(array('id' => $id, 'uid' => $uid));
if(isloggedin() && !isguestuser())
{
    $mform->set_data(array('email' => $USER->email));
}
$mform->display();

$OUTPUT->footer();
