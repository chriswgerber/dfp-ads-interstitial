<?php
/**
 * The Plugin File
 *
 * @link              http://www.chriswgerber.com/dfp-ads/interstitial
 * @since             1.0.0
 * @subpackage        DFP-Ads-Interstitial
 *
 * @wordpress-plugin
 * Plugin Name:       DFP - Interstitial Ad
 * Plugin URI:        http://www.chriswgerber.com/dfp-ads/interstitial
 * Description:       Creates specialty interstitial ad position
 * Version:           1.0.0
 * Author:            Chris W. Gerber
 * Author URI:        http://www.chriswgerber.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dfp-ads-interstitial
 */

if ( class_exists( 'dfp_ads' ) ) {

	global $dfp_ads;

	include( 'class.dfp_interstitial_ad.php' );
	$interstitial_ad          = new DFP_Interstitial_Ad ( $dfp_ads );
	$interstitial_ad->dir_uri = plugins_url( null, __FILE__ );
	$position_title           = dfp_get_settings_value( 'dfp_interstitial_id' );
	$inter_position           = dfp_get_ad_position_by_name( $position_title );
	$interstitial_ad->ad_position( $inter_position );

	/* Section Fields */
	add_filter( 'dfp_ads_settings_fields', ( function ( $fields ) {
		$fields['dfp_interstitial_id'] = array(
			'id'          => 'dfp_interstitial_id',
			'field'       => 'text',
			'title'       => 'Interstitial Ad Title',
			'section'     => 'general_settings',
			'description' => 'Enter the ad code for the interstitial ad.'
		);

		return $fields;
	} ) );

	// Add in position
	add_filter( 'pre_dfp_ads_to_js', array( $interstitial_ad, 'send_ads_to_js' ) );
	// Enqueues Scripts and Styles
	add_action( 'wp_enqueue_scripts', array( $interstitial_ad, 'scripts_and_styles' ) );
	// Adds Styles to head.
	add_action( 'wp_head', array( $interstitial_ad, 'css_style' ) );

}