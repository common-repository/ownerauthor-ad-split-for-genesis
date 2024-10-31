<?php
/**
 * Adds the user profile setting to add the author's adsense ID
 *
 * @since      1.0.0
 * @package    owner-author-ad-split
 * @subpackage owner-author-ad-split/admin
 * @author     Josh Mallard <josh@limecuda.com>
 */

namespace LimeCuda\Owner_Author_Ad_Split\Admin\User_Profile_Setting;

class Profile_Setting {

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
	 * The adsense ID field
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public static function user_meta( $user ) { ?>

		<h3 id="aoas-profile-settings"><?php echo __( 'Owner/Author Ad Split', 'owner_author_ad_split' ); ?></h3>

		<table class="form-table">
			<tr>
				<th><label for="author_above_adsense_code"><?php echo __( 'Above-Content Ad Code', 'owner_author_ad_split' ); ?></label>
				<td><textarea name="author_above_adsense_code" cols="78" rows="8"><?php echo esc_attr(get_the_author_meta( 'author_above_adsense_code', $user->ID )); ?></textarea></td>
			</tr>

			<tr>
				<th><label for="author_shortcode_adsense_code"><?php echo __( 'Content Ad Code', 'owner_author_ad_split' ); ?></label>
				<td><textarea name="author_shortcode_adsense_code" cols="78" rows="8"><?php echo esc_attr(get_the_author_meta( 'author_shortcode_adsense_code', $user->ID )); ?></textarea></td>
			</tr>

			<tr>
				<th><label for="author_below_adsense_code"><?php echo __( 'Below-Content Ad Code', 'owner_author_ad_split' ); ?></label>
				<td><textarea name="author_below_adsense_code" cols="78" rows="8"><?php echo esc_attr(get_the_author_meta( 'author_below_adsense_code', $user->ID )); ?></textarea></td>
			</tr>

			<?php wp_nonce_field( 'aoas_user_save', 'aoas_user_save_nonce' ); ?>
		</table>

	<?php
	}

	/**
	 * Save meta
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function save_meta( $user_id ) {

		// Does user have access
		if( ! current_user_can( 'edit_user', $user_id ) )
			return;

		// Can user save unfiltered html?
		if( ! current_user_can( 'unfiltered_html' ) )
			return;

		// Is the nonce set?
		if( ! isset( $_POST['aoas_user_save_nonce'] ) )
			return;

		// Is it right?
		if( ! wp_verify_nonce( $_POST['aoas_user_save_nonce'], 'aoas_user_save' ) )
			return;

		// Get our content to be saved
		$above = $_POST['author_above_adsense_code'];
		$below = $_POST['author_below_adsense_code'];
		$shortcode = $_POST['author_shortcode_adsense_code'];


		update_user_meta( $user_id, 'author_above_adsense_code', $above );
		update_user_meta( $user_id, 'author_below_adsense_code', $below );
		update_user_meta( $user_id, 'author_shortcode_adsense_code', $shortcode );
	}
}
