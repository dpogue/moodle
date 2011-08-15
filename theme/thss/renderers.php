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
 * The render implementation for the thss theme.
 *
 * @copyright 2010 Darryl Pogue
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since     Moodle 2.0
 */
class theme_thss_core_renderer extends core_renderer {

    /**
     * Get the DOCTYPE declaration that should be used with this page.
     * Designed to be called in theme layout.php files.
     *
     * @return string the DOCTYPE declaration (and any XML prologue) that
     *  should be used.
     */
    public function doctype() {
        global $CFG;

        $doctype = '<!DOCTYPE html>' . "\n";
        $this->contenttype = 'text/html; charset=UTF-8';

        return $doctype;
    }

    /**
     * The attributes that should be added to the <html> tag. Designed to
     * be called in theme layout.php files.
     * @return string HTML fragment.
     */
    public function htmlattributes() {
        $direction = '';
        if ($dir) {
            if (right_to_left()) {
                $direction = ' dir="rtl"';
            } else {
                $direction = ' dir="ltr"';
            }
        }
        //Accessibility: added the 'lang' attribute to $direction, used in theme <html> tag.
        $language = str_replace('_', '-', current_language());
        @header('Content-Language: '.$language);
        return ($direction.' lang="'.$language.'"');
    }

    /**
     * Renders a custom menu object (located in outputcomponents.php)
     *
     * @staticvar int $menucount
     * @param custom_menu $menu
     * @return string
     */
    protected function render_custom_menu(custom_menu $menu) {
        global $PAGE, $CFG;

        $content = array();

        /* Always include a home link */
        $is_index = $PAGE->url->compare(new moodle_url('/'), URL_MATCH_BASE);
        $home = html_writer::tag('span', 'Home');
        $home = html_writer::link($CFG->wwwroot, $home);
        $content[] = html_writer::tag('li', $home, array('class' => ($is_index ? 'selected' : '')));

        foreach ($menu->get_children() as $item) {
            $content[] = $this->render_custom_menu_item($item);
        }

        return html_writer::tag('ul', join('', $content), array('id' => 'tabbar'));
    }

    /**
     * Renders a custom menu node as part of a submenu
     *
     * @see render_custom_menu()
     *
     * @staticvar int $submenucount
     * @param custom_menu_item $menunode
     * @return string
     */
    protected function render_custom_menu_item(custom_menu_item $menunode) {
        if ($menunode->get_url() !== null) {
            $url = $menunode->get_url();
        } else {
            $url = '#';
        }
        $link = html_writer::tag('span', $menunode->get_text());

        $content  = html_writer::start_tag('li');
        $content .= html_writer::link($url, $link);
        if ($menunode->has_children()) {
            $content .= html_writer::start_tag('ul');
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode);
            }
            $content .= html_writer::end_tag('ul');
        }
        $content .= html_writer::end_tag('li');

        // Return the sub menu
        return $content;
    }
}
