<?php
/*
 * Plugin Name: Client Area
 * Description: Client Management with Stripe Checkout Integration
 * Version: 1.1
 * Author: Andrew Carlson
 * Author URI: https://andrewcarlsonweb.com
 * License: GPL2
 */

if ( is_admin() ) {
	// If admin, create the settings page and shortcode functionality.
	require_once( plugin_dir_path( __FILE__ ) . '/options.php' );
} else {
	// If this is the front end, add the scripts, stripe API and shortcodes we need for the checkout to work.
	require_once( plugin_dir_path( __FILE__ ) . '/front.php' );
}