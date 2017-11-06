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

/* Social Network Settings */
$page = new admin_settingpage('theme_uogateen_social', get_string('socialheading', 'theme_uogateen'));
$page->add(new admin_setting_heading('theme_uogateen_social', get_string('socialheadingsub', 'theme_uogateen'),
        format_text(get_string('socialdesc' , 'theme_uogateen'), FORMAT_MARKDOWN)));

// Website url setting.
$name = 'theme_uogateen/website';
$title = get_string('website', 'theme_uogateen');
$description = get_string('websitedesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Blog url setting.
$name = 'theme_uogateen/blog';
$title = get_string('blog', 'theme_uogateen');
$description = get_string('blogdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Facebook url setting.
$name = 'theme_uogateen/facebook';
$title = get_string('facebook', 'theme_uogateen');
$description = get_string('facebookdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Flickr url setting.
$name = 'theme_uogateen/flickr';
$title = get_string('flickr', 'theme_uogateen');
$description = get_string('flickrdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Twitter url setting.
$name = 'theme_uogateen/twitter';
$title = get_string('twitter', 'theme_uogateen');
$description = get_string('twitterdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Google+ url setting.
$name = 'theme_uogateen/googleplus';
$title = get_string('googleplus', 'theme_uogateen');
$description = get_string('googleplusdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// LinkedIn url setting.
$name = 'theme_uogateen/linkedin';
$title = get_string('linkedin', 'theme_uogateen');
$description = get_string('linkedindesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Tumblr url setting.
$name = 'theme_uogateen/tumblr';
$title = get_string('tumblr', 'theme_uogateen');
$description = get_string('tumblrdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Pinterest url setting.
$name = 'theme_uogateen/pinterest';
$title = get_string('pinterest', 'theme_uogateen');
$description = get_string('pinterestdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Instagram url setting.
$name = 'theme_uogateen/instagram';
$title = get_string('instagram', 'theme_uogateen');
$description = get_string('instagramdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// YouTube url setting.
$name = 'theme_uogateen/youtube';
$title = get_string('youtube', 'theme_uogateen');
$description = get_string('youtubedesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Vimeo url setting.
$name = 'theme_uogateen/vimeo';
$title = get_string('vimeo', 'theme_uogateen');
$description = get_string('vimeodesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Skype url setting.
$name = 'theme_uogateen/skype';
$title = get_string('skype', 'theme_uogateen');
$description = get_string('skypedesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// General social url setting 1.
$name = 'theme_uogateen/social1';
$title = get_string('sociallink', 'theme_uogateen');
$description = get_string('sociallinkdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Social icon setting 1.
$name = 'theme_uogateen/socialicon1';
$title = get_string('sociallinkicon', 'theme_uogateen');
$description = get_string('sociallinkicondesc', 'theme_uogateen');
$default = 'home';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

// General social url setting 2.
$name = 'theme_uogateen/social2';
$title = get_string('sociallink', 'theme_uogateen');
$description = get_string('sociallinkdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Social icon setting 2.
$name = 'theme_uogateen/socialicon2';
$title = get_string('sociallinkicon', 'theme_uogateen');
$description = get_string('sociallinkicondesc', 'theme_uogateen');
$default = 'home';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

// General social url setting 3.
$name = 'theme_uogateen/social3';
$title = get_string('sociallink', 'theme_uogateen');
$description = get_string('sociallinkdesc', 'theme_uogateen');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Social icon setting 3.
$name = 'theme_uogateen/socialicon3';
$title = get_string('sociallinkicon', 'theme_uogateen');
$description = get_string('sociallinkicondesc', 'theme_uogateen');
$default = 'home';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
