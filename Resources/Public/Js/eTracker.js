/**
 * Script for tracking links with eTracker. Needs UserFunc for Typolinks!
 *  Dependency: eTracker Version 3.0
 *
 * @package RKW_RkwEtracker
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Steffen Kroggel, RKW Kompetenzzentrum
 * @licence http://www.gnu.org/copyleft/gpl.htm GNU General Public License, version 2 or later
 * @version 1.0.0
 */

var rkwEtracker = function (options) {


    /*
     * variables
     */
    var settings = {
        debug : false
    };


    /*
     * constructor
     */
    this.construct = function(options){
        $.extend(settings , options);
    };


    /*
     * init eTracker on given DOM-element
     */
    this.init = function(element) {

        if (typeof element === 'undefined') {
            element = jQuery(document);
        }

        jQuery(element).find('a').each(function() {

            if (settings.debug) {
                console.log(jQuery(this));
            }

            jQuery(this).mousedown( function () {

                var element = jQuery(this);

                var title = encodeURI(element.attr('href'));
                if (element.attr('title')) {
                    title = encodeURI(element.attr('title'));
                }
                if (element.attr('data-etracker-title')) {
                    title = element.attr('data-etracker-title');
                }

                var object = encodeURI(element.attr('href'));
                if (element.attr('data-etracker-object')) {
                    object = element.attr('data-etracker-object');
                }

                var category = 'Default';
                if (element.attr('data-etracker-category')) {
                    category = element.attr('data-etracker-category');
                }

                // actions are equivalent to TypoLink-types
                var action = 'Default';
                if (element.attr('data-etracker-action')) {
                    action = element.attr('data-etracker-action');

                } else {
                    if (
                        (location.hostname === this.hostname)
                        || (!this.hostname.length )
                    ) {
                        action = 'page';
                    } else {
                        action = 'url';
                    }
                }

                // track downloads
                if (action === 'file') {

                    if (settings.debug) {
                        console.log('object:' + object, 'category:' + category, 'action:' + action, 'title:' + title);
                    }

                    try {
                        // et_DownloadEvent(eventObject, eventType)
                        // et_UserDefinedEvent('myObject', 'myCategory', 'myAction', 'myType')
                        _etracker.sendEvent(new et_UserDefinedEvent(object, category, action, title));
                    } catch (error) {
                        console.log(error.message);
                    }

                // track external links
                } else if (action === 'url') {

                    if (settings.debug) {
                        console.log('object:' + object, 'category:' + category, 'action:' + action, 'title:' + title);
                    }

                    try {
                        // et_UserDefinedEvent('myObject', 'myCategory', 'myAction', 'myType')
                        _etracker.sendEvent(new et_UserDefinedEvent(object, category, action, title));
                    } catch (error) {
                        console.log(error.message);
                    }

                    // check for internal links
                } else if (action === 'page') {
                    // not relevant
                }

            });
        });


        /*
         * pass options when class instantiated
         */
        this.construct(options);

    }
};


jQuery(document).ready(function () {

    var rkwEtrackerClass = new rkwEtracker({ debug : false});
    rkwEtrackerClass.init(jQuery(document));

    // for ajax
    jQuery(document).on('tx-ajax-api-content-changed', function(event, element) {
        rkwEtrackerClass.init(element);
    });
});

