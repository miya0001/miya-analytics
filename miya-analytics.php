<?php
/**
 * Plugin Name:     Miya Analytics
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     miya-analytics
 * Domain Path:     /languages
 * Version:         nightly
 *
 * @package         Miya_Analytics
 */

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

register_activation_hook( __FILE__, 'activation_callback' );

function activation_callback() {
	add_rewrite_endpoint( 'analytics', EP_ROOT );
	flush_rewrite_rules();
}

class Miya_Analytics
{
	public function __construct()
	{
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
	}

	public function init()
	{
		$plugin_slug = plugin_basename( __FILE__ ); // e.g. `hello/hello.php`.
		$gh_user = 'miya0001';                      // The user name of GitHub.
		$gh_repo = 'miya-analytics';                // The repository name of your plugin.

		// Activate automatic update.
		new Miya\WP\GH_Auto_Updater( $plugin_slug, $gh_user, $gh_repo );

		add_rewrite_endpoint( 'analytics', EP_ROOT );
	}

	public function wp_enqueue_scripts()
	{
		if ( is_user_logged_in() ) {
			wp_enqueue_script(
				'google-analytics',
				home_url( '/analytics/' ),
				array(),
				date( 'Ymd' ),
				false
			);
		}
	}

	public function template_redirect()
	{
		global $wp_query;

		if ( isset( $wp_query->query['analytics'] ) ) {
			header( 'Content-Type: application/javascript' );
			echo self::get_code();
			exit;
		}
	}

	public static function get_code()
	{
		/**
		 * Filters and activates the Tracking ID of the Google Analytics.
		 *
		 * @param string $tracking_id The Tracking ID.
		 */
		$tracking_id = apply_filters( 'miya_analytics_tracking_id', '' );

		$code =<<<EOL
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', '%s', 'auto');
ga('send', 'pageview');
EOL;

		if ( $tracking_id ) {
			return sprintf( $code, $tracking_id );
		}
	}
}

$miya_analytics = new Miya_Analytics();
