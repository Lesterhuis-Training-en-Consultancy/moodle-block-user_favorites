## Moodle block for marking your favourite pages as bookmarks

In brief, the MFreak block `user_favorites` gives the user a method to mark pages as favourite.
 
![MFreak.nl](https://MFreak.nl/logo_small.png)

* Author: Luuk Verhoeven, [MFreak.nl](https://MFreak.nl/)
* Min. required: Moodle 3.5.x
* Supports PHP: 7.0 | 7.1 | 7.2 

[![Build Status](https://travis-ci.org/MFreakNL/moodle-block-user_favorites.svg?branch=master)](https://travis-ci.org/MoodleFreak/moodle-block-user_favorites) 
![Moodle35](https://img.shields.io/badge/moodle-3.5-brightgreen.svg)
![PHP7.0](https://img.shields.io/badge/PHP-7.0-brightgreen.svg)

## Screens

![Adding](https://content.screencast.com/users/LuukVerhoeven/folders/Snagit/media/0a62b7d5-c369-453f-9a63-fff5d2c24f9b/10.27.2018-12.40.GIF)

## List of features
- Using external AJAX requests for saving and loading user favourites.
- Using mustache templates.
- Fast and easy to work with.
- Marks current page in favorites if exists. 

## Installation
1.  Copy this plugin to the `blocks\user_favorites` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin

## Known issues
We are using the `user_preferences` DB table for storing user favourites. 
The max length stored here is a varchar 1333. Because of this, the plugin has a limit in how many favourites a user can store.

### Workaround for this
```sql
ALTER TABLE `mdl_user_preferences` 
MODIFY COLUMN `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' AFTER `name`
```
[Tracker issue 3](https://github.com/MFreakNL/moodle-block-user_favorites/issues/3)

## Security

If you discover any security related issues, please email [luuk@MFreak.nl](mailto:luuk@MFreak.nl) instead of using the issue tracker.

## License

The GNU GENERAL PUBLIC LICENSE. Please see [License File](LICENSE) for more information.

## Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests on Github.

- Thanks for the inspiration [block_user_bookmarks](https://moodle.org/plugins/block_user_bookmarks)