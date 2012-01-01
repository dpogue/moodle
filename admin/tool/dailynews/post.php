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
require_once('dailynews_post_form.php');

require_login();
admin_externalpage_setup('tooldailynewspost');

$systemcontext = get_context_instance(CONTEXT_SYSTEM);
require_capability('tool/dailynews:add', $systemcontext);

// Create the form
$form = new dailynews_post_form();

// If we have valid input.
if ($data = $form->get_data()) {

    $data->content       = $data->news['text'];
    $data->contentformat = $data->news['format'];

    $data->id = $DB->insert_record('daily_news', $data);

    echo 'Success';
    die;
}

// Otherwise display the settings form.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('tooldailynewspost', 'tool_dailynews'));
$form->display();
echo $OUTPUT->footer();
