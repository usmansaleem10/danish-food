/*
 * AIT WordPress Theme
 *
 * Copyright (c) 2012-2014, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */
/* Main Initialization Hook */
jQuery(document).ready(function(){

	"use strict";

	/* menu.js initialization */
	desktopMenu();
	//responsiveMenu();
	/* menu.js initialization */

	/* portfolio-item.js initialization */
	portfolioSingleToggles();
	/* portfolio-item.js initialization */

	/* custom.js initialization */
	renameUiClasses();
	removeUnwantedClasses();

	touchFriendlyHover([
		".header-items:before",
		".site-header-wrap .social-icons:before",
		".main-nav-wrap:before",
		".site-iconmenu:after"
	]);

	initWPGallery();
	initColorbox();
	initRatings();
	initInfieldLabels();
	initSelectBox();

	notificationClose();
	/* custom.js initialization */

	/* Theme Dependent Functions */
	sidebarResponsiveButton();
	iconMenuNavigation();
	/* Theme Dependent Functions */
});

jQuery(window).load(function(){
	leftSidebarEffect();
	footerPositionFix();
	// some elements in sidebar might be loaded after height is calculated and position adjusted
	setTimeout(function(){
		sidebarAndMenuPositionFix();
	}, 1000);
});
/* Main Initialization Hook */

/* Hack Initialization Hook */
jQuery(document).ajaxComplete(function( event, xhr, settings ) {
	// hack for easyreservations form hourly calendar not updating custom selectboxes
	updateSelectboxesOnReservationForm();
});
/* Hack Initialization Hook */

/* Hide WooCommerce cart when other header buttons clicked and vice versa */
jQuery(document).on('touchFriendlyHover_HideOthers', function(){
	jQuery('#ait-woocommerce-cart').css({
		display: 'none',
		opacity: '0'
	});
});
jQuery('#ait-woocommerce-cart-wrapper').hover(function(){
	jQuery(this).parents('.site-header-wrap').find('.hover').removeClass('hover');
});

/* Theme Dependenent Fix Functions */
// Langwitch | Language Dropdown
function fixLanguageMenu(){
	if(isResponsive(640)){
		// only run at 640px-
		jQuery('.language-icons a.current-lang').bind('touchstart MSPointerDown', function(){
			if(jQuery('.language-icons').hasClass('menu-opened')){
				jQuery('.language-icons .language-icons__list').hide();
			} else {
				jQuery('.language-icons .language-icons__list').show();
			}
			jQuery('.language-icons').toggleClass('menu-opened');

			return false;
		});
	}
}
/* Theme Dependenent Fix Function */

function fixWoocommerceActions(){
	// "Returning customer?" form fix
	jQuery('.woocommerce .showlogin').click(function(e){
		e.preventDefault();
		jQuery('.woocommerce form.login').slideDown();
	});
	// "Have a coupon?" form fix
	jQuery('.woocommerce .showcoupon').click(function(e){
		e.preventDefault();
		jQuery('.woocommerce form.checkout_coupon').slideDown();
	});

	var reviewFormHref = jQuery('.woocommerce-tabs #reviews .show_review_form').attr('href');
	var reviewFormHtml = jQuery(reviewFormHref).clone();
	jQuery(reviewFormHref).hide();
	jQuery('.woocommerce-tabs #reviews a.show_review_form').colorbox({html: reviewFormHtml});

	// "Ship to billing address?" fix
	if(jQuery('.woocommerce input#shiptobilling-checkbox').is(':checked')){
		jQuery('.woocommerce .shipping_address').hide();
	} else {
		jQuery('.woocommerce .shipping_address').show();
	}

	jQuery('.woocommerce input#shiptobilling-checkbox').change(function(){
		if(jQuery(this).is(':checked')){
			jQuery('.woocommerce .shipping_address').hide();
		} else {
			jQuery('.woocommerce .shipping_address').show();
		}
	});
}

function leftSidebarEffect(){
	if (!isResponsive(250)) {
		var sidebar = jQuery('#secondary-left');
		var minimizeToggle = jQuery('.elements-sidebar-wrap').find('.minimize-toggle');

		// init on page load
		if (isResponsive(980)) {
			sidebar.addClass("widget-area-minimized");
			sidebar.hide();
		}


		jQuery(window).resize(function(){
			if(isResponsive(980) && !isResponsive(250)){
				sidebar.addClass("widget-area-minimized");
				sidebar.hide();

			} else {
				sidebar.removeClass("widget-area-minimized");
				sidebar.show();
			}
		});

		minimizeToggle.click(function(){
			if(!sidebar.hasClass('widget-area-minimized')){
				sidebar.addClass("widget-area-minimized");
				sidebar.delay(500).queue(function(next){
					jQuery(this).hide();
					next();
				});
			} else {
				sidebar.show().delay(250).queue(function(next){
					sidebar.removeClass("widget-area-minimized");
					sidebar.show();
					next();
				});
			}
		});
	}
}

