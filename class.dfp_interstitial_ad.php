<?php
/**
 * DFP Interstitial Ad
 *
 * Holds the data that will be sent to the front end for display.
 *
 * @link  http://www.chriswgerber.com/dfp-ads/interstitial
 * @since x.x.x
 *
 * @package    WordPress
 * @subpackage DFP-Ads-Interstitial
 */

class DFP_Interstitial_Ad {

	/**
	 * Script Name
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $script_name = 'dfp_ads_interstitial';

	/**
	 * Ad position Object
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var DFP_Ad_Position|null
	 */
	public $ad_position;

	/**
	 * @access public
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $dir_uri;

	/**
	 * DFP Ad Object
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var DFP_Ads
	 */
	public $dfp_ads;

	/**
	 * PHP5 Constructor
	 *
	 * @param $dfp_ads DFP_Ads
	 */
	public function __construct( DFP_Ads $dfp_ads ) {
		$this->dfp_ads = $dfp_ads;
	}

	/**
	 * Filtering in roadblock ID
	 */
	public function send_ads_to_js( $dfp_ads ) {

		$dfp_ads->roadblock_ad = $this->ad_position;

		return $dfp_ads;
	}

	public function ad_position( DFP_Ad_Position $ad_position ) {

		$this->ad_position = $ad_position;
	}

	/**
	 * Registers Scripts. Localizes data to interstitial_ad.js
	 */
	public function scripts_and_styles() {

		// Preps the script
		wp_register_script(
			$this->script_name,
			$this->dir_uri . '/dfp_interstitial_ad.js',
			array( $this->dfp_ads->script_name, 'jquery' ),
			false,
			false
		);

		wp_enqueue_script( $this->script_name );
	}

	/**
	 * Styles for the popunder ad.
	 */
	public function css_style() {
		?>
		<style type="text/css">
			.interstitialAd {
				display: none;
				z-index: 10000;
				width: 100%;
				height: 100%;
				background-color: rgba( 0, 0, 0, 0.70);
				color: #000000;
				margin: auto;
				padding: 0;
				position: fixed;
				top: 0;
				left: 0;
				text-align: center;
				alignment-baseline: central;
			}

			.interstitialAd #<?php _e( $this->ad_position->position_tag, 'dfp-ads-interstitial' ); ?> {
				z-index: 10001;
				display: block !important;
				margin: 15% 25%;
				position: relative;
			}

			.interstitialAd #<?php _e( $this->ad_position->position_tag, 'dfp-ads-interstitial' ); ?> iframe {
                -webkit-box-shadow: 0px 0px 30px 0px rgba(0, 0, 0, 0.9);
                -moz-box-shadow:    0px 0px 30px 0px rgba(0, 0, 0, 0.9);
                box-shadow:         0px 0px 30px 0px rgba(0, 0, 0, 0.9);
            }

			.close-interstitial {

				cursor: pointer;
				position: absolute;
				right: 0.5em;
				top: 0.5em;

				-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
				-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
				box-shadow:inset 0px 1px 0px 0px #ffffff;
				background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
				background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
				background-color:#ededed;
				-webkit-border-top-left-radius:20px;
				-moz-border-radius-topleft:20px;
				border-top-left-radius:20px;
				-webkit-border-top-right-radius:20px;
				-moz-border-radius-topright:20px;
				border-top-right-radius:20px;
				-webkit-border-bottom-right-radius:20px;
				-moz-border-radius-bottomright:20px;
				border-bottom-right-radius:20px;
				-webkit-border-bottom-left-radius:20px;
				-moz-border-radius-bottomleft:20px;
				border-bottom-left-radius:20px;
				text-indent:0;
				border:1px solid #dcdcdc;
				display:inline-block;
				color:#777777;
				font-family: Verdana;
				font-size:24px;
				font-weight:normal;
				font-style:normal;
				height:50px;
				line-height:50px;
				width:50px;
				text-decoration:none;
				text-align:center;
				text-shadow:1px 1px 0px #ffffff;
			}

			.close-interstitial:hover {
				background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
				background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
				background-color:#dfdfdf;
			}
			/* This button was generated using CSSButtonGenerator.com */
		</style>
	<?php
	}

}