<?php
/**
 * Must use file for wp-env.
 * 
 * @package Equalize Digital 
 */

$mu_plugins_to_protect = array(
	'accessibility-checker/accessibility-checker.php',
	'accessibility-checker-pro/accessibility-checker-pro.php',
	'accessibility-checker-audit-history/accessibility-checker-audit-history.php',
);

/**
 * Prevent accidental deletion of the plugin source folders.
 */ 
add_filter(
	'plugin_action_links',
	function ( $actions, $plugin_file, $plugin_data, $context ) use ( $mu_plugins_to_protect ) {
		foreach ( $mu_plugins_to_protect as $plugin ) {
			if ( $plugin == $plugin_file ) {
				unset( $actions['delete'] );
			}
		}

		return $actions;
	},
	10,
	4
);

/**
 * Prevent modifying the update check for plugins. 
 */
add_filter(
	'site_transient_update_plugins', 
	function ( $value ) use ( $mu_plugins_to_protect ) {

		foreach ( $mu_plugins_to_protect as $plugin ) {
			if ( isset( $value->response[ $plugin ] ) ) {
				unset( $value->response[ $plugin ] );
			}
		}

		return $value;
	},
	10,
	1
);

/**
 * Disable welcome guides in Gutenberg. - Needed for testing.
 * see: https://epiph.yt/en/blog/2022/disable-welcome-guide-in-gutenberg-even-in-widgets/
 */
function my_disable_welcome_guides() {
	wp_add_inline_script(
		'wp-data',
		"window.onload = function() {
	const selectPost = wp.data.select( 'core/edit-post' );
	const selectPreferences = wp.data.select( 'core/preferences' );
	const isFullscreenMode = selectPost.isFeatureActive( 'fullscreenMode' );
	const isWelcomeGuidePost = selectPost.isFeatureActive( 'welcomeGuide' );
	const isWelcomeGuideWidget = selectPreferences.get( 'core/edit-widgets', 'welcomeGuide' );
	
	if ( isWelcomeGuideWidget ) {
		wp.data.dispatch( 'core/preferences' ).toggle( 'core/edit-widgets', 'welcomeGuide' );
	}
	
	if ( isFullscreenMode ) {
		wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' );
	}
	
	if ( isWelcomeGuidePost ) {
		wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'welcomeGuide' );
	}
}" 
	);
}

add_action( 'enqueue_block_editor_assets', 'my_disable_welcome_guides', 20 );
add_action( 'wp_enqueue_scripts', 'my_disable_welcome_guides' );
