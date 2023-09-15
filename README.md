## Moodle block for marking your favourite pages as bookmarks

In brief, the MFreak block `user_favorites` gives the user a method to mark pages as favourite.

Special thanks to Gemma Lesterhuis ([Lesterhuis Training & Consultancy](https://ltnc.nl/)) for develop & design, useful
input, bug reports and beta testing

![MFreak.nl](https://MFreak.nl/logo_small.png)
![Lesterhuis Training & Consultancy](https://ldesignmedia.nl/logo_small_ltnc.png)

* Author: Luuk Verhoeven, [MFreak.nl](https://MFreak.nl/)
* Author: Gemma Lesterhuis, [Lesterhuis Training & Consultancy](https://ltnc.nl/)
* Min. required: Moodle 3.5.x
* Supports PHP:  7.2

![Moodle35](https://img.shields.io/badge/moodle-3.5-brightgreen.svg)
![Moodle36](https://img.shields.io/badge/moodle-3.6-brightgreen.svg)
![Moodle37](https://img.shields.io/badge/moodle-3.7-brightgreen.svg)
![Moodle38](https://img.shields.io/badge/moodle-3.8-brightgreen.svg)
![Moodle39](https://img.shields.io/badge/moodle-3.9-brightgreen.svg)
![Moodle310](https://img.shields.io/badge/moodle-3.10-brightgreen.svg)
![Moodle400](https://img.shields.io/badge/moodle-4.0-brightgreen.svg)
![Moodle401](https://img.shields.io/badge/moodle-4.1-brightgreen.svg)

## Screens

![Adding](https://content.screencast.com/users/LuukVerhoeven/folders/Snagit/media/0a62b7d5-c369-453f-9a63-fff5d2c24f9b/10.27.2018-12.40.GIF)

## List of features
- Using external AJAX requests for saving loading and ordering user favourites.
- Using mustache templates.
- Fast and easy to work with.
- Marks current page in favorites if exists.
- Allow marking as favorite the url link with `#hash` (In case of marking multiple links for the same page, A web page reload needed before).
- Make use of external API web services as in the tracker MDL-76583.

## Installation

1. Copy this plugin to the `blocks\user_favorites` folder on the server
2. Login as administrator
3. Go to Site Administrator > Notification
4. Install the plugin

## Security

If you discover any security related issues, please email [luuk@MFreak.nl](mailto:luuk@MFreak.nl) instead of using the
issue tracker.

## License

The GNU GENERAL PUBLIC LICENSE. Please see [License File](LICENSE) for more information.

## Contributing

Contributions are welcome and will be fully credited. We accept contributions via Pull Requests on Github.

- Thanks for the inspiration [block_user_bookmarks](https://moodle.org/plugins/block_user_bookmarks)
- Thank you to @stopfstedt, 2gjb2048, and @SashaAnastasi for your valuable contributions to enhancing the plugin.
