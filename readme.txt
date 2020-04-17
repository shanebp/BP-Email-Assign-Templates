=== BP Email Assign Templates ===
Contributors: shanebp
Donate link: https://www.philopress.com/donate/
Tags: buddypress, email, templates
Author URI: https://philopress.com
Plugin URI: https://philopress.com
Requires at least: WP 4.0
Text Domain: bp-email-templates
Domain Path: /languages
Tested up to: 5.4
Stable tag: 1.3
License: GPLv2 or later

A plugin for use with the BuddyPress Email API

== Description ==

This BuddyPress plugin allows site administrators to assign template options to individual BuddyPress Emails. It requires BuddyPress 2.5.1 or higher.

It:

* provides a screen for creating template options
* provides a meta-box for assigning template options to each BuddyPress Email
* filters each BuddyPress email so that it uses the assigned template


It does NOT include:

* templates
* an interface for creating templates


For more info on BuddyPress Emails, visit: [https://codex.buddypress.org/emails/](https://codex.buddypress.org/emails/)
For more info on this plugin, visit: [https://www.philopress.com/products/bp-email-assign-templates/](https://www.philopress.com/products/bp-email-assign-templates/)

For more BuddyPress plugins, visit: [https://www.philopress.com/](https://www.philopress.com/)


== Installation ==

1. Unzip and then upload the 'bp-email-assign-templates' folder to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to Emails > Templates

4. See the HELP tab for more info


== Frequently Asked Questions ==
None yet.


== Upgrade Notice ==

= 1.3 =
* tested with WP 5.4
* fixes bug re Template listings, now uses the proper wildcard

= 1.1 =
* Adds a check re whether the WP_Post object was set

= 1.0 =
No need to upgrade yet.


== Screenshots ==
1. Shows the Emails > Template screen
2. Shows the meta-box on the Email Create and Edit screens


== Changelog ==

= 1.3 =
* tested with WP 5.4
* fixes bug re Template listings, now uses the proper wildcard

= 1.1 =
* add check re WP_Post object. See note in loader.php > function pp_etemplates_template

= 1.0 =
* Initial release.
