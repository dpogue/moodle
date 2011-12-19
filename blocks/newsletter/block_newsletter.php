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
 * A block which displays Remote feeds
 *
 * @package    newsletter
 * @copyright  2011 Darryl Pogue
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 */

 class block_newsletter extends block_base {

    function init() {
        $this->title = get_string('blocktitle', 'block_newsletter');
    }

    function preferred_width() {
        return 210;
    }

    function applicable_formats() {
        return array('all' => true);   // Needs work to make it work on tags MDL-11960
    }

    function get_content() {
        global $CFG, $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        // initalise block content object
        $this->content = new stdClass;
        $this->content->text   = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        /* ---------------------------------
         * Begin Normal Display of Block Content
         * --------------------------------- */

        $output = 'Hello World';

        $this->content->text = $output;

        return $this->content;
    }


    function instance_allow_multiple() {
        return false;
    }

    function has_config() {
        return true;
    }

    function instance_allow_config() {
        return true;
    }

    /**
     * cron - goes through all feeds and retrieves them with the cache
     * duration set to 0 in order to force the retrieval of the item and
     * refresh the cache
     *
     * @return boolean true if all feeds were retrieved succesfully
     */
    function cron() {
        global $CFG, $DB;
        require_once($CFG->libdir.'/simplepie/moodle_simplepie.php');

        // We are going to measure execution times
        $starttime =  microtime();

        // And we have one initial $status
        $status = true;

        // And return $status
        return $status;
    }
}


