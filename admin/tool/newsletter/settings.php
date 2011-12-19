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

defined('MOODLE_INTERNAL') || die;

$ADMIN->add('root', new admin_category('news', get_string('admincategory', 'tool_newsletter')));

if ($hassiteconfig) {
    $ADMIN->add('news', new admin_externalpage('toolnewsletterview', get_string('toolnewsletterview', 'tool_newsletter'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/newsletter/index.php'));
    $ADMIN->add('news', new admin_externalpage('toolnewsletterpost', get_string('toolnewsletterpost', 'tool_newsletter'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/newsletter/post.php'));
}
