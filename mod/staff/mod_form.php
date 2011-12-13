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

require_once ($CFG->dirroot.'/course/moodleform_mod.php');
require_once ($CFG->dirroot.'/cohort/lib.php');

function get_cohorts_list() {
    global $DB;

    $cohorts = array();

    $fields = 'SELECT *';
    $sql = " FROM {cohort}
             WHERE 1";
    $order = ' ORDER BY name ASC';
    $cohorts = $DB->get_records_sql($fields . $sql . $order);

    $list = array();
    foreach ($cohorts as $c) {
        $list[$c->id] = $c->name;
    }

    return $list;
}

class mod_staff_mod_form extends moodleform_mod {

    function definition() {

        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('select', 'cohort', get_string('cohort', 'staff'), get_cohorts_list());
        $mform->addHelpButton('cohort', 'cohort', 'staff');

        $mform->addElement('selectyesno', 'allowemails', get_string('allowemails', 'staff'));
        $mform->setDefault('allowemails', true);
        $mform->addHelpButton('allowemails', 'allowemails', 'staff');

        $mform->addElement('selectyesno', 'showdescription', get_string('showdescription', 'staff'));
        $mform->setDefault('showdescription', false);
        $mform->addHelpButton('showdescription', 'showdescription', 'staff');

        $this->standard_coursemodule_elements();

//-------------------------------------------------------------------------------
// buttons
        $this->add_action_buttons(true, false, null);

    }

}
