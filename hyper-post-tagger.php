<?php
/**
 * Plugin Name: Hourly Post Tagger
 * Plugin URI: https://hyperionstudios.com.au/hyperio-post-tagger
 * Description: An hourly Post Tagging with tweet tag
 * Version: 1.0
 * Author: Hyperion Studios Digital Solutions
 * Author URI: https://hyperionstudios.com.au
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

register_activation_hook(__FILE__, 'hyperion_plugin_activated');

function hyperion_plugin_activated() {
	if (! wp_next_scheduled ( 'hyperion_tag_post' )) {
		wp_schedule_event(time(), 'hourly', 'hyperion_tag_post');
	}
}

add_action('hyperion_tag_post', 'hyperion_tag_post_now');

function hyperion_tag_post_now() {

	$args = array(
		'numberposts' => 1,
		'post_status' => 'publish',
	);
	$recent_posts = wp_get_recent_posts( $args , OBJECT );
	foreach ( $recent_posts as $recent_post ) {
		wp_set_post_tags( $recent_post->ID, 'tweet', true );
	}
	wp_mail( 'admin@hyperionstudios.com.au' , 'Tagged' , 'tagged' );

}