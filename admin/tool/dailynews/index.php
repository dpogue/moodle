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

define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();
admin_externalpage_setup('tooldailynewsview');

$systemcontext = get_context_instance(CONTEXT_SYSTEM);
require_capability('tool/dailynews:viewall', $systemcontext);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('tooldailynewsview', 'tool_dailynews'));
//$form->display();
$sql = 'SELECT * FROM {daily_news} ORDER BY datepublished DESC';
$recs = $DB->get_records_sql($sql);

$table = new html_table();
$table->data = array();
$table->id = 'adminnewsletters';
$table->head = array(get_string('published', 'tool_dailynews'), get_string('preview'), get_string('edit'), get_string('delete'));

foreach ($recs as $daily) {
    $table->data[] = array(
        strftime('(%F) %B %e, %Y', $daily->datepublished),
        $OUTPUT->action_link(new moodle_url('/blocks/newsletter/daily.php', array('id' => $daily->id)), get_string('preview')),
        get_string('edit'),
        $OUTPUT->action_link(new moodle_url('delete.php', array('id' => $daily->id)), get_string('delete'))
    );
}

echo $OUTPUT->single_button(new moodle_url('post.php'), get_string('tooldailynewspost', 'tool_dailynews'));
echo '<br>';
echo html_writer::table($table);
echo $OUTPUT->footer();
