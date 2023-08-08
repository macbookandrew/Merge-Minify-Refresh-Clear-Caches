<?php
/**
 * Main class
 *
 * @package Merge_Minify_Refresh_Clear_Caches
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Clears popular caches when Merge + Minify + Refresh cache is updated
 *
 * @package Merge_Minify_Refresh_Clear_Caches
 */
class Merge_Minify_Refresh_Clear_Caches {
	/**
	 * Load everything
	 *
	 * @private
	 */
	function __construct() {
		add_action( 'merge_minify_refresh_done', array( $this, 'clear_caches' ) );

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_assets' ) );

		add_action( 'wp_ajax_mmrcc_purge_caches', array( $this, 'clear_caches' ) );
	}

	/**
	 * Add options page to menu
	 */
	public function admin_menu() {
		add_options_page( 'Merge + Minify + Refresh Force Clear Caches', 'MMR Force Clear Caches', 'manage_options', 'merge-minify-refresh-clear-caches', array( $this, 'options_page' ) );
	}

	/**
	 * Register and enqueue backend assets
	 *
	 * @param string $hook Admin page GET parameter.
	 */
	public function backend_assets( $hook ) {
		wp_register_script( 'mmr-cc-backend', plugin_dir_url( __FILE__ ) . 'assets/js/backend.js', array( 'jquery' ) );

		if ( 'settings_page_merge-minify-refresh-clear-caches' === $hook ) {
			wp_enqueue_script( 'mmr-cc-backend' );
		}
	}

	/**
	 * Display options page
	 */
	public function options_page() {
		echo '<h2>Force Clear Caches</h2>
		<p>Force-clear all available caches here:</p>
		<form method="post" action="' . admin_url( 'options-general.php?page=merge-minify-refresh-clear-caches' ) . '">
			<input type="submit" class="button button-primary" name="clear_caches" value="Clear Caches" />
		</form>
		<div class="results">' . ( isset( $_POST['clear_caches'] ) ? $this->clear_caches() : '' ) . '</div>';
	}

	/**
	 * Clear all available caches
	 */
	public function clear_caches() {
		$response = '<p>Cleared these caches:</p>
		<ul>';

		// Clear all WP Super Cache files.
		if ( is_plugin_active( 'wp-super-cache/wp-cache.php' ) ) {
			$response .= '<li>WP Super Cache</li>';
			$response .= wp_cache_clear_cache();
		}

		// Clear all CloudFlare cache files.
		// Listed after WP plugins since they should be cleared first.
		if ( is_plugin_active( 'cloudflare/cloudflare.php' ) ) {
			$response        .= '<li>CloudFlare</li>';
			$cloudflare_hooks = new \CF\WordPress\Hooks();
			$response        .= $cloudflare_hooks->purgeCacheEverything();
		}

		// Clear entire RunCloud Hub cache.
		if ( is_plugin_active( 'runcloud-hub/runcloud-hub.php' ) ) {
			$response .= '<li>RunCloud Hub</li>';
			$response .= wp_cache_flush() ? 'Cleared cached' : 'Failed to clear cache';
		}

		$response .= '</ul>
		<p>Don&rsquo;t see a cache you expected? Submit a request&mdash;or better yet, a pull request&mdash;<a href="https://github.com/macbookandrew/Merge-Minify-Refresh-Clear-Caches">on GitHub</a>.</p>';

		if ( isset( $_POST ) ) {
			return $response;
		}
	}
}

new Merge_Minify_Refresh_Clear_Caches();
