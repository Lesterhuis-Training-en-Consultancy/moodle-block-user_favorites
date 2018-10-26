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
 *
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-block-user_favorites
 * @copyright 26-10-2018 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/

defined('MOODLE_INTERNAL') || die;

class block_user_favorites_external extends external_api {

    /**
     * If everything goes according plan, we can use this code.
     *
     * @const RESPONSE_CODE_SUCCESS
     */
    const RESPONSE_CODE_SUCCESS = 200;

    /**
     * Set a url
     *
     * @param string $hash
     * @param string $encode_url
     * @param string $title
     * @param int    $blockid
     *
     * @return array
     * @throws coding_exception
     * @throws required_capability_exception
     * @throws moodle_exception
     */
    public static function set_url(string $hash, string $encode_url, string $title, int $blockid) {
        global $USER;

        require_capability('block/user_favorites:add', context_block::instance($blockid), $USER);

        $url = (string)base64_decode($encode_url);

        if (!filter_var($url, FILTER_VALIDATE_URL) && $hash === md5($url)) {
            throw new \moodle_exception('Incorrect url.');
        }

        $favorites = new \block_user_favorites\favorites();
        $favorites->set_by_url($url, $title);

        return [
            'result_code' => self::RESPONSE_CODE_SUCCESS,
        ];
    }

    /**
     * Describes the input parameters for set_url.
     *
     * @return external_function_parameters
     */
    public static function set_url_parameters() {
        return new external_function_parameters (
            [
                'hash' => new external_value(PARAM_TEXT, 'URL HASH', VALUE_REQUIRED),
                'encode_url' => new external_value(PARAM_RAW, 'Encoded URL', VALUE_REQUIRED),
                'title' => new external_value(PARAM_RAW, 'The title of the url', VALUE_REQUIRED),
                'blockid' => new external_value(PARAM_INT, 'The ID of the block', VALUE_REQUIRED),
            ]
        );
    }

    /**
     * Set url return value.
     *
     * @return external_single_structure
     */
    public static function set_url_returns() {
        return new external_single_structure(
            [
                'result_code' => new external_value(PARAM_INT, 'The response code', VALUE_REQUIRED),
            ]);
    }

    /**
     * Delete url
     *
     * @param string $hash
     * @param int    $blockid
     *
     * @return array
     * @throws required_capability_exception
     * @throws coding_exception
     */
    public static function delete_url(string $hash, int $blockid) {
        global $USER;

        require_capability('block/user_favorites:delete', context_block::instance($blockid), $USER);

        $favorites = new \block_user_favorites\favorites();
        $favorites->delete_by_hash($hash);

        return [
            'result_code' => self::RESPONSE_CODE_SUCCESS,
        ];
    }

    /**
     * Describes the input parameters for delete_url.
     *
     * @return external_function_parameters
     */
    public static function delete_url_parameters() {
        return new external_function_parameters (
            [
                'hash' => new external_value(PARAM_TEXT, 'URL HASH', VALUE_REQUIRED),
                'blockid' => new external_value(PARAM_INT, 'The ID of the block', VALUE_REQUIRED),
            ]
        );
    }

    /**
     * Delete url return value.
     *
     * @return external_single_structure
     */
    public static function delete_url_returns() {
        return new external_single_structure(
            [
                'result_code' => new external_value(PARAM_INT, 'The response code', VALUE_REQUIRED),
            ]);
    }

    /**
     * Get block content
     *
     * @param int $blockid
     *
     * @return array
     * @throws coding_exception
     * @throws required_capability_exception
     */
    public static function get_content(int $blockid) {
        global $PAGE, $USER;

        require_capability('block/user_favorites:view', context_block::instance($blockid), $USER);

        $favorites = new \block_user_favorites\favorites();
        $renderer = $PAGE->get_renderer('block_user_favorites');

        return [
            'content' => $renderer->render_favorites(new \block_user_favorites\output\output_favorites($favorites)),
            'result_code' => self::RESPONSE_CODE_SUCCESS,
        ];
    }

    /**
     * Describes the input parameters for get_content.
     *
     * @return external_function_parameters
     */
    public static function get_content_parameters() {
        return new external_function_parameters (
            [
                'blockid' => new external_value(PARAM_INT, 'The ID of the block', VALUE_REQUIRED),
            ]
        );
    }

    /**
     * Content return value.
     *
     * @return external_single_structure
     */
    public static function get_content_returns() {
        return new external_single_structure(
            [
                'result_code' => new external_value(PARAM_INT, 'The response code', VALUE_REQUIRED),
                'content' => new external_value(PARAM_RAW, 'The block content', VALUE_REQUIRED),
            ]);
    }

}