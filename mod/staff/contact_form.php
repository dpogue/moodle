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

require_once($CFG->libdir.'/formslib.php');

class staff_contact_form extends moodleform {

    function definition() {

        global $CFG, $COURSE, $USER;
        $mform    =& $this->_form;

        //$mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'subject',get_string('subject', 'staff'), 'size="25"');
        $mform->setType('subject', PARAM_TEXT);
        $mform->addRule('subject', get_string('required'), 'required', null, 'client');
        
        $mform->addElement('text', 'email', get_string('emailreplyaddress', 'staff'), 'size="25"');
        $mform->setType('email', PARAM_TEXT);
        $mform->addRule('email', get_string('required'), 'required', null, 'client');

        $mform->addElement('htmleditor', 'content', get_string('messagebody', 'staff'), array('width'=>425, 'height'=>400, 'toolbar'=>false));
        $mform->setType('content', PARAM_RAW);
        $mform->addRule('content', get_string('required'), 'required', null, 'client');
        
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', 0);
        
        $mform->addElement('hidden', 'uid');
        $mform->setType('uid', PARAM_INT);
        $mform->setDefault('uid', 0);
        
        $this->add_action_buttons(false, get_string('send', 'staff'));
    }
}

?>
