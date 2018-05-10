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
 * Language file.
 *
 * @package    theme_uogateen
 * @copyright  2016 Richard Oelmann
 * @copyright  theme_boost - MoodleHQ
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Theme strings.
$string['choosereadme'] = 'uogateen is a modern highly-customisable theme. It is built on to the new Moodle Boost theme, using Bootstrap4 and Mustache templates.';
$string['configtitle'] = 'uogateen';
$string['pluginname'] = 'uogateen';
$string['region-side-pre'] = 'Right';
$string['region-side-top'] = 'TopBar';
$string['region-side-sliderone'] = 'Course management';
$string['region-side-slidertwo'] = 'Block-Slider2';
$string['region-side-sliderthree'] = 'Block-Slider3';
$string['region-side-sliderfour'] = 'Block-Slider4';

$string['generalsettings'] = 'General settings';
$string['advancedsettings'] = 'Advanced settings';

// Edit buttons.
$string['editon'] = 'Turn Edit On';
$string['editoff'] = 'Turn Edit Off';

// Alerts.
$string['alert_settings'] = 'User alerts';
$string['alert_settingssub'] = 'Display important messages to your users on the front page';
$string['alertsdesc'] = 'This will display an alert (or multiple) in three different styles to your users on the Moodle frontpage. Please remember to disable these when no longer needed.';
$string['enablealert'] = 'Enable alert';
$string['enablealertdesc'] = 'Allows the message to be shown. Disabling this setting also allows the content of the alert to be left in place if it may be re-used, but not shown.';
$string['staffonlyalert'] = 'Staff Only';
$string['staffonlyalertdesc'] = 'Alert visible only to user with a whole site staff permission (code uses viewhiddencourses)';
$string['alert1'] = 'First alert';
$string['alert2'] = 'Second alert';
$string['alert3'] = 'Third alert';
$string['alertinfodesc'] = 'Enter the settings for your alert.';
$string['alerttitle'] = 'Title';
$string['alerttitledesc'] = 'Main title/heading for your alert.';
$string['alerttype'] = 'Level';
$string['alerttypedesc'] = 'Set the appropriate alert level/type to best inform your users, Information, Warning, Danger - these levels apply the relevant icon and theme colour to the alerts.';
$string['alerttext'] = 'Alert text';
$string['alerttextdesc'] = 'This is the main text of the alert. Alerts should be kept as short as possible, while maintaining the meaning, in order to ensure that users do read them.';
$string['alert_info'] = 'Information';
$string['alert_warning'] = 'Warning';
$string['alert_general'] = 'Announcement';

// Presets Settings.
$string['presets_settings'] = 'Presets';
$string['currentinparentheses'] = '(current)';
$string['presetfiles'] = 'Additional theme preset files';
$string['presetfiles_desc'] = 'Preset files can be used to dramatically alter the appearance of the theme.
    See https://docs.moodle.org/dev/uogateen_Presets for information on creating and sharing your own preset files.';
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Pick a preset to broadly change the look of the theme.';

// Colours Settings.
$string['colours_settings'] = 'Colours';
$string['brandcolor'] = 'Brand Color';
$string['brandcolor_desc'] = 'Your main brand colour';
$string['brandprimary'] = 'Brand Primary';
$string['brandprimary_desc'] = 'Your main brand colour';
$string['brandsuccess'] = 'Brand Success';
$string['brandsuccess_desc'] = 'Brand colour for succesful alerts, postive panels, buttons, etc';
$string['brandinfo'] = 'Brand info';
$string['brandinfo_desc'] = 'Brand colour information alerts and panels, etc';
$string['brandwarning'] = 'Brand Warning';
$string['brandwarning_desc'] = 'Brand colour for warning alerts and panels, etc';
$string['branddanger'] = 'Brand Danger';
$string['branddanger_desc'] = 'Brand colour for danger alerts and panels, etc';
$string['brandgray'] = 'Gray Base';
$string['brandgray_desc'] = 'Gray Base setting - This is the colour used to create gray shades. Default will be #000,
    but this can be adapted if there is a need to adjust contrast levels';

$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this field to provide SCSS code which will be injected at the end of the style sheet.';
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'In this field you can provide initialising SCSS code, it will be injected before everything else.
    Most of the time you will use this setting to define variables.';

