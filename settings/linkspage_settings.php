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
 * Links settings page file.
 *
 * @package    theme_uogateen
 * @copyright  2016 Richard Oelmann
 * @copyright  theme_boost - MoodleHQ
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/* Links popup Settings */
$page = new admin_settingpage('theme_uogateen_links', get_string('linkspage', 'theme_uogateen'));
$page->add(new admin_setting_heading('theme_uogateen_social', get_string('linkspagesub', 'theme_uogateen'),
        format_text(get_string('linkspagedesc' , 'theme_uogateen'), FORMAT_MARKDOWN)));

$name = 'theme_uogateen/staffsubheading';
$heading = get_string('stafflinks', 'theme_uogateen');
$information = get_string('stafflinksdesc', 'theme_uogateen');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);
for ($i = 1; $i <= 6; $i++) {

    // Staff Link - Name.
    $name = 'theme_uogateen/stafflink' . $i . 'name';
    $title = get_string('stafflink', 'theme_uogateen') . ' ' . $i;
    $description = get_string('stafflinkdesc', 'theme_uogateen');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Staff Link - URL.
    $name = 'theme_uogateen/stafflink' . $i . 'url';
    $title = get_string('stafflinkurl', 'theme_uogateen');
    $description = get_string('stafflinkurldesc', 'theme_uogateen');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $page->add($setting);

    // Staff Link - icon.
    $name = 'theme_uogateen/stafflink' . $i . 'icon';
    $title = get_string('stafflinkicon', 'theme_uogateen');
    $description = get_string('stafflinkicondesc', 'theme_uogateen');
    $default = 'globe';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $page->add($setting);
}

$name = 'theme_uogateen/studentsubheading';
$heading = get_string('studentlinks', 'theme_uogateen');
$information = get_string('studentlinksdesc', 'theme_uogateen');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);
for ($i = 1; $i <= 6; $i++) {

    // Student Link - Name.
    $name = 'theme_uogateen/studentlink' . $i . 'name';
    $title = get_string('studentlink', 'theme_uogateen');
    $description = get_string('studentlinkdesc', 'theme_uogateen');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Student Link - URL.
    $name = 'theme_uogateen/studentlink' . $i . 'url';
    $title = get_string('studentlinkurl', 'theme_uogateen');
    $description = get_string('studentlinkurldesc', 'theme_uogateen');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $page->add($setting);

    // Student Link - icon.
    $name = 'theme_uogateen/studentlink' . $i . 'icon';
    $title = get_string('studentlinkicon', 'theme_uogateen');
    $description = get_string('studentlinkicondesc', 'theme_uogateen');
    $default = 'globe';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $page->add($setting);
}


// Must add the page after definiting all the settings!
$settings->add($page);
