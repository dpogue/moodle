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
 * Script to let a user add a newsletter.
 *
 * @package   newsletter_block
 * @copyright 2011 Darryl Pogue
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/filelib.php');

class newsletter_add_form extends moodleform {
    protected $title = '';
    protected $description = '';

    function definition() {
        $mform =& $this->_form;

        // Then show the fields about where this block appears.
        $mform->addElement('header', 'addnewsletterheader', get_string('addnewsletter', 'block_newsletter'));

        $filemanager_options = array();
        // 3 == FILE_EXTERNAL & FILE_INTERNAL
        // These two constant names are defined in repository/lib.php
        $filemanager_options['return_types'] = 3;
        $filemanager_options['accepted_types'] = '*';
        $filemanager_options['maxbytes'] = 0;
        $filemanager_options['maxfiles'] = 1;
        $filemanager_options['mainfile'] = true;

        $mform->addElement('filemanager', 'files', get_string('selectfiles'), null, $filemanager_options);

        $mform->addElement('text', 'preferredtitle', get_string('customtitlelabel', 'block_rss_client'), array('size' => 60));
        $mform->setType('preferredtitle', PARAM_NOTAGS);

        $this->add_action_buttons(true, get_string('postnewsletter', 'block_newsletter'));
    }

    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        $rss =  new moodle_simplepie();
        // set timeout for longer than normal to try and grab the feed
        $rss->set_timeout(10);
        $rss->set_feed_url($data['url']);
        $rss->set_autodiscovery_cache_duration(0);
        $rss->set_autodiscovery_level(SIMPLEPIE_LOCATOR_NONE);
        $rss->init();

        if ($rss->error()) {
            $errors['url'] = get_string('errorloadingfeed', 'block_rss_client', $rss->error());
        } else {
            $this->title = $rss->get_title();
            $this->description = $rss->get_description();
        }

        return $errors;
    }

    function get_data() {
        $data = parent::get_data();
        if ($data) {
            $data->title = '';
            $data->description = '';

            if($this->title){
                $data->title = $this->title;
            }

            if($this->description){
                $data->description = $this->description;
            }
        }
        return $data;
    }
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$courseid = optional_param('courseid', 0, PARAM_INTEGER);

if ($courseid == SITEID) {
    $courseid = 0;
}
if ($courseid) {
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $PAGE->set_course($course);
    $context = $PAGE->context;
} else {
    $context = get_context_instance(CONTEXT_SYSTEM);
    $PAGE->set_context($context);
}

$addnews = has_capability('block/newsletter:add_news', $context);
if (!$addnews) {
    require_capability('block/newsletter:add_news', $context);
}

$urlparams = array();
if ($courseid) {
    $urlparams['courseid'] = $courseid;
}
if ($returnurl) {
    $urlparams['returnurl'] = $returnurl;
}
$managefeeds = new moodle_url('/blocks/rss_client/managefeeds.php', $urlparams);

$PAGE->set_url('/blocks/newsletter/addnews.php', $urlparams);
$PAGE->set_pagelayout('base');

$isadding = true;

$mform = new newsletter_add_form($PAGE->url);

if ($mform->is_cancelled()) {
    redirect($managefeeds);

} else if ($data = $mform->get_data()) {
    $data->userid = $USER->id;
    if (!$addnews) {
        $data->shared = 0;
    }

    $DB->insert_record('newsletters', $data);

    redirect($managefeeds);

} else {
    $strtitle = get_string('addnews', 'block_newsletter');

    $PAGE->set_title($strtitle);
    $PAGE->set_heading($strtitle);

    $PAGE->navbar->add($strtitle);

    echo $OUTPUT->header();
    echo $OUTPUT->heading($strtitle, 2);

    $mform->display();

    echo $OUTPUT->footer();
}

