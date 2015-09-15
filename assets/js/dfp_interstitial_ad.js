'use strict';


var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
  var gads = document.createElement('script');
  gads.async = true;
  gads.type = 'text/javascript';
  var useSSL = 'https:' === document.location.protocol;
  gads.src = (useSSL ? 'https:' : 'http:') +
    '//www.googletagservices.com/tag/js/gpt.js';
  var node = document.getElementsByTagName('script')[0];
  node.parentNode.insertBefore(gads, node);
})();

/**
 * Creates the ad object.
 * @param {Object} data
 */
function Interstitial_Ad_Position(data) {
  /**
   * @constructor
   */
  this.Constructor = function() { };
  this.ad_position = (data.ad_name ? data.ad_name : '');
  this.position_tag = (data.position_tag ? data.position_tag : '');
}

// The Ad Position
var dfp_ads = dfp_ad_object[0];
var interstitial_ad = dfp_ads.interstitial_ad;
jQuery(document).ready(function($) {
  /**
   * Ad Position Data
   */
  var ad_data = new Interstitial_Ad_Position(interstitial_ad);

  /**
   * Hide this object
   */
  var hide_div = function() {
    $(this).hide();
  };

  /**
   * HTML Ad Position
   * @type {string}
   */
  var html_tag = '<div class="interstitialAd">' +
      '<div class="close-interstitial">X</div>' +
      '<!-- Roadblock -->' +
      '<div id=' + ad_data.position_tag + ' style="width:1px; height:1px;">' +
      '<script type="text/javascript">' +
      'googletag.cmd.push(function() { googletag.display(\'' +
      ad_data.position_tag + '\'); });' +
      '</script>' +
      '</div>' +
      '<!-- Roadblock out-of-page -->' +
      '<div id="' + ad_data.position_tag + '-oop">' +
      '<script type="text/javascript">' +
      'googletag.cmd.push(function() { googletag.display(\'' +
      ad_data.position_tag + '-oop\'); });' +
      '</script>' +
      '</div>' +
      '</div>';

  /**
   * Interstitial Ad Javascript
   */
  googletag.cmd.push(function() {
    // Define Slot
    googletag.defineSlot(
        dfp_ads.account_id + ad_data.ad_position,
        [1, 1],
        ad_data.position_tag)
      .addService(googletag.pubads());
    // Define OOP Slot
    googletag.defineOutOfPageSlot(
        ad_data.ad_position,
        ad_data.position_tag + '-oop')
      .addService(googletag.pubads());
    // Callback when the slot is rendered.
    googletag.pubads().addEventListener('slotRenderEnded', function(event) {
      if (
          !event.isEmpty && (event.slot.getAdUnitPath() === (dfp_ads.account_id + ad_data.ad_position))
      ) {
        $('.interstitialAd').show();
      }
    });
  });

  /**
   * Load the html object at the top of the page.
   */
  $('body').prepend(html_tag);
  $('.interstitialAd').on('click', hide_div);
  $('.close-interstitial').on('click', hide_div);
});
