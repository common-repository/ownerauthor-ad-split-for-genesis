<?php
/**
 * Generates the adsense ads to be placed at the beginning and
 * end of blog posts
 *
 * @since      1.0.0
 * @package    owner-author-ad-split
 * @subpackage owner-author-ad-split/includes
 * @author     Josh Mallard <josh@limecuda.com>
 */

namespace LimeCuda\Owner_Author_Ad_Split\Content_Ads;

class Ads {

	/**
	 * Owner Above Ad
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $owner_above_ad;

	/**
	 * Owner Below Ad
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $owner_below_ad;

	/**
	 * Author Above Ad
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $author_above_ad;

	/**
	 * Author Below Ad
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $author_below_ad;

	/**
	 * Owner Above Ad weight
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $owner_above_weight;

	/**
	 * Owner Below weight
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string
	 */
	public $owner_below_weight;

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
	 * Set the ad variables
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function __construct() {

		$this->owner_adsense_codes();
		$this->author_adsense_codes();
		$this->owner_weights();
	}

	/**
	 * Set the owner weight for displaying ads
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function owner_weights() {

		$above_weight = genesis_get_option( 'owner_above_weight', 'lc_ad_split_settings_field' );
		$below_weight = genesis_get_option( 'owner_below_weight', 'lc_ad_split_settings_field' );

		if( isset( $above_weight ) ) {
			$this->owner_above_weight = $above_weight;
		}

		if( isset( $below_weight ) ) {
			$this->owner_below_weight = $below_weight;
		}


	}

	/**
	 * Set the owner content ads
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function owner_adsense_codes() {

		$owner_above = genesis_get_option( 'owner_above_adsense_code', 'lc_ad_split_settings_field' );
		$owner_below = genesis_get_option( 'owner_below_adsense_code', 'lc_ad_split_settings_field' );

		if( isset( $owner_above ) ) {
			$this->owner_above_ad = $owner_above;
		}

		if( isset( $owner_below ) ) {
			$this->owner_below_ad = $owner_below;
		}

	}

	/**
	 * Set the author content ads
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function author_adsense_codes() {

		global $post;

		$author = $post->post_author;

		$author_above = get_user_meta( $author, 'author_above_adsense_code', true );
		$author_below = get_user_meta( $author, 'author_below_adsense_code', true );

		if( isset( $author_above ) ) {
			$this->author_above_ad = $author_above;
		}

		if( isset( $author_below ) ) {
			$this->author_below_ad = $author_below;
		}
	}
}