// Header Settings.
$string['headingimagesettings'] = 'Heading and Course image settings';
$string['headerdefaultimage'] = 'Default header image';
$string['headerdefaultimage_desc'] = 'Default image for course headers and non-course pages';
$string['backgroundimage'] = 'Default page background image';
$string['backgroundimage_desc'] = 'Background image for pages';
$string['loginimage'] = 'Default Login image';
$string['loginimage_desc'] = 'Background image for login page';


// Social Networks.
$string['socialheading'] = 'Social Networking';
$string['socialheadingsub'] = 'Engage your users with social networking.';
$string['socialdesc'] = 'Provide direct links to the core social networks that promote your brand.  These will appear in the header of every page.';
$string['socialnetworks'] = 'Social Networks';
$string['facebook'] = 'Facebook URL';
$string['facebookdesc'] = 'Enter the URL of your Facebook page. (i.e http://www.facebook.com/pukunui)';
$string['twitter'] = 'Twitter URL';
$string['twitterdesc'] = 'Enter the URL of your Twitter feed. (i.e http://www.twitter.com/pukunui)';
$string['googleplus'] = 'Google+ URL';
$string['googleplusdesc'] = 'Enter the URL of your Google+ profile. (i.e https://google.com/+Pukunui/)';
$string['linkedin'] = 'LinkedIn URL';
$string['linkedindesc'] = 'Enter the URL of your LinkedIn profile. (i.e http://www.linkedin.com/company/pukunui-technology)';
$string['youtube'] = 'YouTube URL';
$string['youtubedesc'] = 'Enter the URL of your YouTube channel. (i.e http://www.youtube.com/moodleman)';
$string['tumblr'] = 'Tumblr URL';
$string['tumblrdesc'] = 'Enter the URL of your Tumblr. (i.e http://moodleman.tumblr.com)';
$string['vimeo'] = 'Vimeo URL';
$string['vimeodesc'] = 'Enter the URL of your Vimeo channel. (i.e http://vimeo.com/moodleman)';
$string['flickr'] = 'Flickr URL';
$string['flickrdesc'] = 'Enter the URL of your Flickr page. (i.e http://www.flickr.com/mycollege)';
$string['vk'] = 'VKontakte URL';
$string['vkdesc'] = 'Enter the URL of your Vkontakte page. (i.e http://www.vk.com/mycollege)';
$string['skype'] = 'Skype Account';
$string['skypedesc'] = 'Enter the Skype username of your organisations Skype account';
$string['pinterest'] = 'Pinterest URL';
$string['pinterestdesc'] = 'Enter the URL of your Pinterest page. (i.e http://pinterest.com/mycollege)';
$string['instagram'] = 'Instagram URL';
$string['instagramdesc'] = 'Enter the URL of your Instagram page. (i.e http://instagram.com/mycollege)';
$string['website'] = 'Website URL';
$string['websitedesc'] = 'Enter the URL of your own website. (i.e http://www.pukunui.com)';
$string['blog'] = 'Blog URL';
$string['blogdesc'] = 'Enter the URL of your institution blog. (i.e http://www.moodleman.net)';
$string['sociallink'] = 'Custom Social Link';
$string['sociallinkdesc'] = 'Enter the URL of your your custom social media link. (i.e http://www.moodleman.net)';
$string['sociallinkicon'] = 'Link Icon';
$string['sociallinkicondesc'] = 'Enter the fontawesome name of the icon for your link<br />A full list of FontAwesome icons can be found at http://fontawesome.io/icons/';

// Content settings.
$string['contentsettings'] = 'Content areas';
$string['footnote'] = 'Footnote.';
$string['footnotedesc'] = 'Footnote content editor for main footer';

// Links page settings.
$string['linkspage'] = 'Links Popup pages';
$string['linkspagesub'] = 'Custom links for staff and student pop up block pages';
$string['linkspagedesc'] = 'You can add upto 6 custom links for staff and for students.';
$string['stafflinks'] = 'Staff Links';
$string['stafflinksdesc'] = 'Add any (upto 6) manager/admin provided links for the Staff popup page.';
$string['studentlinks'] = 'Student Links';
$string['studentlinksdesc'] = 'Add any (upto 6) manager/admin provided links for the Student popup page.';
$string['stafflink'] = 'Staff link name';
$string['stafflinkdesc'] = '';
$string['stafflinkurl'] = 'Staff link url';
$string['stafflinkurldesc'] = '';
$string['stafflinkicon'] = 'Staff link FA icon name';
$string['stafflinkicondesc'] = '';
$string['studentlink'] = 'Student link name';
$string['studentlinkdesc'] = '';
$string['studentlinkurl'] = 'Student link url';
$string['studentlinkurldesc'] = '';
$string['studentlinkicon'] = 'Student link FA icon name';
$string['studentlinkicondesc'] = '';

