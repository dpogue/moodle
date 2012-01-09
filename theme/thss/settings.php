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

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    // December Snow effect
    $name = 'theme_thss/snow';
    $title = get_string('snow', 'theme_thss');
    $description = get_string('snowdesc', 'theme_thss');
    $default = FALSE;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Google Analytics
    $name = 'theme_thss/ga';
    $title = get_string('ga','theme_thss');
    $description = get_string('gadesc', 'theme_thss');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $settings->add($setting);




    // link color setting
    $name = 'theme_thss/linkcolor';
    $title = get_string('linkcolor','theme_thss');
    $description = get_string('linkcolordesc', 'theme_thss');
    $default = '#0e53a7';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // link hover color setting
    $name = 'theme_thss/linkhover';
    $title = get_string('linkhover','theme_thss');
    $description = get_string('linkhoverdesc', 'theme_thss');
    $default = '#6899d3';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // main color setting
    $name = 'theme_thss/maincolor';
    $title = get_string('maincolor','theme_thss');
    $description = get_string('maincolordesc', 'theme_thss');
    $default = '#0e53a7';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // main color accent setting
    $name = 'theme_thss/maincoloraccent';
    $title = get_string('maincoloraccent','theme_thss');
    $description = get_string('maincoloraccentdesc', 'theme_thss');
    $default = '#4284d3';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // block color setting
    $name = 'theme_thss/blockcolor';
    $title = get_string('blockcolor','theme_thss');
    $description = get_string('blockcolordesc', 'theme_thss');
    $default = '#a68100';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // forum subject background color setting
    $name = 'theme_thss/forumback';
    $title = get_string('forumback','theme_thss');
    $description = get_string('forumbackdesc', 'theme_thss');
    $default = '#ffe073';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // forum subject font color setting
    $name = 'theme_thss/forumcolor';
    $title = get_string('forumcolor','theme_thss');
    $description = get_string('forumcolordesc', 'theme_thss');
    $default = '#04346c';
    $previewconfig = NULL;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

}
