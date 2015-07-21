<?php
/**
 * The Plugin File
 *
 * @link              http://www.chriswgerber.com/dfp-ads/interstitial
 * @since             1.0.0
 * @subpackage        DFP-Ads-Interstitial
 *
 * @wordpress-plugin
 * Plugin Name:       DFP Ad Manager - Interstitial
 * Plugin URI:        http://www.chriswgerber.com/dfp-ads/interstitial
 * Description:       Creates Interstitial Ad Position utilizing DFP Ad Manager
 * Version:           1.0.1
 * Author:            Chris W. Gerber
 * Author URI:        http://www.chriswgerber.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dfp-ads-interstitial
 */

function dfp_interstitial_init() {
	global $dfp_ads;

	if ( $dfp_ads !== null ) {
		include 'includes/Interstitial_Ad.php';

		$interstitial_ad          = new DFP_Ads\Interstitial_Ad ( $dfp_ads );
		$interstitial_ad->dir_uri = plugins_url( null, __FILE__ );
		$interstitial_pos_id      = dfp_get_settings_value( 'dfp_interstitial_id' );
		$inter_position           = dfp_get_ad_position( $interstitial_pos_id );
		if ( $inter_position !== false ) {
			$interstitial_ad->ad_position( $inter_position );
		}
		/* Section headings */
		add_filter( 'dfp_ads_settings_sections', ( function( $sections ) {
			$sections['interstitial_settings'] = array(
				'id'    => 'interstitial_settings',
				'title' => 'Interstitial Ad Settings'
			);
			return $sections;
		} ) );
		/* Wallpaper Ad setting */
		add_filter( 'dfp_ads_settings_fields', ( function ( $fields ) {
			$fields['dfp_interstitial_id'] = array(
				'id'          => 'dfp_interstitial_id',
				'field'       => 'text',
				'callback'    => 'ads_dropdown',
				'title'       => 'Interstitial Ad Title',
				'section'     => 'interstitial_settings',
				'description' => 'Choose the interstitial ad from the settings.'
			);
			return $fields;
		} ) );
		// Add in position
		add_filter( 'pre_dfp_ads_to_js', array( $interstitial_ad, 'send_ads_to_js' ) );
		// Enqueues Scripts and Styles
		add_action( 'wp_enqueue_scripts', array( $interstitial_ad, 'scripts_and_styles' ) );
	}
}
add_action( 'plugins_loaded', 'dfp_interstitial_init' );