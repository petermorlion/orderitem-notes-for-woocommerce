=== Order Item Notes For WooCommerce ===
Contributors: petermorlion
Tags: woocommerce, notes
Requires at least: 6.1.1
Tested up to: 6.5
Stable tag: 1.1.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin to allow notes on order items in WooCommerce.

== Description ==

You can currently add notes to an order in WooCommerce, but you can't add notes to individual order items.
This plugin makes it easy for administrators to add notes to individual order items of a WooCommerce order.

Once activated, each order item in the Admin interface will have a textbox:

![WooCommerce Order Item Notes interface](assets/screenshot-1.png "WooCommerce Order Item Notes interface")

Enter your notes and save the order. Your notes will now show when you load the order in the future.

== Frequently Asked Questions ==

= Will it work on older versions of WordPress? =

Yes, it probably will, but I haven't tested it on older versions. Let me know if it works on your version.

== Screenshots ==

1. Adding notes to individual order items of a WooCommerce order

== Changelog ==

= 1.2.0 =
* Tested with Wordpress 6.5

= 1.1.1 =
* Remove calls to wc_get_logger() because it interferes with other plugins that save posts before WooCommerce is set up.

= 1.1.0 =
* Declare HPOS compatibility

= 1.0.4 =
* Fix update bug
* Fix layout bug

= 1.0.3 =
* Tested with WordPress 6.3

= 1.0.2 =
* Fix: Don't run for inserts.

= 1.0.1 =
* Adressed required changes for Wordpress.org hosting

= 1.0 =
* First working version.

== Workflow ==
This plugin is developed on [GitHub](https://github.com/petermorlion/orderitem-notes-for-woocommerce),
but released to SVN using [this workflow](https://teleogistic.net/2011/05/23/revisiting-git-github-and-the-wordpress-org-plugin-repository/).

In short: develop in Git and on GitHub as normal. Then, something like this (not 100% verified):

* git fetch
* git checkout master
* git rebase trunk
* git svn fetch -r 2974662:HEAD
* git svn rebase
* git svn dcommit
* git rebase origin/master master
* git push

To release:

* create the tag in git as usual
* git svn tag vx.x.x

To set this up initially:

* git clone <this_git_repo>
* cd <the_local_dir>
* git svn init <the_svn_repo>/trunk
* svn log <the_svn_repo>
* take the first revision
* git svn fetch -r <first_revision> (creates git-svn branch)
* git rebase git-svn
* git svn dcommit
