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

require('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

// retrieve parameters
$newsid = required_param('id', PARAM_INT);

$PAGE->set_url('/admin/tool/dailynews/delete.php', array('id'=>$newsid));

require_login(SITEID);

$systemcontext = get_context_instance(CONTEXT_SYSTEM);
require_capability('tool/dailynews:add', $systemcontext);


if (!$news = $DB->get_record('daily_news', array('id' => $newsid))) {
    print_error('invalidid');
}

if (data_submitted() && confirm_sesskey()) {
//if data was submitted and is valid, then delete note
    $returnurl = $CFG->wwwroot . '/admin/tool/dailynews/index.php';

    if (!$DB->delete_records('daily_news', array('id' => $newsid))) {
        print_error('couldnotdelete', 'tool_dailynews');
    }

    redirect($returnurl);
} else {
    $optionsyes = array('id'=>$newsid, 'sesskey'=>sesskey());

    echo $OUTPUT->header();
    echo $OUTPUT->confirm(get_string('deleteconfirm', 'tool_dailynews'), new moodle_url('delete.php',$optionsyes),  new moodle_url('index.php'));
    echo $OUTPUT->footer();
}
