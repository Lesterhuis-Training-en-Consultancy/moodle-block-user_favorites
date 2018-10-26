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
 * Tested in Moodle 3.5
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package moodle-block-user_favorites
 * @copyright 2018 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
/* eslint no-unused-expressions: "off"  no-console: ["error", { allow: ["warn", "error" , "log"] }] */
define(['jquery', 'core/ajax', 'core/notification'], function ($, Ajax, Notification) {

    /**
     * Opts that are possible to set.
     *
     * @type {{id: number, debugjs: boolean}}
     */
    let opts = {
        debugjs: true,
        id     : 0,
    };

    /**
     * Set options base on listed options
     * @param {object} options
     */
    let set_options = function (options) {
        "use strict";
        let key, vartype;
        for (key in opts) {
            if (opts.hasOwnProperty(key) && options.hasOwnProperty(key)) {

                // Casting to prevent errors.
                vartype = typeof opts[key];
                if (vartype === "boolean") {
                    opts[key] = Boolean(options[key]);
                } else if (vartype === 'number') {
                    opts[key] = Number(options[key]);
                } else if (vartype === 'string') {
                    opts[key] = String(options[key]);
                }
                // Skip all other types.
            }
        }
    };

    /**
     * Console log debug wrapper.
     */
    let debug = {};

    /**
     * Set debug mode
     * Should only be enabled if site is in debug mode.
     * @param {boolean} isenabled
     */
    let set_debug = function (isenabled) {

        if (isenabled) {
            for (let m in console) {
                if (typeof console[m] == 'function') {
                    debug[m] = console[m].bind(window.console);
                }
            }
        } else {

            // Fake wrapper.
            for (let m in console) {
                if (typeof console[m] == 'function') {
                    debug[m] = function () {
                    };
                }
            }
        }
    };

    let favorites_module = {

        /**
         * Add or update a url
         *
         * @param {object} data
         * @param {string} title
         */
        set_url: function (data, title) {

            Notification.confirm(M.util.get_string('javascript:set_title', 'block_user_favorites'),
                '<input class="form-control" id="favorite-url" value="' + title + '">',
                M.util.get_string('javascript:yes', 'block_user_favorites'),
                M.util.get_string('javascript:no', 'block_user_favorites'), function () {

                    let request = Ajax.call([{
                        methodname: 'block_user_favorites_set_url',
                        args      : {
                            hash      : data.hash,
                            encode_url: data.encode_url,
                            title     : $('#favorite-url').val(),
                            blockid   : opts.id,
                        }
                    }]);

                    request[0].done(function (response) {
                        debug.log(response);
                        favorites_module.reload();
                    }).fail(Notification.exception);
                });
        },

        /**
         * Delete a url
         *
         * @param {object} data
         */
        delete: function (data) {

            let request = Ajax.call([{
                methodname: 'block_user_favorites_delete_url',
                args      : {
                    hash   : data.hash,
                    blockid: opts.id,
                }
            }]);

            request[0].done(function (response) {
                debug.log(response);
                favorites_module.reload();
            }).fail(Notification.exception);
        },

        /**
         * Reload the block
         */
        reload: function () {

            let request = Ajax.call([{
                methodname: 'block_user_favorites_content',
                args      : {
                    blockid: opts.id,
                }
            }]);

            request[0].done(function (response) {
                debug.log(response);
            }).fail(Notification.exception);
        },

        /**
         * Init event triggers.
         */
        init: function () {

            $('#block_user_favorites_set').on('click', function () {
                debug.log('Set a new favorites');
                favorites_module.set_url($(this).data(), $('title').text());
            });

            $('#block_user_favorites_delete').on('click', function () {
                debug.log('Delete a favorites');
                favorites_module.delete($(this).data());
            });

            $('#block_user_favorites-items .fa-remove').on('click', function () {
                debug.log('Remove a new favorites');
                favorites_module.delete($(this).parent().data());
            });

            $('#block_user_favorites-items .fa-edit').on('click', function () {
                debug.log('Edit a favorites');
            });
        }
    };

    return {

        /**
         * Init.
         */
        initialise: function (args) {

            // Load the args passed from PHP.
            set_options(args);

            // Set internal debug console.
            set_debug(opts.debugjs);

            $.noConflict();
            $(document).ready(function () {
                debug.log('Block User Favorites v1.0');
                favorites_module.init();
            });
        }
    };
});