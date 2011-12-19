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
//
function block_newsletter_pluginfile($course, $birecord_or_cm, $context, $filearea, $args, $forcedownload) {
    global $DB;

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    $postid = (int)array_shift($args);

    if (!$post = $DB->get_record('newsletter', array('id'=>$postid))) {
        return false;
    }

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/block_newsletter/$filearea/$postid/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }

    // finally send the file
    send_stored_file($file, 0, 0, true); // download MUST be forced - security!
}
