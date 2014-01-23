=== db-form ===
Contributors: valentinalisch
Tags: form, database, db, data, value, shortcode, submit, email, e-mail, survey, inquiry, poll, simple, valentinalisch, valentin alisch, valentin
Requires at least: 3.2
Tested up to: 3.5.1
Stable tag: 1.1.1

Simple plugIn to submit entries to a database.

== Description ==

__Description:__ <br />
This is just a simple plugIn to submit values to a specific mySQL database.

You can configure the plugIn to either add the given values to a mySQL database
or to send those values to a specific e-mail address.

__Additional features are:__

* Confirmation mail
* Custom mail subjects
* Custom mail messages
* Custom message after form is submitted
* Custom stylesheet selection

Please make sure to read the [documentation](http://www.valentinalisch.de/dev_wp/db-form/ "db-form documentation") before using the plugIn.<br />
It is important.

__Links:__ <br />
Documentation: [http://www.valentinalisch.de/dev_wp/db-form/](http://www.valentinalisch.de/dev_wp/db-form/ "db-form documentation") <br />
Shortcodes: [http://www.valentinalisch.de/dev_wp/db-form/#shortcodes](http://www.valentinalisch.de/dev_wp/db-form/#shortcodes "db-form documentation") <br />
Contact: [http://www.valentinalisch.de/dev_wp/db-form/#contact](http://www.valentinalisch.de/dev_wp/db-form/#contact "db-form documentation") <br />


__Icons in banner:__ <br />
Iconset: One bit by Icojam <br />
[http://www.iconfinder.com/search/?q=iconset%3Aonebit](http://www.iconfinder.com/search/?q=iconset%3Aonebit "icon set")


== Installation ==

1. Upload the `db-form` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin using the 'db-form' menu
1. Use the provided [shortcodes](http://www.valentinalisch.de/dev_wp/db-form/#shortcodes "db-form documentation") to set up your form

== Frequently Asked Questions ==

= No questions asked yet =
Feel free to do so.

== Screenshots ==

1. Possible form configuration
2. Error message
3. Admin Panel

== Changelog ==

= 1.1.1 =
* Bug fix for localhost servers
* Bug fixes

= 1.1 =
* Option to select confirmation mail recipient added
* `[select]` shortcode added (drop downs)

= 1.0.1 =
* Bug fixes

= 1.0 =
* Updated to work with wordpress 3.5.1
* Simplified code
* Updated HTML output
* Updated CSS classes
* Updated admin panel
* Updated documentation
* Customizable error messages added
* Stylesheet selection temporarily removed
* `[hidden]` shortcode added

= 0.2 =
* `[textarea]` shortcode added

= 0.1.2 =
* PHP security issues resolved
* Code changes (simplified)
* Admin panel changes (simplified)

= 0.1 =
* Initial release

== Upgrade Notice ==

= 1.1 =
Important Update!
Rewritten HTML output, rewritten configuration pages.
This requires you to update your settings and eventually completely change/rewrite your CSS files
which you use to style the plugIn.
Custom CSS stylesheet selection is not supported right now! (Will be available in 1.1.1 — May 7th)

= 1.0.1 =
Important Update!
Rewritten HTML output, rewritten configuration pages.
This requires you to update your settings and eventually completely change/rewrite your CSS files
which you use to style the plugIn.

= 1.0 =
Important Update!
Rewritten HTML output, rewritten configuration pages.
This requires you to update your settings and eventually completely change/rewrite your CSS files
which you use to style the plugIn.
Custom CSS stylesheet selection is not supported right now! (Will be available in 1.1 — May 5th)

= 0.2 =
New shortcode for textareas added.

= 0.1.2 =
Security Update

= 0.1 =
Initial release