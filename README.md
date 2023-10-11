### Accessibility Checker WordPress Environment

License: GPLv2 or later

License URI: https://www.gnu.org/licenses/gpl-2.0.html

This package is a customized version of wp-env used for development and testing of Accessibility Checker, Accessibility Checker Pro and Accessibility Checker Audit History.


### Description

Accessibility Checker needs the webserver to make loopback curl request to its hosted sites, which wp-env does not support.

This package:

1. Modifies the standard version of wp-env to enable loopback.
2. Loads a mu-plugin that disables deleting or updating the plugins to prevent accidental deletiong/modification of the plugin src.


### Installation

1. `cd` to the folder that contains the plugin
2. `composer require --dev equalizedigital/accessibility-checker-wp-env`
3. update `./wp-env/cfg/env.txt` with the accessibility-checker-pro license to use and rename the file `.env`


### Settings
.wp-env.json mappings expects this directory setup:

  a-parent-folder/

  a-parent-folder/accessibility-checker/
  
  a-parent-folder/accessibility-checker-pro/
  
  a-parent-folder/accessibility-checker-audit-checker/

Update the `mappings` setting in `.wp-env.json` to match your directory setup.

