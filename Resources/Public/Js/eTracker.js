/**
 * Script for tracking links with eTracker. Needs UserFunc for Typolinks!
 *  Dependency: eTracker Version 3.0
 *
 * @package RKW_RkwBasics
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Steffen Kroggel, RKW Kompetenzzentrum
 * @licence http://www.gnu.org/copyleft/gpl.htm GNU General Public License, version 2 or later
 * @version 1.0.0
 */
jQuery(document).ready(function () {

    jQuery('a').each(function() {

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
            if (action == 'file') {

                // et_DownloadEvent(eventObject, eventType)
                // et_UserDefinedEvent('myObject', 'myCategory', 'myAction', 'myType')
                _etracker.sendEvent(new et_UserDefinedEvent(object, category, action, title));

                // console.log('object:' + object, 'category:' + category, 'action:' + action, 'title:' + title);

            // track external links
            } else if (action == 'url') {

                // et_UserDefinedEvent('myObject', 'myCategory', 'myAction', 'myType')
                _etracker.sendEvent(new et_UserDefinedEvent(object, category, action, title));

                // console.log('object:' + object, 'category:' + category, 'action:' + action, 'title:' + title);

            // check for internal links
            } else if (action == 'page') {

                // not relevant
            }

        });
    });
});

