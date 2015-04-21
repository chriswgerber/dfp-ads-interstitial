/**
 * Javascript for Google Ads
 *
 * @since 0.0.1
 *
 **/

/**
 * Ad Position Creation
 */
googletag.cmd.push( function() {

    var dfp_ad_data = dfp_ad_object[0],
        acct_id = dfp_ad_data.account_id,
        roadblock_id = dfp_ad_data.roadblock_id,
        slot_render = (function(event) {
            if (event.isEmpty !== true) {
                var ad_unit = event.slot.getAdUnitPath(),
                    pop_under_id = acct_id + roadblock_id;
                show_interstitial(ad_unit, pop_under_id);
            }
        });

    /**
     * Loads Ad Position
     *
     * @param {Array} positions - Array of ad positions
     */
    function load_ad_positions(positions) {
        // Run through positions
        for (var ad_pos in positions) {
            define_ad_slot(positions[ad_pos]);
            if (positions[ad_pos].ad_name == roadblock_id) {
                render_interstitial_slot(positions[ad_pos]);
            }
        }
    }
    // Slot Rendering Events
    googletag.pubads().addEventListener('slotRenderEnded', slot_render);

    function render_interstitial_slot(position) {
        append_interstitial(position.position_tag);
    }

    /**
     *
     * @param {String} ad_id
     * @param {String} interstitial_id
     */
    function show_interstitial(ad_id, interstitial_id) {
        if (ad_id == interstitial_id) {
            jQuery('.interstitialAd').show();
        }
    }

    /**
     *
     * @param {String} ad_tag - Div tag for the ad position
     */
    function append_interstitial(ad_tag) {
        jQuery('body').ready(function() {
            jQuery('<div class="interstitialAd">' +
                '<div class="close-interstitial">X</div>' +
                '<!-- Roadblock -->' +
                '<div id=' + ad_tag + '>' +
                '<script type="text/javascript">' +
                'googletag.cmd.push(function() { ' +
                'googletag.display("' + ad_tag + '"); });' +
                '</script>' +
                '</div>' +
                '<!-- Roadblock out-of-page -->' +
                '<div id="' + ad_tag + '-oop">' +
                '<script type="text/javascript">' +
                'googletag.cmd.push(function() { ' +
                'googletag.display("' + ad_tag + '-oop"); });' +
                '</script>' +
                '</div>' +
                '</div>'
            ).prependTo('body');
        });

        var close_overlay = function() {
            jQuery(this).hide();
        };
        var $ad_postition = jQuery('.interstitialAd'),
            $close_button = jQuery('.close-interstitial');

        $ad_postition.on('click', close_overlay);
        $close_button.on('click', close_overlay);
    }
});