

"use strict";

/* Custom Classes Funtions */
function renameUiClasses(){
	var classes = [
		"ui-accordion",
		"ui-accordion-header", "ui-accordion-header-active", "ui-corner-top", "ui-accordion-icons",
		"ui-accordion-header-icon", "ui-icon", "ui-icon-triangle-1-s", "ui-icon-triangle-1-e", "ui-accordion-content-active", "ui-accordion-content",
		"ui-tabs", "ui-widget", "ui-tabs-vertical", "ui-tabs-horizontal",
		"ui-tabs-nav", "ui-helper-reset", "ui-helper-clearfix", "ui-widget-header", "ui-corner-all",
		/*"ui-state-default",*/ "ui-tabs-active", /*"ui-state-active",*/ "ui-corner-left", /*"ui-tabs-anchor",*/
		"ui-tabs-panel", "ui-widget-content", "ui-corner-bottom", "ui-corner-all"
	];
	jQuery.each(classes, function(k, v){
		var nClass = v.replace("ui-", "ait-");
		jQuery(".elm-toggles-main ."+v).removeClass(v).addClass(nClass);
	});
}

function removeUnwantedClasses(){
	if(isResponsive(1024)){
		if(jQuery("body").hasClass("preloading-enabled")){
			jQuery("body").removeClass("preloading-enabled");
		}
	}
}
/* Custom Classes Funtions */

function touchFriendlyHover(elms){
	var basicClass = ".ait-toggle-hover";

	elms = typeof elms !== 'undefined' ? elms : [];
	elms.push(basicClass);

	var action = {
		click: function(elm, isPseudo) {
			jQuery(elm).click(function() {
				var $element = action.createElm(jQuery(this), isPseudo);
				if(!$element.hasClass('hover')) {
					action.hideOthers(elms);
				}
				$element.toggleClass('hover');
			});
		},
		hover: function(elm, isPseudo) {
			var $element = action.createElm(jQuery(elm), isPseudo);

			$element.mouseenter(function() {
				jQuery(this).addClass('hover');
			});

			$element.mouseleave(function() {
				jQuery(this).removeClass('hover');
			});
		},
		hideOthers: function(elms) {
			jQuery.each(elms, function(i, elm) {
				var isPseudo = action.checkForPseudo(elm);
				var elm = action.removePseudo(elm, isPseudo);
				var $element = action.createElm(jQuery(elm), isPseudo);
				$element.removeClass('hover');
			});
			jQuery(document).trigger('touchFriendlyHover_HideOthers');
		},
		checkForPseudo: function(elm) {
			var bool = false;
			if(elm.indexOf(':before') !== -1 || elm.indexOf(':after') !== -1 ) {
				bool = true;
			}
			return bool;
		},
		removePseudo: function(elm, bool) {
			if(bool) {
				elm = elm.replace(':before','').replace(':after','');
			}
			return elm;
		},
		createElm: function($obj, bool) {
			return $obj = bool ? $obj : $obj.parent();
		}
	}

	jQuery.each(elms, function(i, elm){
		var isPseudo = action.checkForPseudo(elm);
		var elm = action.removePseudo(elm, isPseudo);

		if(!jQuery(elm).hasClass('ait-click-only') && !isResponsive(640)) {
			action.hover(elm, isPseudo);
		}
		action.click(elm, isPseudo);
	});
}

/* Plugins Init Functions */
function initWPGallery(){
	jQuery(".gallery").each(function(){
		var rel = jQuery(this).attr('id');
		jQuery(this).find('.gallery-item').each(function(){
			var link = jQuery(this).find('a');
			link.attr('rel', rel);
			link.colorbox({rel: rel});
		});
	});
}

function initColorbox(){
	jQuery('a:not(.disable-default-colorbox)[href*=".jpg"],a:not(.disable-default-colorbox)[href*=".jpeg"],a:not(.disable-default-colorbox)[href*=".png"],a:not(.disable-default-colorbox)[href*=".gif"]').each(function(){
	//jQuery('a[href*=".jpg"],a[href*=".jpeg"],a[href*=".png"],a[href*=".gif"]').each(function(){
		if(typeof jQuery(this).attr('data-rel') === "undefined" || jQuery(this).attr('data-rel') === false || typeof jQuery(this).attr('rel') === "undefined" || jQuery(this).attr('rel') === false){
			if(!isMobile() || jQuery(this).parent().hasClass("woocommerce-product-gallery__image")){
				jQuery(this).colorbox({
					maxWidth: "95%",
					maxHeight: "95%",
					onOpen: true,
					onClosed: true,
				});
			} else {
				jQuery(this).click(function(e){e.preventDefault();})
				/*jQuery(this).colorbox({
					maxWidth: "150%",
					maxHeight: "150%",
					onOpen: true,
					onClosed: true,
				});*/
			}
		}
	});
}

function initRatings(){
	jQuery('.item-rating').raty({
		font		: true,
		readOnly	: true,
		halfShow	: true,
		starHalf	: 'fa-star-half-o',
		starOff		: 'fa-star-o',
		starOn		: 'fa-star',
		score		: function(){
			return ((5*jQuery(this).attr('data-rating'))/100);
		}
	});
}

function initInfieldLabels(){
	jQuery('.comment-form label').inFieldLabels();
}

function initSelectBox(){
	jQuery('.selectbox').selectbox();

	var selectId;
	var oldStyle;
	if(jQuery('body').hasClass('woocommerce-page')){
		// wocommerce pages
		// get all selects except the ones in the content
		jQuery('select:not(.default-disabled)').not('#content select:not(.default-disabled)').selectbox({
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

		jQuery('#content .woocommerce-tabs select#rating').selectbox({
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
	} else {
		// all other pages
		jQuery('select:not(.default-disabled)').selectbox({
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
}

function notificationClose(){
	jQuery('.ait-sc-notification a.close').click(function(e){
		e.preventDefault();
		jQuery(this).parent().fadeOut('slow');
	});
}
/* Plugins Init Functions */