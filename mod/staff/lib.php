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

defined('MOODLE_INTERNAL') || die;

/**
 * @param object $list
 * @return string
 */
function get_staff_name($list) {
    return get_string('modulename','staff');
}
/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @global object
 * @param object $list
 * @return bool|int
 */
function staff_add_instance($list) {
    global $DB;

    $list->name = get_staff_name($list);
    $list->timemodified = time();

    return $DB->insert_record("staff", $list);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @param object $label
 * @return bool
 */
function staff_update_instance($list) {
    global $DB;

    $list->name = get_staff_name($list);
    $list->timemodified = time();
    $list->id = $list->instance;

    return $DB->update_record("staff", $list);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id
 * @return bool
 */
function staff_delete_instance($id) {
    global $DB;

    if (! $list = $DB->get_record("staff", array("id"=>$id))) {
        return false;
    }

    $result = true;

    if (! $DB->delete_records("staff", array("id"=>$list->id))) {
        $result = false;
    }

    return $result;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 * See get_array_of_activities() in course/lib.php
 *
 * @global object
 * @param object $coursemodule
 * @return object|null
 */
function staff_get_coursemodule_info($coursemodule) {
    global $DB;

    if ($list = $DB->get_record('staff', array('id'=>$coursemodule->instance), 'id, name')) {
        if (empty($list->name)) {
            // list name missing, fix it
            $list->name = get_staff_name(null);
            $DB->set_field('staff', 'name', $list->name, array('id'=>$list->id));
        }
        $info = new stdClass();
        $info->name  = $list->name;
        return $info;
    } else {
        return null;
    }
}

/**
 * @return array
 */
function staff_get_view_actions() {
    return array();
}

/**
 * @return array
 */
function staff_get_post_actions() {
    return array();
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 *
 * @param object $data the data submitted from the reset course.
 * @return array status array
 */
function staff_reset_userdata($data) {
    return array();
}

/**
 * Returns all other caps used in module
 *
 * @return array
 */
function staff_get_extra_capabilities() {
    return array();
}

/**
 * @uses FEATURE_IDNUMBER
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return bool|null True if module supports feature, false if not, null if doesn't know
 */
function staff_supports($feature) {
    switch($feature) {
        case FEATURE_IDNUMBER:                return false;
        case FEATURE_GROUPS:                  return false;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_GROUPMEMBERSONLY:        return false;
        case FEATURE_MOD_INTRO:               return false;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return false;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_BACKUP_MOODLE2:          return false;
        case FEATURE_SHOW_DESCRIPTION:        return false;

        default: return null;
    }
}