// External Database settings.
$string['extdb_settings'] = 'External Database settings';
$string['extdbdesc'] = 'Settings page for links to external integrations database';

// Modal sliders.
$string['defaultmodaltitle'] = 'Side-Blocks page';
$string['defaultmodaltitledesc'] = 'These side-block pages can be used to add blocks off the main course page, but still easily available. Staff and Students also have a dedicated course details tab.';
$string['staffmodal'] = 'Staff course management';
$string['staffmodaldesc'] = 'Useful links and staff only blocks and content related to this course';
$string['studentmodal'] = 'Student course details';
$string['studentmodaldesc'] = 'Useful links and student only blocks and content related to this course';
// Group card titles.
$string['modalcoursesettings'] = 'Manage this course';
$string['modalusers'] = 'Manage course users';
$string['modalreports'] = 'Course reports';
$string['modalstaffotherlinks'] = 'Other links';
$string['modalstudentlinks'] = 'Course links';
// Course links.
$string['editcourse'] = 'Edit this course settings';
$string['resetcourse'] = 'Reset this course';
$string['coursebackup'] = 'Create course/item backup';
$string['courserestore'] = 'Restore an existing course/item backup';
$string['courseimport'] = 'Import content from another course';
$string['courserecyclebin'] = 'Recycle bin';
$string['courseadmin'] = 'Full course administration options';
// User links.
$string['manageusers'] = 'Enrolled users';
$string['manualenrol'] = 'Manually enrol new users';
$string['usergroups'] = 'Groups';
$string['enrolmentmethods'] = 'Enrolment Methods';
// Course logs.
$string['usergrades'] = 'Grading overview';
$string['logs'] = 'Full course logs';
$string['livelogs'] = 'Live course logs';
$string['participation'] = 'Participation report';
$string['activity'] = 'Activity report';
// Other links.
$string['otherlinks'] = 'Other links';
$string['recyclebin'] = 'Recycle Bin';
// Student modal page links.
$string['modalstudentlinks'] = 'Course links';
$string['courseinfo'] = 'Course information';
$string['coursestaff'] = 'Course Staff';

// Module guide.
$string['defaultsectiontitle'] = 'Topic';
$string['titlesnotdisplayed'] = 'Additional Information,Additional Info,Richard Test';
$string['modintrosection'] = 'Module Introduction';
$string['valtitle'] = 'Module Title';
$string['valmc'] = 'Module Code';
$string['valyear'] = 'Academic Year';
$string['valschool'] = 'School';
$string['vallevel'] = 'Level';
$string['valcat'] = 'CAT points';
$string['valpre'] = 'Pre-Requisites';
$string['valco'] = 'Co-Requisites';
$string['valrestrict'] = 'Restrictions';
$string['valdesc'] = 'Brief Description';
$string['valsyl'] = 'Indicative Syllabus';
$string['vallo'] = 'Learning Outcomes';
$string['vallt'] = 'Learning and Teaching Activities';
$string['valspecass'] = 'Special Assessment Requirements';
$string['valres'] = 'Module Resources';
$string['validatedsectiontitle'] = 'Module Descriptor';
$string['contentsectiontitle'] = 'Module Content Structure';
$string['valassessments'] = 'Module Assessment';
$string['modaddinfo'] = 'Additional Information';
$string['assignmentnotlinked'] = 'This assignment is not yet linked between SITS and Moodle.';
$string['stdduedate'] = 'Note - If this is an assignment, this is the standard due date. If you have an individual extension, that will be reflected on the assignment page itself.<br>If this is an exam, this date is the first day of Exam Week. The actual date of your exam will be publish through MyGlos around four weeks in advance.';

// External database connection strings.
$string['externaldbtype'] = 'mysqli';
$string['externaldbhost'] = 'localhost';
$string['externaldbname'] = 'integrations';
$string['externaldbencoding'] = 'utf-8';
$string['externaldbsetupsql'] = '';
$string['externaldbsybasequoting'] = '';
$string['externaldbdebugdb'] = '';
$string['externaldbuser'] = 'xxxxx';
$string['externaldbpassword'] = 'xxxxx';
$string['sourcetableassessments'] = 'usr_data_assessments';
$string['sourcetablevalidated'] = 'usr_guide_details';
$string['modulemappingtable'] = 'usr_modulesite_mapping';
