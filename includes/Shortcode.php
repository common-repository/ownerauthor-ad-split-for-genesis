<?php
/**
 * Builds the shortcode for displaying ads in posts
 *
 * @since      1.0.0
 * @package    owner-author-ad-split
 * @subpackage owner-author-ad-split/includes
 * @author     Josh Mallard <josh@limecuda.com>
 */

namespace LimeCuda\Owner_Author_Ad_Split\Shortcode;

class Shortcode {

	/**
	 * Owner Shortcode Ad
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $owner_shortcode_ad;

	/**
	 * Author Shortcode Ad
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $author_shortcode_ad;

	/**
	 * Owner Shortcode Ad weight
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $owner_shortcode_weight;

	/**
	 * Instance of this class
	 *
	 * @since     1.0.0
	 */
	protected static $instance;

	/**
	 * Used for getting an instance of this class
	 *
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function __construct() {

		$this->owner_weight();
		$this->owner_adsense_codes();
	}

	/**
	 * Shortcode build
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function build_shortcode( $atts ) {

		ob_start();

		global $post;

		if( empty( $post ) )
			return;

		$author = $post->post_author;
		$author_shortcode = get_user_meta( $author, 'author_shortcode_adsense_code', true );

		if( isset( $author_shortcode ) ) {
			$this->author_shortcode_ad = $author_shortcode;
		}

		// Localize the script with all of our ads and weights
		wp_localize_script( 'gb-adsense-shortcode-split', 'LC_SHORTCODE_ADS', array(
			'owner_shortcode_ad'      => $this->owner_shortcode_ad,
			'owner_shortcode_weight'  => $this->owner_shortcode_weight,
			'author_shortcode_ad'     => $this->author_shortcode_ad
		) );

		wp_print_scripts( 'gb-adsense-shortcode-split' );

		echo '<div class="gb-ad gb-shortcode-ad"><script>document.write(shortcodeAdsSplit[Math.floor(Math.random()*10)]);</script></div>';

		$shortcode_ad = ob_get_clean();

		return $shortcode_ad;
	}

	/**
	 * Set the owner weight for shortcode ad
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function owner_weight() {

		if( ! function_exists( 'genesis_get_option' ) )
			return;

		$owner_weight = genesis_get_option( 'owner_shortcode_weight', 'lc_ad_split_settings_field' );

		if( isset( $owner_weight ) ) {
			$this->owner_shortcode_weight = $owner_weight;
		}

	}

	/**
	 * Set the owner shortcode ad
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function owner_adsense_codes() {

		if( ! function_exists( 'genesis_get_option' ) )
			return;

		$owner_shortcode = genesis_get_option( 'owner_shortcode_adsense_code', 'lc_ad_split_settings_field' );

		if( isset( $owner_shortcode ) ) {
			$this->owner_shortcode_ad = $owner_shortcode;
		}

	}
}