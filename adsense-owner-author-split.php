<?php
/**
 * Plugin Name:     Owner/Author Ad Split for Genesis
 * Plugin URI:      https://fewerthanthree.com/plugin/ownerauthor-ad-split-for-genesis
 * Description:     Built specifically for use with the Genesis Framework, split ad space with post author and set how often your ad displays vs the post author's ad
 * Version:         1.2.0
 * Author:          Josh Mallard
 * Author URI:      https://fewerthanthree.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     owner-author-ad-split
 * Domain Path:     /languages
 *
 * @package   owner-author-ad-split
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once( 'includes/Main.php' );
include_once( 'admin/Admin.php' );

function lc_owner_author_ad_split() {
	new LimeCuda\Owner_Author_Ad_Split\Owner_Author_Ad_Split();
}

lc_owner_author_ad_split();

function lc_owner_author_ad_split_admin() {
	if ( is_admin() ) {
		new LimeCuda\Owner_Author_Ad_Split\Admin\Admin();
	}
}

lc_owner_author_ad_split_admin();
