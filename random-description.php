<?php
/*
	Plugin Name: Random Tagline
	Plugin URI: http://github.com/philipjohn/random-tagline
	Description: Specify multiple blog taglines and let this plugin randomly choose which one to show.
	Author: Philip John
	Version: 0.1
	Author URI: http://philipjohn.me.uk
	Text Domain: random-tagline
	Domain Path: /languages
 */

/**
 * Don't bother loading directly, you naughty person
 */
if ( ! defined('ABSPATH') )
	die('That\'s just not cricket');

/**
 * Define the tagline separator, and allow it to be overriden from wp-config.php.
 *
 * @since 0.1.0
 * @var string $RANDOM_TAGLINE_SEP Tagline separator
 */
if ( ! defined('RANDOM_TAGLINE_SEP') )
	define( 'RANDOM_TAGLINE_SEP', '|' );

/**
 * Returns a randomly chosen tagline
 *
 * Hooks into the option_blogdescription filter to choose one of the provided
 * taglines and returns it
 *
 * @since 0.1.0
 *
 * @filter option_blogdescription
 *
 * @param  string $option The value of the Tagline setting.
 * @return string A new or unmodified Tagline.
 */
function random_tagline( $option ) {
	
	// First, check we're not on the options page, because randomising
	// there would be a Dumb Thing To Do
	if ( ! is_admin() ) {
		
		// Split the taglines up
		$taglines = explode( RANDOM_TAGLINE_SEP, $option );
		
		if ( count($taglines) > 1 ) { // There are multiple taglines
			
			return $taglines[array_rand($taglines, 1)]; // Return a random tagline
			
		} else { // Just the one then... might wanna deactivate the plugin ;)
			
			return $option; // send back the original
			
		}
		
	} else {
		return $option;
	}
	
}
add_filter( 'option_blogdescription', 'random_tagline' ); // HOOK IT!