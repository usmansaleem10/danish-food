<?php

/*
 * AIT WordPress Theme Framework
 *
 * Copyright (c) 2014, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 *
 * inspired by:
 *
 * Contributors: blazersix, bradyvercher
 * Tags: image widget, widget, media, media manager, sidebar, image, photo, picture
 * Requires at least: 3.5
 * Tested up to: 4.0
 * Stable tag: trunk
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Banner Widget Class
 */
class AitBannerWidget extends WP_Widget
{

	function __construct()
	{
		$widget_ops = array('classname' => 'widget_banner', 'description' => __( 'Display banner for current page', 'ait-admin') );
		parent::__construct('ait-baner', __('Theme &rarr; Banner', 'ait-admin'), $widget_ops);

		add_action( 'sidebar_admin_setup', array( $this, 'enqueue_admin_assets' ) );
	}



	function enqueue_admin_assets() {
		wp_enqueue_media();
		wp_enqueue_script('admin-simple-image-widget-js', aitPaths()->url->js . "/admin-simple-image-widget.js", array(), '', true);
	}


	function widget( $args, $instance ) {
		extract( $args );
		$result = '';

		/* WIDGET CONTENT :: START */
		$result .= $before_widget;

		$title = '';
		$description = '';
		$link = '';
		$bannerContent = '';

		if(isset($instance['title'])){
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		}

		if(isset($instance['image_id'])){
			$image = wp_get_attachment_image( $instance['image_id'] );
		}

		if(isset($instance['text'])){
			$description = $instance['text'];
		}

		$bannerContent .= '<div class="banner-inner ';
		if ($instance['link'] == get_permalink()) {
			$bannerContent .= 'current_page_item ';
		}
		$bannerContent .= '">'.$image;
		$bannerContent .= '<div class="banner-description">';
		$bannerContent .= $before_title . $title . '</div>'; //end of widget-title
		$bannerContent .= $description;
		$bannerContent .= '</div></div>';


		if(isset($instance['link']) && !empty($instance['link'])){
			$link .= '<a ';
			$link .= 'href="';
			$link .= $instance['link'].'" ';
			if ($instance['new_window']) {
				$link .= 'target="_blank" ';
			}
			$link .= '>' . $bannerContent . '</a>';
		} else {
			$link .= $bannerContent;
		}

		$result .= $link;
		$result .= '</div></div>';
		/* WIDGET CONTENT :: END */
		echo($result);
	}



	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image_id'] = absint($new_instance['image_id']);
		$instance['new_window'] = isset($new_instance['new_window']);
		$instance['link'] = esc_url_raw($new_instance['link']);
		$instance['text'] = strip_tags($new_instance['text']);

		return $instance;
	}



	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'alt' => '',
			'image' => '',
			'image_id' => '',
			'link'  => '',
			'title' => '',
			'new_window' => '',
			'text'  => '',
        ) );


		$instance['image_id'] = absint( $instance['image_id'] );
		$instance['title']    = wp_strip_all_tags( $instance['title'] );

		$button_class = array( 'button', 'button-hero', 'simple-image-widget-control-choose' );
		$image_id     = $instance['image_id'];

    ?>

		<p class="simple-image-widget-control<?php echo ( $image_id ) ? ' has-image' : ''; ?>"
			data-title="<?php esc_attr_e( 'Choose an Image', 'simple-image-widget' ); ?>"
			data-update-text="<?php esc_attr_e( 'Update Image', 'simple-image-widget' ); ?>"
			data-target=".image-id">
			<?php
			if ( $image_id ) {
				echo wp_get_attachment_image( $image_id, 'medium', false );
				unset( $button_class[ array_search( 'button-hero', $button_class ) ] );
			}
			?>
			<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>" value="<?php echo absint( $image_id ); ?>" class="image-id simple-image-widget-control-target">
			<a href="#" class="<?php echo esc_attr( join( ' ', $button_class ) ); ?>"><?php _e( 'Select Image', 'ait-admin' ); ?></a>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ait-admin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e( 'Link:', 'ait-admin' ); ?></label>
			<input class="widefat" name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>"  type="text" value="<?php echo $instance['link']; ?>" >
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'new_window' ); ?>">
				<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'new_window' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>" <?php checked( $instance['new_window'] ); ?>>
				<?php _e( 'Open in new window?', 'ait-admin' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'simple-image-widget' ); ?></label>
			<textarea name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" rows="4" class="widefat"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>


<?php
	}

}
