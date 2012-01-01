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
 * @package    tool
 * @subpackage dailynews
 * @copyright  2012 Darryl Pogue
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir.'/formslib.php';

class dailynews_post_form extends moodleform {

    function definition() {

        global $CFG;
        $mform    =& $this->_form;

        $mform->addElement('header', 'general', '');

        $mform->addElement('date_selector', 'datepublished', get_string('published', 'tool_dailynews'));
        $mform->addRule('datepublished', null, 'required');

        $options = array('subdirs'=>1, 'maxbytes'=>$CFG->maxbytes, 'maxfiles'=>-1, 'changeformat'=>1, 'noclean'=>1, 'trusttext'=>0);
        $mform->addElement('editor', 'news', get_string('content', 'tool_dailynews'), null, $options);
        $mform->addRule('news', get_string('required'), 'required', null, 'client');

        $this->add_action_buttons(true, get_string('publish', 'tool_newsletter'));
    }

    function data_preprocessing(&$default_values) {
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('dailynews');
            $options = array('subdirs'=>1, 'maxbytes'=>$CFG->maxbytes, 'maxfiles'=>-1, 'changeformat'=>1, 'noclean'=>1, 'trusttext'=>0);
            $default_values['page']['format'] = $default_values['contentformat'];
            $default_values['page']['text']   = file_prepare_draft_area($draftitemid, $this->context->id, 'tool_dailynews', 'content', 0, $options, $default_values['content']);
            $default_values['page']['itemid'] = $draftitemid;
        }
    }
}
?>
