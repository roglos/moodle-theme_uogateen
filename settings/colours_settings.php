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
 * Colours settings page file.
 *
 * @package    theme_uogateen
 * @copyright  2016 Richard Oelmann
 * @copyright  theme_boost - MoodleHQ
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$page = new admin_settingpage('theme_uogateen_colours', get_string('colours_settings', 'theme_uogateen'));

// Raw SCSS to include before the content.
$setting = new admin_setting_scsscode('theme_uogateen/scsspre',
    get_string('rawscsspre', 'theme_uogateen'), get_string('rawscsspre_desc', 'theme_uogateen'), '', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brandprimary.
$name = 'theme_uogateen/brandprimary';
$title = get_string('brandprimary', 'theme_uogateen');
$description = get_string('brandprimary_desc', 'theme_uogateen');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brandsuccess.
$name = 'theme_uogateen/brandsuccess';
$title = get_string('brandsuccess', 'theme_uogateen');
$description = get_string('brandsuccess_desc', 'theme_uogateen');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brandwarning.
$name = 'theme_uogateen/brandwarning';
$title = get_string('brandwarning', 'theme_uogateen');
$description = get_string('brandwarning_desc', 'theme_uogateen');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $branddanger.
$name = 'theme_uogateen/branddanger';
$title = get_string('branddanger', 'theme_uogateen');
$description = get_string('branddanger_desc', 'theme_uogateen');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brandinfo.
$name = 'theme_uogateen/brandinfo';
$title = get_string('brandinfo', 'theme_uogateen');
$description = get_string('brandinfo_desc', 'theme_uogateen');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $graybase.
$name = 'theme_uogateen/brandgraybase';
$title = get_string('brandgray', 'theme_uogateen');
$description = get_string('brandgray_desc', 'theme_uogateen');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// Raw SCSS to include after the content.
$setting = new admin_setting_scsscode('theme_uogateen/scss', get_string('rawscss', 'theme_uogateen'),
    get_string('rawscss_desc', 'theme_uogateen'), '', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
