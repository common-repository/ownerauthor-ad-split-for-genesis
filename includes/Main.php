<?php
/**
 * Main plugin file which puts everything into action and makes
 * the world turn
 *
 * @since      1.0.0
 * @package    owner-author-ad-split
 * @subpackage owner-author-ad-split/includes
 * @author     Josh Mallard <josh@limecuda.com>
 */

namespace LimeCuda\Owner_Author_Ad_Split;

class Owner_Author_Ad_Split {

 	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * The variable name is used as the text domain when internationalizing strings
	 * of text.
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'owner_author_ad_split';

	/**
	 * Load the necessary files and hook everything up to the appropriate
	 * locations
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {

		// Add the shortcodes.
		add_action( 'after_setup_theme', array( $this, 'ad_shortcodes' ) );

		// Place the content ads.
		add_action( 'after_setup_theme', array( $this, 'place_content_ads' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

	}

	/**
	 * Place the ads
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function place_content_ads() {

		require plugin_dir_path( __FILE__ ) . 'Content_Ads.php';

		add_action( 'genesis_entry_content', array( $this, 'before_content_ad' ), apply_filters( 'above_content_ad_priority', 0 ) );
		add_action( 'genesis_entry_content', array( $this, 'below_content_ad' ), apply_filters( 'below_content_ad_priority', 10 ) );

	}

	/**
	 * Add the shortcode
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function ad_shortcodes() {

		require plugin_dir_path( __FILE__ ) . 'Shortcode.php';

		add_shortcode( 'gb_ad_above', array( $this, 'before_content_ad_shortcode' ) );
		add_shortcode( 'gb_ad', array( Shortcode\Shortcode::instance(), 'build_shortcode' ) );
		add_shortcode( 'gb_ad_below', array( $this, 'below_content_ad_shortcode' ) );

	}

	/**
	 * Enqueue scripts
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function scripts() {

		// If we're not running genesis, don't do anything.
		if ( ! function_exists( 'genesis' ) )
			return;

		$hide_global = genesis_get_option( 'hide_content_ads', 'lc_ad_split_settings_field' );
		$hide_post = get_post_meta( get_the_ID(), 'gb_adsense_hide_content_ads', true );

		$ads = array (
			'owner_above_ad'      => Content_Ads\Ads::instance()->owner_above_ad,
			'owner_above_weight'  => Content_Ads\Ads::instance()->owner_above_weight,
			'owner_below_ad'      => Content_Ads\Ads::instance()->owner_below_ad,
			'owner_below_weight'  => Content_Ads\Ads::instance()->owner_below_weight,
			'author_above_ad'     => Content_Ads\Ads::instance()->author_above_ad,
			'author_below_ad'     => Content_Ads\Ads::instance()->author_below_ad,
		);

		// Register the shortcode ad js only when shortcode is used.
		wp_register_script( 'gb-adsense-shortcode-split', plugin_dir_url( __FILE__ ) . '../resources/js/gb-adsense-shortcode-split.js', array(), $this->version, false );

		wp_enqueue_script( 'gb-adsense-split', plugin_dir_url( __FILE__ ) . '../resources/js/gb-adsense-split.js', array(), $this->version, false );

		// Localize the script with all of our ads and weights.
		wp_localize_script( 'gb-adsense-split', 'LC_CONTENT_ADS', $ads );
		wp_localize_script( 'gb-adsense-shortcode-split', 'LC_CONTENT_ADS', $ads );

	}

	/**
	 * Before content ad
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function before_content_ad(){

		// If we're not running genesis, don't do anything
		if( ! function_exists( 'genesis' ) )
			return;

		$hide_global = genesis_get_option( 'hide_content_ads', 'lc_ad_split_settings_field' );
		$hide_post = get_post_meta( get_the_ID(), 'gb_adsense_hide_content_ads', true );

		// If global default hide & Add screen
		if( $hide_global == 1 && $hide_post != 'show-ads' || $hide_post == 'hide-ads' )
			return;

		echo '<div class="gb-ad gb-above-ad"><script>document.write(aboveAdsSplit[Math.floor(Math.random()*10)]);</script></div>';
	}

	/**
	 * The shortcode for displaying the above content ad
	 *
	 * @since     1.2.0
	 * @access    public
	 */
	public function before_content_ad_shortcode() {

		$hide_post = get_post_meta( get_the_ID(), 'gb_adsense_hide_content_ads', true );

		// Don't output the shortcode if the post is set to show the default ads.
		if ( 'show-ads' === $hide_post )
			return;

		ob_start();

			wp_enqueue_script( 'gb-adsense-split' );

			echo '<div class="gb-ad gb-above-ad"><script>document.write(aboveAdsSplit[Math.floor(Math.random()*10)]);</script></div>';

		return ob_get_clean();

	}

	/**
	 * Below content ad
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function below_content_ad(){

		// If we're not running genesis, don't do anything
		if( ! function_exists( 'genesis' ) )
			return;

		$hide_global = genesis_get_option( 'hide_content_ads', 'lc_ad_split_settings_field' );
		$hide_post = get_post_meta( get_the_ID(), 'gb_adsense_hide_content_ads', true );

		// If global default hide & Add screen
		if( $hide_global == 1 && $hide_post != 'show-ads' || $hide_post == 'hide-ads' )
			return;

		echo '<div class="gb-ad gb-below-ad"><script>document.write(belowAdsSplit[Math.floor(Math.random()*10)]);</script></div>';
	}

	/**
	 * The shortcode for displaying the below content ad
	 *
	 * @since     1.2.0
	 * @access    public
	 */
	public function below_content_ad_shortcode() {

		$hide_post = get_post_meta( get_the_ID(), 'gb_adsense_hide_content_ads', true );

		// Don't output the shortcode if the post is set to show the default ads.
		if ( 'show-ads' === $hide_post )
			return;

		ob_start();

			wp_enqueue_script( 'gb-adsense-split' );

			echo '<div class="gb-ad gb-below-ad"><script>document.write(belowAdsSplit[Math.floor(Math.random()*10)]);</script></div>';

		return ob_get_clean();

	}
}
