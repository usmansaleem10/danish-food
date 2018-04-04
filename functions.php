<?php


// === Loads AIT WordPress Framework ================================
require_once get_template_directory() . '/ait-theme/@framework/load.php';


// === Mandatory WordPress Standard functionality ===================

if(!isset($content_width)) $content_width = 1200;



// === Run the theme ===============================================

$themeConfiguration = include aitPath('config', '/@theme-configuration.php');

AitTheme::run($themeConfiguration);


// === Custom settings ==============================================

if ( aitIsPluginActive( "woocommerce" ) ) {
	
	add_filter('loop_shop_columns', create_function('', 'return 3;'));

	// Display 6 products per page
	//add_filter('loop_shop_per_page', create_function( '$cols', 'return 6;' ), 20);

	// Add image sizes for woocommerce 3.3+
	add_theme_support( 'woocommerce', array(
	    'thumbnail_image_width'         => 500,
	    'gallery_thumbnail_image_width' => 180,
	    'single_image_width'            => 750,
	) );

	// Change number of related products on product page
	// Set your own value for 'posts_per_page'
	add_filter( 'woocommerce_output_related_products_args', 'ait_related_products_args' );
	function ait_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // 3 related products
		$args['columns'] = 3; // arranged in 3 columns
		return $args;
	}

	// Disable woocommerce default styles
	if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	} else {
		define( 'WOOCOMMERCE_USE_CSS', false );
	}
}


// === Custom filters, actions for framework overrides ==============

require_once aitPath('includes', '/custom-functions.php');
