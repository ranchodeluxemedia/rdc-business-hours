<?php
/**
 * Plugin Name:     Rdc Business Hours
 * Plugin URI:      https://ranchodeluxe.dev
 * Description:     Simple shortcode to put business hours in the topbar
 * Author:          Chris Canterbury
 * Author URI:      https://ranchodeluxe.dev
 * Text Domain:     rdc-business-hours
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Rdc_Business_Hours
 */


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



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

	$store_hours = new StoreHours($hours, $exceptions, $config);

	// Display

	if($store_hours->is_open()) {
		return "Yes, we're open! Today's hours are " . $store_hours->hours_today() . ".";
	} else {
		return "Sorry, we're closed. Today's hours are " . $store_hours->hours_today() . ".";
	}


}
add_shortcode('store-hours', 'rdc_store_hours');

