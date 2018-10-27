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
 * Adding a new favorites plugin
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-block-user_favorites
 * @copyright 26-10-2018 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

namespace block_user_favorites;
defined('MOODLE_INTERNAL') || die;

class favorites {

    /**
     * Set of favorites
     *
     * @var array|mixed
     */
    protected $favorites = [];

    /**
     * @var int
     */
    protected $userid;

    /**
     * favorites constructor.
     *
     * @param int $userid
     *
     * @throws \coding_exception
     */
    public function __construct(int $userid = 0) {
        global $USER;
        if (empty($userid)) {
            $userid = $USER->id;
        }

        $favorites = get_user_preferences('user_favorites', false, $userid);

        if ($favorites) {
            $this->favorites = @unserialize($favorites) ?? [];
        }

        $this->userid = $userid;
    }

    /**
     * Set a url
     * This function will update if exists or create a new favorite.
     *
     * @param string $url
     * @param string $title
     * @param int    $sort
     *
     * @throws \coding_exception
     */
    public function set_by_url(string $url, string $title = '', int $sort = 0) {

        $hash = md5($url);

        // Check if url in the array.
        $this->favorites[$hash] = (object)[
            'url' => $url,
            'title' => $title,
            'sortorder' => $sort,
            'hash' => $hash,
        ];

        set_user_preference('user_favorites', serialize($this->favorites));
    }

    /**
     * Delete by hash.
     *
     * @param string $hash
     *
     * @throws \coding_exception
     */
    public function delete_by_hash(string $hash) {
        unset($this->favorites[$hash]);

        set_user_preference('user_favorites', serialize($this->favorites));
    }

    /**
     * @return array|mixed
     */
    public function get_all() {
        // @TODO maybe ordering on sortorder.
        return $this->favorites;
    }

    /**
     * Check if it has favorites.
     *
     * @return bool
     */
    public function has_favorites() : bool {
        return !empty($this->favorites);
    }

    /**
     * Get favorites
     *
     * @param string $hash
     *
     * @return bool|mixed
     */
    public function get(string $hash = '') {
        return $this->favorites[$hash] ?? false;
    }

    /**
     * Update title.
     *
     * @param string $hash
     * @param string $title
     *
     * @throws \coding_exception
     */
    public function set_title(string $hash, string $title) {
        if ($this->get($hash)) {
            $this->favorites[$hash]->title = $title;
            set_user_preference('user_favorites', serialize($this->favorites));
        }
    }

}