<?php
/**
 * Plugin Name:     Rdc Business Hours
 * Plugin URI:      https://github.com/ranchodeluxemedia/rdc-business-hours
 * Description:     Simple shortcode to put business hours in the topbar
 * Author:          Chris Canterbury
 * Author URI:      https://ranchodeluxe.dev
 * Text Domain:     rdc-business-hours
 * Domain Path:     /languages
 * Version:         0.1.3
 * Github Repository: ranchodeluxemedia/rdc-business-hours
 * Github Plugin URI: ranchodeluxemedia/rdc-business-hours
 *
 * @package         Rdc_Business_Hours
 */


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// github updater overide dot org updates
add_filter( 'github_updater_override_dot_org', function() {
    return [
        'rdc-business-hours/rdc-business-hours.php' //plugin format
    ];
});

// Disables WP-Cron for API calls
add_filter( 'github_updater_disable_wpcron', '__return_true' );


// hook into API::exit_no_update() so that the user can always check for a new update
add_filter( 'ghu_always_fetch_update', '__return_true' );



// require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/inc/StoreHours.class.php';

function rdc_store_hours() {
	// Set the timezone - remove if buggy.
	date_default_timezone_set('America/Chicago');

	$hours = array(
        'mon' => array('09:00-17:30'),
        'tue' => array('09:00-17:30'),
        'wed' => array('09:00-17:30'),
        'thu' => array('09:00-17:30'),
        'fri' => array('09:00-17:30'),
        'sat' => array('08:00-16:00'),
        'sun' => array('')
	);

	$exceptions = array();
	$config = array();
	$template = array(
		'open' => "<p class='rdc-store-hours'>Yes, we're open! Come by before {%closed%}!</p>",
		'closed' => "<p class='rdc-store-hours'>Sorry, we're closed. Today's hours are {%hours%}.</p>",
		'closed_all_day' => "<p class='rdc-store-hours'>Sorry, we're closed today. We'll be back tomorrow at 9:00AM.</p>",
		'separator' => " - ",
		'join' => " and ",
		'format' => "g:ia",
		'hours' => "{%open%}{%separator%}{%closed%}",
	);

	$store_hours = new StoreHours($hours, $exceptions, $template);

	// Display

	// if($store_hours->is_open()) {
	// 	return "Yes, we're open! Today's hours are " . $store_hours->hours_today() . ".";
	// } else {
	// 	return "Sorry, we're closed. Today's hours are " . $store_hours->hours_today() . ".";
	// }
	// $store_hours = new StoreHours($hours, $exceptions, $template);
	return $store_hours->render();


}
add_shortcode('store-hours', 'rdc_store_hours');

