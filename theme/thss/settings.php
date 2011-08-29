<?php

// Create our admin page
$temp = new admin_settingpage('theme_thss', get_string('configtitle','theme_thss'));

// link color setting
$name = 'theme_thss/linkcolor';
$title = get_string('linkcolor','theme_thss');
$description = get_string('linkcolordesc', 'theme_thss');
$default = '#0e53a7';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// link hover color setting
$name = 'theme_thss/linkhover';
$title = get_string('linkhover','theme_thss');
$description = get_string('linkhoverdesc', 'theme_thss');
$default = '#6899d3';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// main color setting
$name = 'theme_thss/maincolor';
$title = get_string('maincolor','theme_thss');
$description = get_string('maincolordesc', 'theme_thss');
$default = '#0e53a7';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// main color accent setting
$name = 'theme_thss/maincoloraccent';
$title = get_string('maincoloraccent','theme_thss');
$description = get_string('maincoloraccentdesc', 'theme_thss');
$default = '#4284d3';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// block color setting
$name = 'theme_thss/blockcolor';
$title = get_string('blockcolor','theme_thss');
$description = get_string('blockcolordesc', 'theme_thss');
$default = '#a68100';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// forum subject background color setting
$name = 'theme_thss/forumback';
$title = get_string('forumback','theme_thss');
$description = get_string('forumbackdesc', 'theme_thss');
$default = '#ffe073';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// forum subject font color setting
$name = 'theme_thss/forumcolor';
$title = get_string('forumcolor','theme_thss');
$description = get_string('forumcolordesc', 'theme_thss');
$default = '#04346c';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$temp->add($setting);

// Add our page to the structure of the admin tree
$ADMIN->add('themes', $temp);
