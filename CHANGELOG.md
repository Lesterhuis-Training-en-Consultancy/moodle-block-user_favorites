# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)

# Plugin version.php information
```php
// Example

// Plugin release number corresponds to the lasest tested Moodle version in which the plugin has been tested.
$plugin->release = '3.5.7'; // [3.5.7]

// Plugin version number corresponds to the latest plugin version.
$plugin->version = 2019010100; // 2019-01-01
```

# How do I make a good changelog?
Guiding Principles
* Changelogs are for humans, not machines.
* There should be an entry for every single version.
* The same types of changes should be grouped.
* The latest version comes first.
* The release date of each version is displayed.

Types of changes
* **Added** for new features.
* **Changed** for changes in existing functionality.
* **Deprecated** for soon-to-be removed features.
* **Removed** for now removed features.
* **Fixed** for any bug fixes.
* **Security** in case of vulnerabilities.

## Version (3.9) - 2020-05-06

### Changed
- Updated version number, no issues found.
- Minimum version PHP 7.2

## Version (3.8) - 2019-10-30

### Changed
- Updated version number, no issues found.

## Version (3.7.2) - 2019-09-17

### Fixed
- [ISSUE #3](https://github.com/MFreakNL/moodle-block-user_favorites/issues/3) Saving user favourites to a separate table.
- Upgrade script `user_preference` -> `block_user_favorites` using a separate table.
- Implement privacy provider for the new table.


## Version (3.5.3) - 2019-05-20

### Added
- Release of the first official stable version.