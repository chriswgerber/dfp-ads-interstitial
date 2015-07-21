<?php
/*
Plugin Name: Interstitial Ad
Description: Displays an interstitial ad. Frequency is controlled within Doubleclick for Publishers
Author: Christopher Gerber
Author URI: http://www.chriswgerber.com/
Version: 1.0
*/
namespace DFP_Ads;

use DFP_Ads\DFP_Ads as DFP_Ads;
use DFP_Ads\Position as DFP_Ad_Position;

class Interstitial_Ad {

	public $dir_uri;

	public $ad_position;

	public $dfp_ads;

	/**
	 * PHP5 Constructor
	 *
	 * @param DFP_Ads $dfp_ads
	 */
	public function __construct( DFP_Ads $dfp_ads ) {
		$this->dfp_ads = $dfp_ads;
		$this->dir_uri = plugins_url( null, __FILE__ );
	}

	/**
	 * Adds Ad Position to Class
	 *
	 * @param DFP_Ad_Position $ad_position
	 */
	public function ad_position( DFP_Ad_Position $ad_position ) {
		$this->ad_position = $ad_position;
		$this->ad_position->position_tag = 'interstitial_ad_pos';
	}

	public function scripts_and_styles() {
		// Styles
		wp_register_style( 'interstitial_css', $this->dir_uri . '/assets/css/dfp_interstitial_ad.min.css' );
		wp_enqueue_style( 'interstitial_css' );
		// Scripts
		wp_register_script(
			'epg_interstitial_ad',
			$this->dir_uri . '/assets/js/dfp_interstitial_ad.min.js',
			array( 'jquery', $this->dfp_ads->google_ad_script_name ),
			false,
			false
		);
		wp_enqueue_script( 'epg_interstitial_ad' );
	}

	/**
	 * @param $dfp_ads
	 *
	 * @return mixed
	 */
	public function send_ads_to_js( $dfp_ads ) {
		$dfp_ads->interstitial_ad = $this->ad_position;
		// Check if ad is being queued twice. Remove it from head if it is.
		foreach ( $dfp_ads->positions as $key => $position ) {
			if ( $position->ad_name === $this->ad_position->ad_name ) {
				unset( $dfp_ads->positions[ $key ] );
			}
		}

		return $dfp_ads;
	}

}