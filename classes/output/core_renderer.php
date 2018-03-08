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
 * Core renderer.
 *
 * @package    theme_uogateen
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_uogateen\output;

use coding_exception;
use html_writer;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use single_select;
use paging_bar;
use url_select;
use context_course;
use pix_icon;
use progress;
use context_system;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_uogateen
 * @copyright  2012 Bas Brands, www.basbrands.nl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {

    /**
     * Wrapper for header elements.
     * Rewritten for uogateen to incorporate header images from Course Summary Files.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return string HTML to display the main header.
     */
    public function full_header() {

        global $CFG, $COURSE, $PAGE;

        // Get course overview files.
        if (empty($CFG->courseoverviewfileslimit)) {
            return array();
        }
        require_once($CFG->libdir. '/filestorage/file_storage.php');
        require_once($CFG->dirroot. '/course/lib.php');
        $fs = get_file_storage();
        $context = context_course::instance($COURSE->id);
        $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', false, 'filename', false);
        if (count($files)) {
            $overviewfilesoptions = course_overviewfiles_options($COURSE->id);
            $acceptedtypes = $overviewfilesoptions['accepted_types'];
            if ($acceptedtypes !== '*') {
                // Filter only files with allowed extensions.
                require_once($CFG->libdir. '/filelib.php');
                foreach ($files as $key => $file) {
                    if (!file_extension_in_typegroup($file->get_filename(), $acceptedtypes)) {
                        unset($files[$key]);
                    }
                }
            }
            if (count($files) > $CFG->courseoverviewfileslimit) {
                // Return no more than $CFG->courseoverviewfileslimit files.
                $files = array_slice($files, 0, $CFG->courseoverviewfileslimit, true);
            }
        }

        // Get course overview files as images - set $courseimage.
        // The loop means that the LAST stored image will be the one displayed if >1 image file.
        $courseimage = '';
        foreach ($files as $file) {
            $isimage = $file->is_valid_image();
            if ($isimage) {
                $courseimage = file_encode_url("$CFG->wwwroot/pluginfile.php",
                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                    $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            }
        }

        // Create html for header.
        $html = html_writer::start_tag('header', array('id' => 'page-header', 'class' => 'row'));
        $html .= html_writer::start_div('col-xs-12 p-a-1');
        $html .= html_writer::start_div('card');

        // If course image display it in separate div to allow css styling of inline style.
        if ($courseimage) {
            $html .= html_writer::start_div('withimage', array(
                'style' => 'background-image: url("'.$courseimage.'");background-size: 100% 100%;'));
        }

        $html .= html_writer::start_div('card-block');
        $html .= html_writer::div($this->context_header_settings_menu(), 'pull-xs-right context-header-settings-menu');
        $html .= html_writer::start_div('pull-xs-left');
        $html .= $this->context_header();
        $html .= html_writer::end_div();
        $pageheadingbutton = $this->page_heading_button();
        if (empty($PAGE->layout_options['nonavbar'])) {
            $html .= html_writer::start_div('clearfix w-100 pull-xs-left', array('id' => 'page-navbar'));
            $html .= html_writer::tag('div', $this->navbar(), array('class' => 'breadcrumb-nav'));
            $html .= html_writer::div($pageheadingbutton, 'breadcrumb-button pull-xs-right');
            $html .= html_writer::end_div();
        } else if ($pageheadingbutton) {
            $html .= html_writer::div($pageheadingbutton, 'breadcrumb-button nonavbar pull-xs-right');
        }
        $html .= html_writer::tag('div', $this->course_header(), array('id' => 'course-header'));
        $html .= html_writer::end_div(); // End card-block.

        if ($courseimage) {
            $html .= html_writer::end_div(); // End withimage inline style div.
        }

        $html .= html_writer::end_div(); // End card.
        $html .= html_writer::end_div(); // End col-xs-12 p-a-1.
        $html .= html_writer::end_tag('header');
        return $html;
    }

    /**
     * Context for social icons mustache template.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return renderer context for displaying social icons.
     */
    public function social_icons() {
        global $PAGE;

        $hasfacebook    = (empty($PAGE->theme->settings->facebook)) ? false : $PAGE->theme->settings->facebook;
        $hastwitter     = (empty($PAGE->theme->settings->twitter)) ? false : $PAGE->theme->settings->twitter;
        $hasgoogleplus  = (empty($PAGE->theme->settings->googleplus)) ? false : $PAGE->theme->settings->googleplus;
        $haslinkedin    = (empty($PAGE->theme->settings->linkedin)) ? false : $PAGE->theme->settings->linkedin;
        $hasyoutube     = (empty($PAGE->theme->settings->youtube)) ? false : $PAGE->theme->settings->youtube;
        $hasflickr      = (empty($PAGE->theme->settings->flickr)) ? false : $PAGE->theme->settings->flickr;
        $hasvk          = (empty($PAGE->theme->settings->vk)) ? false : $PAGE->theme->settings->vk;
        $haspinterest   = (empty($PAGE->theme->settings->pinterest)) ? false : $PAGE->theme->settings->pinterest;
        $hasinstagram   = (empty($PAGE->theme->settings->instagram)) ? false : $PAGE->theme->settings->instagram;
        $hasskype       = (empty($PAGE->theme->settings->skype)) ? false : $PAGE->theme->settings->skype;
        $haswebsite     = (empty($PAGE->theme->settings->website)) ? false : $PAGE->theme->settings->website;
        $hasblog        = (empty($PAGE->theme->settings->blog)) ? false : $PAGE->theme->settings->blog;
        $hasvimeo       = (empty($PAGE->theme->settings->vimeo)) ? false : $PAGE->theme->settings->vimeo;
        $hastumblr      = (empty($PAGE->theme->settings->tumblr)) ? false : $PAGE->theme->settings->tumblr;
        $hassocial1     = (empty($PAGE->theme->settings->social1)) ? false : $PAGE->theme->settings->social1;
        $social1icon    = (empty($PAGE->theme->settings->socialicon1)) ? 'globe' : $PAGE->theme->settings->socialicon1;
        $hassocial2     = (empty($PAGE->theme->settings->social2)) ? false : $PAGE->theme->settings->social2;
        $social2icon    = (empty($PAGE->theme->settings->socialicon2)) ? 'globe' : $PAGE->theme->settings->socialicon2;
        $hassocial3     = (empty($PAGE->theme->settings->social3)) ? false : $PAGE->theme->settings->social3;
        $social3icon    = (empty($PAGE->theme->settings->socialicon3)) ? 'globe' : $PAGE->theme->settings->socialicon3;

        $socialcontext = [

            // If any of the above social networks are true, sets this to true.
            'hassocialnetworks' => ($hasfacebook || $hastwitter || $hasgoogleplus || $hasflickr || $hasinstagram
                || $hasvk || $haslinkedin || $haspinterest || $hasskype || $haslinkedin || $haswebsite || $hasyoutube
                || $hasblog ||$hasvimeo || $hastumblr || $hassocial1 || $hassocial2 || $hassocial3) ? true : false,

            'socialicons' => array(
                array('haslink' => $hasfacebook, 'linkicon' => 'facebook'),
                array('haslink' => $hastwitter, 'linkicon' => 'twitter'),
                array('haslink' => $hasgoogleplus, 'linkicon' => 'google-plus'),
                array('haslink' => $haslinkedin, 'linkicon' => 'linkedin'),
                array('haslink' => $hasyoutube, 'linkicon' => 'youtube'),
                array('haslink' => $hasflickr, 'linkicon' => 'flickr'),
                array('haslink' => $hasvk, 'linkicon' => 'vk'),
                array('haslink' => $haspinterest, 'linkicon' => 'pinterest'),
                array('haslink' => $hasinstagram, 'linkicon' => 'instagram'),
                array('haslink' => $hasskype, 'linkicon' => 'skype'),
                array('haslink' => $haswebsite, 'linkicon' => 'globe'),
                array('haslink' => $hasblog, 'linkicon' => 'bookmark'),
                array('haslink' => $hasvimeo, 'linkicon' => 'vimeo-square'),
                array('haslink' => $hastumblr, 'linkicon' => 'tumblr'),
                array('haslink' => $hassocial1, 'linkicon' => $social1icon),
                array('haslink' => $hassocial2, 'linkicon' => $social2icon),
                array('haslink' => $hassocial3, 'linkicon' => $social3icon),
            )
        ];

        return $this->render_from_template('theme_uogateen/socialicons', $socialcontext);

    }

    /**
     * Context for user alerts mustache template.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return renderer context for displaying user alerts.
     */
    public function useralert() {
        global $PAGE;

        $alertinfo = '<span class="fa fa-2x fa-info"></span>';
        $alertwarning = '<span class="fa fa-2x fa-warning"></span>';
        $alertsuccess = '<span class="fa fa-2x fa-bullhorn"></span>';
        $context = context_system::instance();

        $enable1alert = (empty($PAGE->theme->settings->enable1alert)) ? false : $PAGE->theme->settings->enable1alert;
        $staffonly1alert = (empty($PAGE->theme->settings->staffonly1alert)) ? false : $PAGE->theme->settings->staffonly1alert;
        if ($staffonly1alert && !has_capability('moodle/course:viewhiddencourses', $context)) {
            $enable1alert = false;
        }
        $alert1type = (empty($PAGE->theme->settings->alert1type)) ? false : $PAGE->theme->settings->alert1type;
            $alert1icon = 'alert' . $alert1type;
            $alert1heading = (empty($PAGE->theme->settings->alert1title)) ? false : $PAGE->theme->settings->alert1title;
            $alert1text = (empty($PAGE->theme->settings->alert1text)) ? false : $PAGE->theme->settings->alert1text;
        $alert1content = '<div class="alertmessage">' . $$alert1icon . '<span class="title"> '
                . $alert1heading . '</span>  ' . $alert1text .'</div>';

        $enable2alert = (empty($PAGE->theme->settings->enable2alert)) ? false : $PAGE->theme->settings->enable2alert;
        $staffonly2alert = (empty($PAGE->theme->settings->staffonly2alert)) ? false : $PAGE->theme->settings->staffonly2alert;
        if ($staffonly2alert && !has_capability('moodle/course:viewhiddencourses', $context)) {
            $enable2alert = false;
        }
        $alert2type = (empty($PAGE->theme->settings->alert2type)) ? false : $PAGE->theme->settings->alert2type;
            $alert2icon = 'alert' . $alert2type;
            $alert2heading = (empty($PAGE->theme->settings->alert2title)) ? false : $PAGE->theme->settings->alert2title;
            $alert2text = (empty($PAGE->theme->settings->alert2text)) ? false : $PAGE->theme->settings->alert2text;
        $alert2content = '<div class="alertmessage">' . $$alert2icon . '<span class="title"> '
                . $alert2heading . '</span>  ' . $alert2text .'</div>';

        $enable3alert = (empty($PAGE->theme->settings->enable3alert)) ? false : $PAGE->theme->settings->enable3alert;
        $staffonly3alert = (empty($PAGE->theme->settings->staffonly3alert)) ? false : $PAGE->theme->settings->staffonly3alert;
        if ($staffonly3alert && !has_capability('moodle/course:viewhiddencourses', $context)) {
            $enable3alert = false;
        }
        $alert3type = (empty($PAGE->theme->settings->alert3type)) ? false : $PAGE->theme->settings->alert3type;
            $alert3icon = 'alert' . $alert3type;
            $alert3heading = (empty($PAGE->theme->settings->alert3title)) ? false : $PAGE->theme->settings->alert3title;
            $alert3text = (empty($PAGE->theme->settings->alert3text)) ? false : $PAGE->theme->settings->alert3text;
        $alert3content = '<div class="alertmessage">' . $$alert3icon . '<span class="title"> '
                . $alert3heading . '</span>  ' . $alert3text .'</div>';

        $useralertcontext = [
            'hasuseralert' => true,
            'useralert' => array(
                array(
                    'enablealert' => $enable1alert,
                    'alerttype' => $alert1type,
                    'alertcontent' => $alert1content,
                ),
                array(
                    'enablealert' => $enable2alert,
                    'alerttype' => $alert2type,
                    'alertcontent' => $alert2content,
                ),
                array(
                    'enablealert' => $enable3alert,
                    'alerttype' => $alert3type,
                    'alertcontent' => $alert3content,
                ),
            )
        ];

        return $this->render_from_template('theme_uogateen/useralert', $useralertcontext);

    }


    /**
     * Get setting for footnote content.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return html string to display footnote.
     */
    public function footnote() {
        global $PAGE;
        $footnote = '';

        $footnote    = (empty($PAGE->theme->settings->footnote)) ? false : $PAGE->theme->settings->footnote;

        return $footnote;
    }

    /**
     * Context for block modal popup buttons.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return renderer context for displaying modal popup buttons.
     */
    public function blockmodalbuttons() {
        global $OUTPUT, $PAGE, $COURSE;
        $blocksslider2html = $OUTPUT->blocksmodal('side-slidertwo');
        $blocksslider3html = $OUTPUT->blocksmodal('side-sliderthree');
        $blocksslider4html = $OUTPUT->blocksmodal('side-sliderfour');
        if (strlen($COURSE->idnumber) > 0 ){
            $hasslidertwoblocks = true;
        } else {
            $hasslidertwoblocks = false;
        }
        (strpos($COURSE->idnumber, 'CRS') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;
        (strpos($COURSE->idnumber, 'DOM') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;
        (strpos($COURSE->idnumber, 'SCH') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;
        (strpos($COURSE->idnumber, 'SUB') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;
        (strpos($COURSE->idnumber, 'HRCPD') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;
        (strpos($COURSE->idnumber, 'LTI') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;
        (strpos($COURSE->idnumber, 'ADU') === false)? $hasslidertwoblocks = $hasslidertwoblocks: $hasslidertwoblocks = false;

        $hassliderthreeblocks = strpos($blocksslider3html, 'data-block=') !== false;
        $hassliderfourblocks = strpos($blocksslider4html, 'data-block=') !== false;

        $buttonshtml = '';
        $buttonshtml .= '<div class="blockmodalbuttons">';
        if (strpos($PAGE->bodyclasses, 'pagelayout-course') > 0) {
            $buttonshtml .= '<button type="button" class="btn btn-warning pageblockbtn" data-toggle="modal"';
            $buttonshtml .= 'data-target="#slider1_blocksmodal"><i class="fa fa-2x fa-cog"></i></button>';

            if ($hasslidertwoblocks) {
                $buttonshtml .= '<button type="button" class="btn btn-danger pageblockbtn" data-toggle="modal"';
                $buttonshtml .= 'data-target="#slider2_blocksmodal"><i class="fa fa-2x fa-book"></i></i></button>';
            }
        }
        if ($hassliderthreeblocks) {
            $buttonshtml .= '<button type="button" class="btn btn-info pageblockbtn" data-toggle="modal"';
            $buttonshtml .= 'data-target="#slider3_blocksmodal"><i class="fa fa-2x fa-arrow-circle-left"></i></button>';
        }
        if ($hassliderfourblocks) {
            $buttonshtml .= '<button type="button" class="btn btn-success pageblockbtn" data-toggle="modal"';
            $buttonshtml .= 'data-target="#slider4_blocksmodal"><i class="fa fa-2x fa-arrow-circle-left"></i></button>';
        }
        $buttonshtml .= '</div>';

        return $buttonshtml;
    }

    /**
     * Context for blocks modal pop mustache template.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @param string $region The region to get HTML for.
     * @return renderer context for displaying blocks modal popup.
     */
    public function blocksmodal($region) {
        global $OUTPUT, $COURSE;
        $blocksmodalusersection = '';
        $blockscontent = $OUTPUT->blocks($region);

        $maintitle = get_string('defaultmodaltitle', 'theme_uogateen');
        $subtitle = get_string('defaultmodaltitledesc', 'theme_uogateen');

        if (isloggedin() && ISSET($COURSE->id) && $COURSE->id > 1) {
            $course = $this->page->course;
            $context = context_course::instance($course->id);

            if ($region == 'side-sliderone') {
                if (has_capability('moodle/course:viewhiddenactivities', $context)) {
                    $maintitle = get_string('staffmodal', 'theme_uogateen');
                    $subtitle = get_string('staffmodaldesc', 'theme_uogateen');
                    $blocksmodalusersection .= $OUTPUT->staffblocksmodal();

                } else {
                    $maintitle = get_string('studentmodal', 'theme_uogateen');
                    $subtitle = get_string('studentmodaldesc', 'theme_uogateen');
                    $blocksmodalusersection .= $OUTPUT->studentblocksmodal();
                }
            } else if ($region == 'side-slidertwo') {
                $maintitle = 'Module Guide';
                $subtitle = '';
                $blocksmodalusersection .= $OUTPUT->moduleguidemodal();
            }
        }

        $blocksmodalcontext = [
            'maintitle' => $maintitle,
            'subtitle' => $subtitle,
            'blocksmodalusersection' => $blocksmodalusersection,
            'blockscontent' => $blockscontent
        ];

        return $this->render_from_template('theme_uogateen/blocksmodal', $blocksmodalcontext);

    }

    /**
     * Context for staff user content on blocks modal popup mustache template.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return renderer context for staff user content.
     */
    public function staffblocksmodal() {
        global $PAGE, $DB, $COURSE, $CFG;
        if (ISSET($COURSE->id) && $COURSE->id > 1) {
            $hascoursegroup = array(
                'title' => get_string('modalcoursesettings', 'theme_uogateen'),
                'icon' => 'cogs'
            );
            $hasusersgroup = array(
                'title' => get_string('modalusers', 'theme_uogateen'),
                'icon' => 'users'
            );
            $hasreportsgroup = array(
                'title' => get_string('modalreports', 'theme_uogateen'),
                'icon' => 'id-card'
            );
            $hasothergroup = array(
                'title' => get_string('modalstaffotherlinks', 'theme_uogateen'),
                'icon' => 'external-link'
            );

            $coursegrouplinks = array(
                array(
                    'name' => get_string('editcourse', 'theme_uogateen'),
                    'url' => new moodle_url('/course/edit.php', array('id' => $PAGE->course->id)),
                    'icon' => 'edit'
                ),
                array(
                    'name' => get_string('resetcourse', 'theme_uogateen'),
                    'url' => new moodle_url('/course/reset.php', array('id' => $PAGE->course->id)),
                    'icon' => 'reply'
                ),
                array(
                    'name' => get_string('coursebackup', 'theme_uogateen'),
                    'url' => new moodle_url('/backup/backup.php', array('id' => $PAGE->course->id)),
                    'icon' => 'copy'
                ),
                array(
                    'name' => get_string('courserestore', 'theme_uogateen'),
                    'url' => new moodle_url('/backup/restorefile.php', array('contextid' => $PAGE->context->id)),
                    'icon' => 'clipboard'
                ),
                array(
                    'name' => get_string('courseimport', 'theme_uogateen'),
                    'url' => new moodle_url('/backup/import.php', array('id' => $PAGE->course->id)),
                    'icon' => 'clipboard'
                ),
                array(
                    'name' => get_string('courseadmin', 'theme_uogateen'),
                    'url' => new moodle_url('/course/admin.php', array('courseid' => $PAGE->course->id)),
                    'icon' => 'dashboard'
                ),
            );

            $enrol = $DB->get_record('enrol', array('courseid' => $COURSE->id, 'enrol' => 'manual'));
            $enrolinstance = $enrol->id;
            $courseid = $PAGE->course->id;
            if ($CFG->version > 2017092799 ) {
                 $newurl = new moodle_url('/user/index.php', array('id' => $courseid));
            } else {
                $newurl = new moodle_url('/enrol/users.php', array('id' => $courseid));
            }

            $usersgrouplinks = array(
                array(
                    'name' => get_string('manageusers', 'theme_uogateen'),
                    'url' => $newurl,
                    'icon' => 'address-book-o'
                ),
                array(
                    'name' => get_string('manualenrol', 'theme_uogateen'),
                    'url' => new moodle_url('/enrol/manual/manage.php',
                        array('enrolid' => $enrolinstance, 'id' => $courseid)),
                    'icon' => 'user-plus'
                ),
                array(
                    'name' => get_string('usergroups', 'theme_uogateen'),
                    'url' => new moodle_url('/group/index.php', array('id' => $courseid)),
                    'icon' => 'group'
                ),
                array(
                    'name' => get_string('enrolmentmethods', 'theme_uogateen'),
                    'url' => new moodle_url('/enrol/instances.php', array('id' => $courseid)),
                    'icon' => 'address-card-o'
                ),
            );
            $reportsgrouplinks = array(
                array(
                    'name' => get_string('usergrades', 'theme_uogateen'),
                    'url' => new moodle_url('/grade/report/grader/index.php', array('id' => $courseid)),
                    'icon' => 'bar-chart'
                ),
                array(
                    'name' => get_string('logs', 'theme_uogateen'),
                    'url' => new moodle_url('/report/log/index.php', array('id' => $courseid)),
                    'icon' => 'server'
                ),
                array(
                    'name' => get_string('livelogs', 'theme_uogateen'),
                    'url' => new moodle_url('/report/loglive/index.php', array('id' => $courseid)),
                    'icon' => 'tasks'
                ),
                array(
                    'name' => get_string('participation', 'theme_uogateen'),
                    'url' => new moodle_url('/report/participation/index.php', array('id' => $courseid)),
                    'icon' => 'street-view'
                ),
                array(
                    'name' => get_string('activity', 'theme_uogateen'),
                    'url' => new moodle_url('/report/outline/index.php', array('id' => $courseid)),
                    'icon' => 'user-circle-o'
                ),
            );

            $othergrouplinks = array(
                array(
                    'name' => get_string('recyclebin', 'theme_uogateen'),
                    'url' => new moodle_url('/admin/tool/recyclebin/index.php', array('contextid' => $PAGE->context->id)),
                    'icon' => 'trash-o'
                ),
            );
            for ($i = 1; $i <= 6; $i++) {
                if (strlen(theme_uogateen_get_setting('stafflink' . $i . 'name')) > 0) {
                    $othergrouplinks[] = array(
                            'name' => theme_uogateen_get_setting('stafflink' . $i . 'name'),
                            'url' => theme_uogateen_get_setting('stafflink' . $i . 'url'),
                            'icon' => theme_uogateen_get_setting('stafflink' . $i . 'icon')
                        );
                }
            }

            $staffmodalcontext = [
                'hascoursegroup' => $hascoursegroup,
                'coursegrouplinks' => $coursegrouplinks,
                'hasusersgroup' => $hasusersgroup,
                'usersgrouplinks' => $usersgrouplinks,
                'hasreportsgroup' => $hasreportsgroup,
                'reportsgrouplinks' => $reportsgrouplinks,
                'hasothergroup' => $hasothergroup,
                'othergrouplinks' => $othergrouplinks
            ];
            return $this->render_from_template('theme_uogateen/staffmodal', $staffmodalcontext);
        } else {
            return '';
        }
    }

    /**
     * Context for student user content on blocks modal popup mustache template.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return renderer context for displaying student user content.
     */
    public function studentblocksmodal() {
        global $PAGE, $DB, $CFG, $OUTPUT, $COURSE;
        require_once($CFG->dirroot.'/completion/classes/progress.php');

        if (ISSET($PAGE->course->id) && $PAGE->course->id > 1) {
            if (\core_completion\progress::get_course_progress_percentage($PAGE->course)) {
                $comppc = \core_completion\progress::get_course_progress_percentage($PAGE->course);
                $comppercent = number_format($comppc, 0);
                $hasprogress = true;
            } else {
                $comppercent = 0;
                $hasprogress = false;
            }
            $progresschartcontext = [
                'hasprogress' => $hasprogress,
                'progress' => $comppercent
            ];
            $progresschart = $this->render_from_template('block_myoverview/progress-chart', $progresschartcontext);
            $gradeslink = new moodle_url('/grade/report/user/index.php', array('id' => $PAGE->course->id));

            $stulinksgroup = array();
            for ($i = 1; $i <= 6; $i++) {
                if (strlen(theme_uogateen_get_setting('studentlink' . $i . 'name')) > 0) {
                    $stulinksgroup[] = array(
                            'name' => theme_uogateen_get_setting('studentlink' . $i . 'name'),
                            'url' => theme_uogateen_get_setting('studentlink' . $i . 'url'),
                            'icon' => theme_uogateen_get_setting('studentlink' . $i . 'icon')
                        );
                }
            }
            if (count($stulinksgroup) > 0 ) {
                $hasstulinksgroup = array(
                    'title' => get_string('modalstudentlinks', 'theme_uogateen'),
                    'icon' => 'link'
                );
            } else {
                $hasstulinksgroup = false;
            }

            $hascourseinfogroup = array (
                'title' => get_string('courseinfo', 'theme_uogateen'),
                'icon' => 'map'
            );
            $coursedescription = $COURSE->summary;
            $courseinfo = array (
                array(
                    'content' => $coursedescription,
                )
            );
            $hascoursestaff = array (
                'title' => get_string('coursestaff', 'theme_uogateen'),
                'icon' => 'users'
            );

            $courseteachers = array();
            $courseother = array();
            $role = $DB->get_record('role', array('shortname' => 'editingteacher'));
            $context = context_course::instance($PAGE->course->id);
            $teachers = get_role_users($role->id, $context, false,
                'u.id, u.firstname, u.middlename, u.lastname, u.alternatename,
                u.firstnamephonetic, u.lastnamephonetic, u.email, u.phone1, u.picture,
                u.imagealt, u.description');
            foreach ($teachers as $staff) {
                $picture = $OUTPUT->user_picture($staff, array('size' => 75));
                $courseteachers[] = array (
                    'name' => $staff->firstname . ' ' . $staff->lastname . ' ' . $staff->alternatename,
                    'email' => $staff->email,
                    'phone' => $staff->phone1,
                    'picture' => $picture,
                    'description' => $staff->description
                );
            }
            $role = $DB->get_record('role', array('shortname' => 'teacher'));
            $context = context_course::instance($PAGE->course->id);
            $teachers = get_role_users($role->id, $context, false,
                'u.id, u.firstname, u.middlename, u.lastname, u.alternatename,
                u.firstnamephonetic, u.lastnamephonetic, u.email, u.phone1, u.picture,
                u.imagealt, u.description');
            foreach ($teachers as $staff) {
                $picture = $OUTPUT->user_picture($staff, array('size' => 75));
                $courseother[] = array (
                    'name' => $staff->firstname . ' ' . $staff->lastname,
                    'email' => $staff->email,
                    'phone' => $staff->phone1,
                    'picture' => $picture
                );
            }

            $studentmodalcontext = [
                'progresschart' => $progresschart,
                'gradeslink' => $gradeslink,
                'hasstulinksgroup' => $hasstulinksgroup,
                'stulinksgroup' => $stulinksgroup,
                'hascourseinfogroup' => $hascourseinfogroup,
                'courseinfo' => $courseinfo,
                'hascoursestaffgroup' => $hascoursestaff,
                'courseteachers' => $courseteachers,
                'courseother' => $courseother,
            ];

            return $this->render_from_template('theme_uogateen/studentmodal', $studentmodalcontext);
        } else {
            return '';
        }
    }

    /**
     * OUTPUT for module guides - module contents.
     * @copyright 2018 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return html $content of module structure.
     */
    public function moduleguidestructure($cid) {
        global $DB, $COURSE;
        $course = $DB->get_record('course', array('id' => $cid));
        $courseformat = course_get_format($course);
        $mods = get_fast_modinfo($course);
        $numsections = course_get_format($course)->get_last_section_number();

        $sections = $mods->get_sections();

        $secinfo = array();
        $totsec = 0;
        foreach ($mods->get_section_info_all() as $section => $thissection) {
            $name = get_section_name($course, $thissection);
            $secinfo[$thissection->section]['id'] = $thissection->id;
            $secinfo[$thissection->section]['section'] = $thissection->section;
            if ($name !== '' || !is_null($name)) {
                $secinfo[$thissection->section]['title'] = $name;
            } else {
                $secinfo[$thissection->section]['title'] = get_string('defaultsectiontitle',
                    'theme_uogateen').' '.$thissection->section;
            }
            $secinfo[$thissection->section]['summary'] = $thissection->summary;
            $secinfo[$thissection->section]['visible'] = $thissection->visible;

            $totsec = $totsec + 1;
        }

        // Whitelist titles for sections not included in Mod Guide.
        $notshown = explode(',', get_string('titlesnotdisplayed', 'theme_uogateen'));

        $content = '';
        for ($i = 0; $i <= $numsections; $i++) {
            $name = $secinfo[$i]['title'];
            foreach ($notshown as $ns) {
                if (strpos($name, $ns) !== false) {
                    $secinfo[$i]['visible'] = 0;
                }
            }
            if ($secinfo[$i]['visible'] == 1) {
                $sectionurl = new moodle_url('/course/view.php', array('id' => $course->id, 'section' => $secinfo[$i]['section']));
                $id = $secinfo[$i]['section'];
                $title = $secinfo[$i]['title'];
                $summary = $secinfo[$i]['summary'];
                $content .= "<a href = '".$sectionurl."' alt = 'Section link - ".$title."' >";
                $content .= '<h4>'.$title.'</h4>';
                $content .= '</a>';
                $content .= $summary;
            }
        }

        return $content;
    }

    /**
     * OUTPUT for module guides - module contents.
     * @copyright 2018 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return html $content of module structure.
     */
    public function moduleguidevalidated() {
        global $DB, $COURSE;

        $externaldbtype = get_string('externaldbtype', 'theme_uogateen');
        $externaldbhost = get_string('externaldbhost', 'theme_uogateen');
        $externaldbname = get_string('externaldbname', 'theme_uogateen');
        $externaldbencoding = get_string('externaldbencoding', 'theme_uogateen');
        $externaldbsetupsql = get_string('externaldbsetupsql', 'theme_uogateen');
        $externaldbsybasequoting = get_string('externaldbsybasequoting', 'theme_uogateen');
        $externaldbdebugdb = get_string('externaldbdebugdb', 'theme_uogateen');
        $externaldbuser = get_string('externaldbuser', 'theme_uogateen');
        $externaldbpassword = get_string('externaldbpassword', 'theme_uogateen');
        $sourcetablevalidated = get_string('sourcetablevalidated', 'theme_uogateen');
        $sourcetablemapping = get_string('modulemappingtable', 'theme_uogateen');

        // Check connection and label Db/Table in cron output for debugging if required.
        if (!$externaldbtype) {
            echo 'Database not defined.<br>';
            return 0;
        }
        if (!$sourcetablevalidated) {
            echo 'Table not defined.<br>';
            return 0;
        }
        // Report connection error if occurs.
        if (!$extdb = $this->db_init($externaldbtype, $externaldbhost, $externaldbuser, $externaldbpassword, $externaldbname)) {
            echo 'Error while communicating with external database <br>';
            return 1;
        }
        // Get external table name.
        $course = $DB->get_record('course', array('id' => $COURSE->id));
        $assessments = array();
        $validated = array();
        if ($course->idnumber) {
            $sql = 'SELECT m.idnumber, v.objectid, v.objecttype, v.field, v.fieldname, v.value
                FROM ' . $sourcetablevalidated . ' v
                JOIN '. $sourcetablemapping .' m ON m.objectid = v.objectid
                WHERE m.idnumber LIKE "%' . $course->idnumber . '%"';
            if ($rs = $extdb->Execute($sql)) {
                if (!$rs->EOF) {
                    while ($val = $rs->FetchRow()) {
                        $val = array_change_key_case($val, CASE_LOWER);
                        $val = $this->db_decode($val);
                        $validated[] = $val;
                    }
                }
                $rs->Close();
            } else {
                // Report error if required.
                $extdb->Close();
                echo 'Error reading data from the external course tables<br>';
                return 4;
            }
        }
        if (count($validated) <= 0) {
            return '';
        }
        foreach ($validated as $k => $v) {
            $id = explode('_', $validated[$k]['idnumber']);
            $n = count($id);
            $validated[$k]['mc'] = $id[0];
            $validated[$k]['yr'] = $id[$n - 1];
        }
        $valdet = array();
        foreach ($validated as $k => $v) {
            $valdet[$validated[$k]['idnumber']]['idnumber'] = $validated[$k]['idnumber'];
            $valdet[$validated[$k]['idnumber']]['yr'] = $validated[$k]['yr'];
            $valdet[$validated[$k]['idnumber']]['mc'] = $validated[$k]['mc'];
            $valdet[$validated[$k]['idnumber']][$validated[$k]['field']] = $validated[$k]['value'];
            if (substr($valdet[$validated[$k]['idnumber']][$validated[$k]['field']], 0, 3) == '<p>') {
                ltrim($valdet[$validated[$k]['idnumber']][$validated[$k]['field']], '<p>');
                rtrim($valdet[$validated[$k]['idnumber']][$validated[$k]['field']], '</p>');
            }
        }
        return $valdet;
    }
    /**
     * OUTPUT for module guides - module contents.
     * @copyright 2018 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return html $content of module structure.
     */
    public function moduleguideassesments() {
        global $DB, $COURSE;

        $externaldbtype = get_string('externaldbtype', 'theme_uogateen');
        $externaldbhost = get_string('externaldbhost', 'theme_uogateen');
        $externaldbname = get_string('externaldbname', 'theme_uogateen');
        $externaldbencoding = get_string('externaldbencoding', 'theme_uogateen');
        $externaldbsetupsql = get_string('externaldbsetupsql', 'theme_uogateen');
        $externaldbsybasequoting = get_string('externaldbsybasequoting', 'theme_uogateen');
        $externaldbdebugdb = get_string('externaldbdebugdb', 'theme_uogateen');
        $externaldbuser = get_string('externaldbuser', 'theme_uogateen');
        $externaldbpassword = get_string('externaldbpassword', 'theme_uogateen');
        $sourcetableassessments = get_string('sourcetableassessments', 'theme_uogateen');

        // Check connection and label Db/Table in cron output for debugging if required.
        if (!$externaldbtype) {
            echo 'Database not defined.<br>';
            return 0;
        }
        if (!$sourcetableassessments) {
            echo 'Table not defined.<br>';
            return 0;
        }
        // Report connection error if occurs.
        if (!$extdb = $this->db_init($externaldbtype, $externaldbhost, $externaldbuser, $externaldbpassword, $externaldbname)) {
            echo 'Error while communicating with external database <br>';
            return 1;
        }
        // Get external table name.
        $course = $DB->get_record('course', array('id' => $COURSE->id));
        $assessments = array();
        if ($course->idnumber) {
            $sql = 'SELECT * FROM ' . $sourcetableassessments . ' WHERE mav_idnumber LIKE "%' . $course->idnumber . '%"';
            if ($rs = $extdb->Execute($sql)) {
                if (!$rs->EOF) {
                    while ($assess = $rs->FetchRow()) {
                        $assess = array_change_key_case($assess, CASE_LOWER);
                        $assess = $this->db_decode($assess);
                        $assessments[] = $assess;
                    }
                }
                $rs->Close();
            } else {
                // Report error if required.
                $extdb->Close();
                echo 'Error reading data from the external course table<br>';
                return 4;
            }
        }
        $output = '';
        if (count($assessments) == 0 ) {
            $output .= 'There are no assessments currently recorded for this module instance.';
        }
        $output .= '<div class="assesslist">';
        foreach ($assessments as $a) {
            $idcode = $a['assessment_idcode'];
            $where = "m.idnumber = '".$idcode."' AND m.idnumber != '' AND mo.name = 'assign'";
            $sql = 'SELECT a.id as id,m.id as cm, m.idnumber as
                linkcode,a.duedate,a.gradingduedate, a.name as name, a.intro as brief FROM {course_modules} m
                    JOIN {assign} a ON m.instance = a.id
                    JOIN {modules} mo ON m.module = mo.id
                WHERE '.$where;
            $mdlassess = $DB->get_record_sql($sql);
            $size = $title = $a['assessment_name'];
            $brief = $duedate = '';
            if (isset($mdlassess->name) && strlen($mdlassess->name) > 0 ) {
                $title = $mdlassess->name;
            }
            if (isset ($mdlassess->brief) && strlen($mdlassess->brief) > 0 ) {
                $brief = $mdlassess->brief;
            } else {
                $brief = '<span class="text-danger">'.get_string('assignmentnotlinked',
                    'theme_uogateen').'</span>';
            }
            if (isset ($mdlassess->duedate) && $mdlassess->duedate > 0 ) {
                $duedate = date('Y-m-d H:m', $mdlassess->duedate);
            }
            if (isset($mdlassess->cm)) {
                $url = new moodle_url('/mod/assign/view.php', array('id' => $mdlassess->cm));
            } else {
                $url = '#';
            }
            $output .= '<div class="assess card card-default bg-light" style="background:#f2f2f2;">';
            $output .= '<h4><a href = '.$url.'>'.$title.'</a></h4>';
            $output .= '<h5>Due Date:  '.$duedate.'</h5>';
            $output .= '<p><span class="small">'.get_string('stdduedate', 'theme_uogateen').'</span></p>';
            $output .= '<p><strong>Number: </strong>'.$a['assessment_number'].
                '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Weighting: </strong>'.
                $a['assessment_weight'].'%<br />';
            $output .= '<strong>Type: </strong>'.$a['assessment_type'].'<br />';
            $output .= '<strong>Requirement: </strong>'.$size.'<br />';
            $output .= $brief;
            $output .= '</div>';
        }
        $output .= '<h4>Feedback</h4>';
        $output .= '<p>You will receive a mark and feedback for each piece of coursework. If there is anything that you do not understand about the feedback, please make an appointment to discuss with the Module Tutor. Your assignments and feedback will also be available to your personal tutor, who as part of the meeting each semester will check your understanding of feedback, and help you identify areas and strategies for improvement.</p>';
        $output .= '<div class=" bg-warning assesslinks">';
        $output .= '<h4>Useful Links</h4>';
        $output .= '<a href="#" alt="Academic Regulations">Academic Regulations</a>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Context for Module Guide content on blocks modal popup mustache template.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return renderer context for displaying student user content.
     */
    public function moduleguidemodal() {
        global $PAGE, $DB, $CFG, $OUTPUT, $COURSE;
        $modintro = $modaddinfo = $modresource = '';
        // TODO: Check if module guide info exists.
        if (ISSET($PAGE->course->id) && $PAGE->course->id > 1) {
            $modulecode = substr($PAGE->course->idnumber, 0, 6);
            $moduleinsttitle = $PAGE->course->fullname;
            $modulelink = $PAGE->course->idnumber;
            if ($DB->record_exists('block_modguideform', array('modulecode' => $modulecode))) {
                $modguideinfo = $DB->get_record('block_modguideform', array('modulecode' => $modulecode));
                if ($modguideinfo->modintro) {
                    $modintro = clean_text($modguideinfo->modintro);
                }
                if ($modguideinfo->modaddinfo) {
                    $modaddinfo = $modguideinfo->modaddinfo;
                }
                if ($modguideinfo->modreslist) {
                    $modresource = clean_text($modguideinfo->modreslist);
                }
            }
            $modval = $OUTPUT->moduleguidevalidated();
            $year = $school = $credit = $level = $prereq = $coreq = $restrict = '';
            $desc = $indsyll = $outcome = $learnteach = $specassess = $indres = '';
            if (isset($modval[$modulelink]['yr'])) {
                $year = $modval[$modulelink]['yr'];
            }
            if (isset($modval[$modulelink]['SCHOOL'])) {
                $school = $modval[$modulelink]['SCHOOL'];
            }
            if (isset($modval[$modulelink]['CREDIT'])) {
                $credit = $modval[$modulelink]['CREDIT'];
            }
            if (isset($modval[$modulelink]['LEVEL'])) {
                $level = $modval[$modulelink]['LEVEL'];
            }
            if (isset($modval[$modulelink]['PREREQ'])) {
                $prereq = $modval[$modulelink]['PREREQ'];
            }
            if (isset($modval[$modulelink]['COREQ'])) {
                $coreq = $modval[$modulelink]['COREQ'];
            }
            if (isset($modval[$modulelink]['RESTRICT'])) {
                $restrict = $modval[$modulelink]['RESTRICT'];
            }
            if (isset($modval[$modulelink]['DESC'])) {
                $desc = $modval[$modulelink]['DESC'];
            }
            if (isset($modval[$modulelink]['INDSYLL'])) {
                $indsyll = $modval[$modulelink]['INDSYLL'];
            }
            if (isset($modval[$modulelink]['OUTCOME'])) {
                $outcome = $modval[$modulelink]['OUTCOME'];
            }
            if (isset($modval[$modulelink]['LEARNTEACH'])) {
                $learnteach = $modval[$modulelink]['LEARNTEACH'];
            }
            if (isset($modval[$modulelink]['SPECASSESS'])) {
                $specassess = $modval[$modulelink]['SPECASSESS'];
            }
            if (isset($modval[$modulelink]['INDRES'])) {
                $indres = $modval[$modulelink]['INDRES'];
            }

            $moduleguidemodalcontext = [
                'modulecode' => $modulecode,
                'moduletitle' => $moduleinsttitle,
                'modintro' => $modintro,
                'modval_year' => $year,
                'modval_school' => $school,
                'modval_catpoints' => $credit,
                'modval_level' => $level,
                'modval_prerequ' => $prereq,
                'modval_corequ' => $coreq,
                'modval_restrictions' => $restrict,
                'modval_desc' => $desc,
                'modval_syll' => $indsyll,
                'modval_lo' => $outcome,
                'modval_activities' => $learnteach,
                'modval_assessments' => '',
                'modval_specass' => $specassess,
                'modval_resources' => $indres,
                'modstructure' => $OUTPUT->moduleguidestructure($PAGE->course->id),
                'modaddinfo' => $modaddinfo,
                'modassessments' => $OUTPUT->moduleguideassesments(),
                'modresource' => $modresource,
                'modstructurecontent' => $OUTPUT->moduleguidestructure($PAGE->course->id),
                'modtimetableurl' => "https://glos.mydaycloud.com/app/collabco.calendar",
            ];

            return $this->render_from_template('theme_uogateen/moduleguidemodal', $moduleguidemodalcontext);
        } else {
            return '';
        }
    }


    /**
     * Render Editing link as a bootstrap style button with fontawesome icon.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @param moodle_url $url
     * @return $output.
     */
    public function edit_button(moodle_url $url) {
        $url->param('sesskey', sesskey());
        if ($this->page->user_is_editing()) {
            $url->param('edit', 'off');
            $btn = 'btn-danger';
            $title = get_string('editoff' , 'theme_uogateen');
            $icon = 'fa-power-off';
        } else {
            $url->param('edit', 'on');
            $btn = 'btn-success';
            $title = get_string('editon' , 'theme_uogateen');
            $icon = 'fa-edit';
        }
        return html_writer::tag('a', html_writer::start_tag('i', array('class' => $icon . ' fa fa-fw')) .
            html_writer::end_tag('i') . $title, array('href' => $url, 'class' => 'btn  ' . $btn, 'title' => $title));
    }

    /**
     * Function to find course image for use in header and in course overview.
     * @copyright 2017 theme_uogateen Richard Oelmann https://moodle.org/user/profile.php?id=480148
     * @package    theme_uogateen
     *
     * @return image.
     */
    public function get_course_image () {
        global $CFG;
        if (empty($CFG->courseoverviewfileslimit)) {
            return array();
        }
        require_once($CFG->libdir. '/filestorage/file_storage.php');
        require_once($CFG->dirroot. '/course/lib.php');

        $courses = get_courses();
        $crsimagescss = '';

        foreach ($courses as $c) {

            // Get course overview files.
            $fs = get_file_storage();
            $context = context_course::instance($c->id);
            $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', false, 'filename', false);
            if (count($files)) {
                $overviewfilesoptions = course_overviewfiles_options($c->id);
                $acceptedtypes = $overviewfilesoptions['accepted_types'];
                if ($acceptedtypes !== '*') {
                    // Filter only files with allowed extensions.
                    require_once($CFG->libdir. '/filelib.php');
                    foreach ($files as $key => $file) {
                        if (!file_extension_in_typegroup($file->get_filename(), $acceptedtypes)) {
                            unset($files[$key]);
                        }
                    }
                }
                if (count($files) > $CFG->courseoverviewfileslimit) {
                    // Return no more than $CFG->courseoverviewfileslimit files.
                    $files = array_slice($files, 0, $CFG->courseoverviewfileslimit, true);
                }
            }

            // Get course overview files as images - set $courseimage.
            // The loop means that the LAST stored image will be the one displayed if >1 image file.
            $courseimage = '';
            foreach ($files as $file) {
                $isimage = $file->is_valid_image();
                if ($isimage) {
                    $courseimage = file_encode_url("$CFG->wwwroot/pluginfile.php",
                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                        $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
                }
            }

            $crsid = '#course-events-container-' . $c->id . ', .courses-view-course-item #course-info-container-' . $c->id;
            $crsimagescss .= $crsid . ' {background-image: url("' . $courseimage . '");
                background-size: 100% 100%; background-color:red;}';
        }

        return $crsimagescss;

    }


    /* Db functions cloned from enrol/db plugin.
     * ========================================= */
    /**
     * Tries to make connection to the external database.
     *
     * @return null|ADONewConnection
     */
    public function db_init($externaldbtype, $externaldbhost, $externaldbuser,
        $externaldbpassword, $externaldbname, $externaldbdebugdb=false, $externaldbsetupsql='') {
        global $CFG;
        require_once($CFG->libdir.'/adodb/adodb.inc.php');
        // Connect to the external database (forcing new connection).
        $extdb = ADONewConnection($externaldbtype);
        if ($externaldbdebugdb) {
            $extdb->debug = true;
            ob_start(); // Start output buffer to allow later use of the page headers.
        }
        // The dbtype my contain the new connection URL, so make sure we are not connected yet.
        if (!$extdb->IsConnected()) {
            $result = $extdb->Connect($externaldbhost,
                $externaldbuser,
                $externaldbpassword,
                $externaldbname, true);
            if (!$result) {
                return null;
            }
        }
        $extdb->SetFetchMode(ADODB_FETCH_ASSOC);
        if ($externaldbsetupsql) {
            $extdb->Execute($externaldbsetupsql);
        }
        return $extdb;
    }
    public function db_encode($externaldbencoding, $text) {
        $dbenc = $externaldbencoding;
        if (empty($dbenc) or $dbenc == 'utf-8') {
            return $text;
        }
        if (is_array($text)) {
            foreach ($text as $k => $value) {
                $text[$k] = $this->db_encode($value);
            }
            return $text;
        } else {
            return core_text::convert($text, 'utf-8', $dbenc);
        }
    }
    public function db_get_sql($table, array $conditions, array $fields, $distinct = false, $sort = "") {
        $fields = $fields ? implode(',', $fields) : "*";
        $where = array();
        if ($conditions) {
            foreach ($conditions as $key => $value) {
                $value = $this->db_encode($this->db_addslashes($value));

                $where[] = "$key = '$value'";
            }
        }
        $where = $where ? "WHERE ".implode(" AND ", $where) : "";
        $sort = $sort ? "ORDER BY $sort" : "";
        $distinct = $distinct ? "DISTINCT" : "";
        $sql = "SELECT $distinct $fields
                  FROM $table
                 $where
                  $sort";
        return $sql;
    }
    /**
     * Returns plugin config value
     * @param  string $name
     * @param  string $default value if config does not exist yet
     * @return string value or default
     */
    public function get_config($name, $default = null) {
        $this->load_config();
        return isset($this->config->$name) ? $this->config->$name : $default;
    }

    /**
     * Sets plugin config value
     * @param  string $name name of config
     * @param  string $value string config value, null means delete
     * @return string value
     */
    public function set_config($name, $value) {
        $pluginname = $this->get_name();
        $this->load_config();
        if ($value === null) {
            unset($this->config->$name);
        } else {
            $this->config->$name = $value;
        }
        set_config($name, $value, "local_$pluginname");
    }

    /**
     * Makes sure config is loaded and cached.
     * @return void
     */
    public function load_config() {
        if (!isset($this->config)) {
            $name = $this->get_name();
            $this->config = get_config("local_$name");
        }
    }

    public function db_get_sql_like($table2, array $conditions, array $fields, $distinct = false, $sort = "") {
        $fields = $fields ? implode(',', $fields) : "*";
        $where = array();
        if ($conditions) {
            foreach ($conditions as $key => $value) {
                $value = $this->db_encode($this->db_addslashes($value));

                $where[] = "$key LIKE '%$value%'";
            }
        }
        $where = $where ? "WHERE ".implode(" AND ", $where) : "";
        $sort = $sort ? "ORDER BY $sort" : "";
        $distinct = $distinct ? "DISTINCT" : "";
        $sql2 = "SELECT $distinct $fields
                  FROM $table2
                 $where
                  $sort";
        return $sql2;
    }

    public function db_decode($text) {
        $externaldbencoding = get_string('externaldbencoding', 'theme_uogateen');

        $dbenc = $externaldbencoding;
        if (empty($dbenc) or $dbenc == 'utf-8') {
            return $text;
        }
        if (is_array($text)) {
            foreach ($text as $k => $value) {
                $text[$k] = $this->db_decode($value);
            }
            return $text;
        } else {
            return core_text::convert($text, $dbenc, 'utf-8');
        }
    }

    public function db_addslashes($externaldbsybasequoting, $text) {
        // Use custom made function for now - it is better to not rely on adodb or php defaults.
        if ($externaldbsybasequoting) {
            $text = str_replace('\\', '\\\\', $text);
            $text = str_replace(array('\'', '"', "\0"), array('\\\'', '\\"', '\\0'), $text);
        } else {
            $text = str_replace("'", "''", $text);
        }
    }
}