function footerPositionFix(){
	var footer = jQuery('.footer');
	var windowHalf;
	var siteFooter = jQuery('.site-footer');

	if (!isResponsive(640)) {
		footer.css('bottom', siteFooter.height() + 5 - footer.height());
	}


	setTimeout(function(){
		footer.css('visibility', 'visible');
	}, 1000);


	jQuery(window).resize(function(){
		footer.removeClass('opened');
		if (!isResponsive(640)) {
			footer.css('bottom', siteFooter.height() + 5 - footer.height());
		}
	});


	footer.click(function() {
		if (footer.hasClass('opened')) {
			footer.removeClass('opened');
			if (isResponsive(640)) {
			}
			else {
		    	footer.css('bottom', siteFooter.height() + 5 - footer.height());

			}
		} else {
			footer.addClass('opened');
			if (isResponsive(640)) {
			}
			else {
		    	footer.css('bottom', siteFooter.height());

			}
		}
	});
}

function sidebarAndMenuPositionFix() {
	var sidebar        = jQuery('#secondary-left');
	var menu           = jQuery('.site-header-main');
	var wrap           = jQuery('.site-header-wrap');
	var menuColor      = menu.css('background');
	// var footer         = jQuery('.site-footer');
	var adminBar       = jQuery('#wpadminbar');

	var footerHeight 	= 60;

	var windowHeight   = jQuery(window).height() - footerHeight;
	var documentHeight = jQuery(document).height();
	var sidebarHeight  = sidebar.outerHeight();
	var menuHeight     = menu.height();
	var wrapHeight     = wrap.height();

	setPositions();

	jQuery(window).resize(function() {
		windowHeight = jQuery(window).height() - footerHeight;
		documentHeight = jQuery(document).height();
		sidebarHeight = sidebar.outerHeight();
		menuHeight = menu.height();
		wrapHeight = wrap.height();

		setPositions();
	});

	function setPositions() {
		if (isResponsive(1440)) {
			wrap.css('height', 'auto');
			menu.css('position', 'relative');
		}
		else {
			if (sidebarHeight < windowHeight) {
				sidebar.css('position', 'fixed');
			}
			else {
				sidebar.css('position', 'absolute');
			}

			if (wrapHeight < windowHeight) {
				menu.css('position', 'fixed');
				wrap.css('background', 'none');

			} else {
				menu.css('position', 'absolute');
				wrap.css('background', menuColor);
				wrap.css('height', documentHeight);
			}
		}
	}
}

function updateSelectboxesOnReservationForm(){
	var selectId;
	var oldStyle;

	jQuery('form#easyFrontendFormular select').selectbox('detach');
	jQuery('form#easyFrontendFormular select').selectbox({
		onOpen: function(inst){
			selectId = inst.settings.classHolder+"_"+inst.uid;
			jQuery("#"+selectId).attr('style', 'z-index: 100 !important');
		},
		onClose: function(inst){
			jQuery("#"+selectId).delay(100).queue(function(next){
				jQuery(this).removeAttr("style");
				next();
			});
		}
	});
}

function sidebarResponsiveButton(){
	// need to set default state from administration -> some option
	jQuery('.header-widget-button').on('click', function(){
		var $sidebar = jQuery('#header-secondary-left');
		$sidebar.toggleClass('sidebar-shown');
	});
}

function iconMenuNavigation(){
	var $container = jQuery('.site-iconmenu .iconmenu-container');
	var $navigation = $container.find('.item-navigation');

	var $itemsContainer = $container.find('ul.iconmenu-items');
	var $items = $itemsContainer.find('li.iconmenu-box');

	$navigation.find('.item-navigation-prev').on('click', function(e){
		e.preventDefault();
		if(!isResponsive(980) && isResponsive(1280)){
			var item_count = $items.length;
			var current_index = $itemsContainer.find('li.iconmenu-box-active').index();
			var new_index = current_index <= 0 ? item_count-1 : current_index-1;

			$items.removeClass("iconmenu-box-active");
			$itemsContainer.find('li:eq('+(new_index)+')').addClass('iconmenu-box-active');
		}
	});

	$navigation.find('.item-navigation-next').on('click', function(e){
		e.preventDefault();
		if(!isResponsive(980) && isResponsive(1280)){
			var item_count = $items.length;
			var current_index = $itemsContainer.find('li.iconmenu-box-active').index();
			var new_index = current_index >= (item_count-1) ? 0 : current_index+1;

			$items.removeClass("iconmenu-box-active");
			$itemsContainer.find('li:eq('+(new_index)+')').addClass('iconmenu-box-active');
		}
	});
}