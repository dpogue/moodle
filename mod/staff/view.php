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

$id = optional_param('id',0,PARAM_INT);    // Course Module ID, or
$l = optional_param('l',0,PARAM_INT);     // List ID

if ($id) {
    $PAGE->set_url('/mod/staff/index.php', array('id'=>$id));
    if (! $cm = get_coursemodule_from_id('staff', $id)) {
        print_error('invalidcoursemodule');
    }

    if (! $course = $DB->get_record("course", array("id"=>$cm->course))) {
        print_error('coursemisconf');
    }

    if (! $list = $DB->get_record("staff", array("id"=>$cm->instance))) {
        print_error('invalidcoursemodule');
    }

} else {
    $PAGE->set_url('/mod/staff/index.php', array('l'=>$l));
    if (! $list = $DB->get_record("staff", array("id"=>$l))) {
        print_error('invalidcoursemodule');
    }
    if (! $course = $DB->get_record("course", array("id"=>$list->course)) ){
        print_error('coursemisconf');
    }
    if (! $cm = get_coursemodule_from_instance("staff", $list->id, $course->id)) {
        print_error('invalidcoursemodule');
    }
}

require_course_login($course->id, true, $cm);

if ($course->id != SITEID) {
    require_login($course->id);
}

$staffusers = array();
$params = array('cohortid' => $list->cohort);
$fields = 'SELECT u.*';
$sql = " FROM {user} u
         JOIN {cohort_members} cm ON (cm.userid = u.id AND cm.cohortid = :cohortid)
         WHERE 1";
$order = " ORDER BY u.lastname ASC, u.firstname ASC";

$staffusers = $DB->get_records_sql($fields . $sql . $order, $params);

$PAGE->set_title(format_string($list->name));
$PAGE->set_heading($list->name);

echo $OUTPUT->header();

foreach ($staffusers as $user) { ?>
    <div class="staff">
        <?php echo $OUTPUT->user_picture($user, array('size' => 50, 'link' => false, 'class' => 'img')); ?>
        <div class="body">
            <h3><?php echo fullname($user); ?></h3>
        <?php if ($list->showdescription) { ?>
            <p><?php echo $user->description; ?></p>
        <?php } ?>
        <?php if ($list->allowemails) { ?>
            <?php 
            $link = new moodle_url('/mod/staff/contact.php', array('id' => $cm->id, 'uid' => $user->id)); 
            $action = new popup_action('click', $link);
            echo $OUTPUT->action_link($link, $OUTPUT->pix_icon('i/email', '') . ' '.get_string('sendemaillink', 'staff'), $action); ?>
        <?php } ?>
        </div>
    </div>
<?php
}

/// Finish the page
echo $OUTPUT->footer();
