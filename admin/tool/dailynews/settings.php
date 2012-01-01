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

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->locate('news') == NULL) {
    $ADMIN->add('root', new admin_category('news', get_string('admincategory', 'tool_dailynews')));
}

if ($hassiteconfig) {
    $ADMIN->add('news', new admin_externalpage('tooldailynewsview', get_string('tooldailynewsview', 'tool_dailynews'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/dailynews/index.php'));
    $ADMIN->add('news', new admin_externalpage('tooldailynewspost', get_string('tooldailynewspost', 'tool_dailynews'), $CFG->wwwroot.'/'.$CFG->admin.'/tool/dailynews/post.php'));
}
