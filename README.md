### Accessibility Checker WordPress Environment

License: GPLv2 or later

License URI: https://www.gnu.org/licenses/gpl-2.0.html

This package is a customized version of [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) used for development and testing of Accessibility Checker, Accessibility Checker Pro and Accessibility Checker Audit History.


### Description

Accessibility Checker needs the webserver to make loopback curl request to its hosted sites, which wp-env does not support.

This package:

1. Modifies the standard version of wp-env to enable loopback.
2. Loads a mu-plugin that disables deleting or updating the plugins to prevent accidental deletiong/modification of the plugin src.


### Installation
Run `npm install` from the plugin folder.


### Settings
1. The `accessibility-checker` `accessibility-checker-pro` `accessibility-checker-wp-env` folders are all expected to be stored under a common parent folder. If you use a different folder setup, you should override the `mappings` setting in `.wp-env.json`.

2. The webserver is configured for basic Auth by default (admin|password). You can override this by commenting these entries in `./.wp-env/cfg/htaccess.txt`:

```#AuthName "Dialog prompt"
#AuthType Basic
#AuthUserFile /var/www/html/.htpasswd
#Require valid-user
```

3. The `wp:init` script can automatically fill the Accessibility Checker Pro license key. To setup,
update `./wp-env/cfg/env.txt` with the license to use and rename the file `.env`





