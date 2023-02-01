(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function () {

		function be_gdpr_trigger_magnific_popup() {
			if ($('.mfp-popup').length > 0) {
				$('.mfp-popup').magnificPopup({
					type: 'inline',
					midClick: true,
					closeBtnInside: true,
				});
			}
		}

		window.be_gdpr_magnific_popup_retrigger = be_gdpr_trigger_magnific_popup;
		be_gdpr_trigger_magnific_popup();

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			}
			return null;
		}
		function createCookie(name, value) {

			var date = new Date();
			date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000)); //a year
			var expires = "; expires=" + date.toGMTString();

			document.cookie = name + "=" + value + expires + "; path=/";
		}
		var checkBoxes = $('.be-gdpr-switch-input');
		var privacyPref = readCookie('be_gdpr_privacy') || [];
		for (var count in checkBoxes) {
			if (checkBoxes.hasOwnProperty(count)) {
				var singleCheckBox = checkBoxes[count];
				if (privacyPref.indexOf(singleCheckBox.value) >= 0) {
					singleCheckBox.setAttribute('checked', true);
				}
			}
		}

		function hasConcern(concern) {
			if (window.hasOwnProperty('beGdprConcerns')) {
				if (!window.beGdprConcerns.hasOwnProperty(concern)) {
					return true;
				}
			}
			if (privacyPref.indexOf(concern) >= 0) {
				return true;
			}
			return false;
		}

		window.triggerBeGdpr = function triggerBeGdpr (){

			var itemsWithConcern = $('.be-gdpr-consent-required');
			itemsWithConcern.each(function (i, e) {
				var gdprData = $(this).attr('data-gdpr-atts');

				if (isJSON(gdprData)) {
					gdprData = JSON.parse(gdprData);

					var concern = gdprData.concern,
						classesToRemove = [],
						attsToRemove = [],
						classesToAdd = [],
						attsToAdd = {};
					if( !hasConcern( concern ) ) {
						
						if (typeof gdprData.remove === 'object') {
							classesToRemove = gdprData.remove.class ? gdprData.remove.class : [];
							attsToRemove = gdprData.remove.atts ? gdprData.remove.atts : [];
						}

						if (typeof gdprData.add === 'object') {
							classesToAdd = gdprData.add.class ? gdprData.add.class : [];
							attsToAdd = gdprData.add.atts ? gdprData.add.atts : {};
						}

						for (var item in classesToRemove) {
							$(this).removeClass(classesToRemove[item]);
						}

						for (var item in attsToRemove) {
							$(this).removeAttr(attsToRemove[item]);
						}

						for (var item in classesToAdd) {
							$(this).addClass(classesToAdd[item]);
						}

						for (var item in attsToAdd) {
							$(this).attr( item, attsToAdd[item] );
						}
						be_gdpr_trigger_magnific_popup();
					}
				}
			});

			var itemsToReplaceContent = $('.be-gdpr-consent-replace');
			itemsToReplaceContent.each(function (i, e) {
				var concern = $(this).data('gdpr-concern'),
					replaceTarget = $(this).data('gdpr-replace');

				if (hasConcern(concern)) {
					$(this).siblings('.be-gdpr-consent-message ').remove();
				} else {
					if( replaceTarget === 'parent' ){
						var tempChildren = $(this).children(),
							gdprWrapper = $(this).siblings('.be-gdpr-consent-message ');
					
						$(this).wrap( gdprWrapper );
						$(this).parent().siblings('.be-gdpr-consent-message ').remove();
						tempChildren.unwrap();
					}else{
						var replacingContent = $(this).siblings('.be-gdpr-consent-message ');
						replacingContent.css( 'display', 'block' );
						if( replacingContent.length ){
							$(this).replaceWith(replacingContent);
						}
					}

				}
			});

		}

		triggerBeGdpr();

		function gdprSaveBtnClick(e) {
			var tempCookies = []
			var checkBoxes = $(e.target).closest('.be-gdpr-modal').find('.be-gdpr-switch-input');
			for (var count in checkBoxes) {
				var singleCheckBox = checkBoxes[count];
				if (singleCheckBox.checked) {
					tempCookies.push(singleCheckBox.value)
				}
			}
			createCookie('be_gdpr_privacy', "", -1);
			createCookie('be_gdpr_privacy', JSON.stringify(tempCookies));
			window.location.reload();
		}
		window.gdprSaveBtnClick = gdprSaveBtnClick;

		if (readCookie('be_gdpr_cookie_accept') !== '1') {
			$('.be-gdpr-cookie-notice-bar').css('bottom', '0');
		}

		$('.be-gdpr-cookie-notice-button').click(function () {
			$('.be-gdpr-cookie-notice-bar').css('bottom', '-100%');
			createCookie('be_gdpr_cookie_accept', '1');
		});

		function isJSON(str) {
			if (!str || typeof str !== 'string') return false;
			str = str.replace(/\\./g, '@').replace(/"[^"\\\n\r]*"/g, '');
			return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(str);
		}
	});
})(jQuery);
