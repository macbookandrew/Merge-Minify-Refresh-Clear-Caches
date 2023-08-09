=== Merge + Minify + Refresh Clear Caches ===
Contributors: macbookandrew
Donate link: https://www.paypal.me/AndrewRMinionDesign
Tags: speed, performance, caches, merge minify refresh, cloudflare, wp super cache
Requires at least: 4.4
Tested up to: 6.0.5
Stable tag: 1.1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin clears other page caches/proxies when the Merge + Minify + Refresh cache is regenerated.

== Description ==

This plugin clears other page caches/proxies when the [Merge + Minify + Refresh](https://wordpress.org/plugins/merge-minify-refresh/) cache is regenerated so users don’t end up missing static resources (CSS/JS files) due to a cached page trying to load old static resources.

Note that every time the Merge + Minify + Refresh cache is purged, your page cache and proxies will be purged as well, forcing them to regenerate the cache.

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
1. Activate the plugin through the “Plugins” menu in WordPress
1. Enjoy!
1. Optional: you can force-clear all caches under “Settings > MMR Force Clear Caches”

== Frequently Asked Questions ==

= Can I clear only specific pages from the cache? =

Unfortunately not, since at this point, there’s no way to know which pages will be affected by the minified files.

== Changelog ==

= 1.1.1 =
* Fix wordpress.org autodeployment

= 1.1.0 =
* Add support for RunCloud Hub object cache

= 1.0.0 =
* First version
