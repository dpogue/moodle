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
 * @package    block_newsletter
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
        return array('all' => true);
    }

    function get_content() {
        global $CFG, $DB, $OUTPUT;

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

        $output = '';

        if ($DB->get_manager()->table_exists('daily_news')) {
            $today = strtotime("today");

            $sql = 'SELECT * FROM {daily_news} WHERE datepublished = ?';
            $daily = $DB->get_record_sql($sql, array($today));

            if ($daily) {
                $output .= '<p>';

                $link = new moodle_url('/blocks/newsletter/daily.php', array('id' => $daily->id)); 
                $action = new popup_action('click', $link);
                $output .= $OUTPUT->action_link($link, get_string('readdaily', 'block_newsletter'), $action);

                $output .= '</p>';
            }
        }

        if ($DB->get_manager()->table_exists('newsletter')) {
            if (!empty($output)) {
                $output .= '<hr>';
            }

            $systemcontext = get_context_instance(CONTEXT_SYSTEM);
            $sql = 'SELECT * FROM {newsletter} ORDER BY datepublished DESC LIMIT 0, 1';
            $newsletter = $DB->get_record_sql($sql);

            if ($newsletter) {
                $fs = get_file_storage();
                $files = $fs->get_area_files($systemcontext->id, 'block_newsletter', 'letters', $newsletter->id, "itemid", false);
                if (count($files) < 1) {
                    continue;
                } else {
                    $file = reset($files);
                }

                $url = file_encode_url($CFG->wwwroot.'/pluginfile.php', '/'.$systemcontext->id.'/block_newsletter/letters/'.$newsletter->id.'/'.$file->get_filename());

                $output .= '<p>'.get_string('readlatest', 'block_newsletter', '<a href="'.$url.'">'.strftime('%B %Y', $newsletter->datepublished).'</a>').'</p>';
            } else {
                $output .= '<p>'.get_string('noletters', 'block_newsletter').'</p>';
            }
        }

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

        // We are going to measure execution times
        $starttime =  microtime();

        // And we have one initial $status
        $status = true;

        // And return $status
        return $status;
    }
}


