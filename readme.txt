=== Owner/Author Ad Split for Genesis===
Contributors: joshlimecuda, imeson
Donate link: https://fewerthanthree.com
Tags: genesis, adsense, ads, ad sharing
Requires at least: 4.2
Tested up to: 4.6.1
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allow authors to share ad space for their posts on your blog and set how often your ad displays vs the author's ad

== Description ==

Built specifically for use with the [Genesis Framework](http://joshmallard.com/genesis-link), the Owner/Author Ad Split plugin allows your blog authors to share in the ad space for their blog posts on your site.

The plugin has the option to include ad spaces by default above and below the post content as well as within the post content via the `[gb_ad]`, `[gb_ad_above]`, & `[gb_ad_below]` shortcode.

= Ad Codes & Weights =

**Site Owner**

When activated alongside the Genesis Framework, you will be able to add your Above-content, Below-content, and Shortcode ad codes via the new "Ad Split" dashboard menu section within the Genesis Settings.

These settings will also allow you to set the percentage for which your ad for each of these locations will display over the Author's ad.

**Post Authors**

Ad codes for the post authors can be added via the users profile page.

= Displaying Ads =
By default, if ad codes are added for either the site owner or the post author, ads will display above and below the content. There are two ways to modify this behavior:

*	Allow ads to display globally and hide on specific posts using the settings available on the post edit screen
*	Turn off the display by default globally within the plugin settings found within the Genesis Admin section under the "Ad Split" menu item. You can then turn the ads on for specific posts using the settings available on the post edit screen


== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for ‘genesis shortcode generator’
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

== Frequently Asked Questions ==

= Why can't authors set their own ad codes? =
Setting of the ad codes is limited to users that have the ability to save unfiltered html. This is available for the Editor role and up. This is a security measure since ads include script tags and prevents malicious code from being saved and then presented on the front-end of your site

== Screenshots ==

1. Set the site owner ads and display weight
2. Set the post author ads on their profile page

== Changelog ==

= 1.2.0 =
* Added shortcodes for above and below content ads ([gb_ad_above], [gb_ad_below])
* Option to automatically include content ad in WYSIWYG of post draft

= 1.1.0 =
* Update shortcode ad wording to "Content Ad"
* Added shortcode reference to global settings page
* Update title and wording on postmeta box
* Made select options on postmeta box translatable
* Added post metabox prompt to update ad codes
* Added filters (above_content_ad_priority and below_content_ad_priority) for changing the priority on the automatic content ads

= 1.0.0 =
* Initial Plugin Release

== Upgrade Notice ==

= 1.0.0 =
* Because this plugin is awesome and you love the Genesis Framework
