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
 * block_user_favorites
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package    block_user_favorites
 * @copyright 26-10-2018 MFreak.nl
 * @author    Luuk Verhoeven
 **/

use block_user_favorites\favorites;
use block_user_favorites\output\output_favorites;

defined('MOODLE_INTERNAL') || die;

/**
 * Class block_user_favorites
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  26-10-2018 MFreak.nl
 */
class block_user_favorites extends block_base {

    /**
     * Set the initial properties for the block
     *
     * @throws coding_exception
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_user_favorites');
    }

    /**
     * Are you going to allow multiple instances of each block?
     * If yes, then it is assumed that the block WILL USE per-instance configuration
     *
     * @return boolean
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Is each block of this type going to have instance-specific configuration?
     * Normally, this setting is controlled by {@link instance_allow_multiple()}: if multiple
     * instances are allowed, then each will surely need its own configuration. However, in some
     * cases it may be necessary to provide instance configuration to blocks that do not want to
     * allow multiple instances. In that case, make this function return true.
     * I stress again that this makes a difference ONLY if {@link instance_allow_multiple()} returns false.
     *
     * @return boolean
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Set the applicable formats for this block to all
     *
     * @return array
     */
    public function applicable_formats() {
        return ['all' => true];
    }

    /**
     * Specialization.
     *
     * Happens right after the initialisation is complete.
     *
     * @return void
     * @throws coding_exception
     */
    public function specialization() {
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_user_favorites');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * The content object.
     *
     * @return stdClass
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function get_content() {

        global $PAGE, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        if ((!isloggedin() || isguestuser() || !has_capability('block/user_favorites:view', $this->context))) {
            $this->content = new stdClass();
            $this->content->text = '';

            return $this->content;
        }

        $PAGE->requires->strings_for_js([
            'javascript:yes',
            'javascript:no',
            'javascript:set_title',
        ], 'block_user_favorites');

        $url = $PAGE->url->out(false);
        $PAGE->requires->js_call_amd('block_user_favorites/favorites', 'initialise', [
            [
                'debugjs' => \block_user_favorites\helper::has_debugging_enabled(),
                'id' => $this->instance->id,
                'url' => $url,
                'hash' => md5($url),
                // TODO We should add a global config with salt, this way we can make sure there is no bad guy.
            ],
        ]);

        $this->content = new stdClass();
        $favorites = new favorites($USER->id);
        $renderer = $PAGE->get_renderer('block_user_favorites');
        $this->content->text = $renderer->render_favorites(new output_favorites($favorites,
            $url));

        return $this->content;
    }
}

