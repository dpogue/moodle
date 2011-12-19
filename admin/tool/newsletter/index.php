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
 * @subpackage newsletter
 * @copyright  2011 Darryl Pogue
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
//require_once('locallib.php');
//require_once('database_transfer_form.php');

require_login();
admin_externalpage_setup('toolnewsletterview');

$systemcontext = get_context_instance(CONTEXT_SYSTEM);
require_capability('tool/news:viewall', $systemcontext);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('toolnewsletterview', 'tool_newsletter'));
//$form->display();
$sql = 'SELECT * FROM {newsletter} ORDER BY datepublished DESC';
$recs = $DB->get_records_sql($sql);

foreach ($recs as $letter) {
    $fs = get_file_storage();
    $files = $fs->get_area_files($systemcontext->id, 'block_newsletter', 'letters', $letter->id, "itemid", false);
    if (count($files) < 1) {
        continue;
    } else {
        $file = reset($files);
    }

    $url = file_encode_url($CFG->wwwroot.'/pluginfile.php', '/'.$systemcontext->id.'/block_newsletter/letters/'.$letter->id.'/'.$file->get_filename());

    echo '<a href="'.$url.'">';
    echo strftime('(%F) %B %e, %Y', $letter->datepublished);
    echo '</a><br>';
}
echo $OUTPUT->footer();
