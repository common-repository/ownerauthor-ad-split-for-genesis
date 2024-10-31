<?php
/**
 * Adds the metabox on posts to control display of content ads
 *
 * @since      1.0.0
 * @package    owner-author-ad-split
 * @subpackage owner-author-ad-split/admin
 * @author     Josh Mallard <josh@limecuda.com>
 */

namespace LimeCuda\Owner_Author_Ad_Split\Admin\Post_Metabox;

class Metabox {

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
	 * Adds the metabox
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function metabox() {

		if( ! class_exists( 'Genesis_Admin_Boxes' ) )
			return;

		add_meta_box( 'gb_post_ad_control', __( 'Automatic Ad Blocks', 'owner-author-ad-split' ), array( $this, 'metabox_options' ), 'post', 'side', 'high' );
	}

	/**
	 * Adds the metabox option controls
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function metabox_options( $post ) {

		global $current_screen;

		$hide_global = genesis_get_option( 'hide_content_ads', 'lc_ad_split_settings_field' );
		$hide_post = get_post_meta( $post->ID, 'gb_adsense_hide_content_ads', true );

		$hide_selected = false;
		$show_selected = false;

		// If global default hide & Add screen
		if( $hide_global == 1 && $hide_post != 'show-ads' || $hide_post == 'hide-ads' ) {
			$hide_selected = true;
		} else {
			$show_selected = true;
		}

		?>

		<table class="form-table">
			<tbody>

				<tr valign="top">
					<td>
						<p>
							<label for="gb_adsense_hide_content_ads">
							<select name="gb_adsense_hide_content_ads" id="gb_adsense_hide_content_ads" default="">
								<option value="show-ads" <?php echo ( $show_selected ) ? 'selected' : ''; ?>><?php _e( 'Show Automatic Ads on Post', 'owner-author-ad-split' ); ?></option>
								<option value="hide-ads" <?php echo ( $hide_selected ) ? 'selected' : ''; ?>><?php _e( 'Hide Automatic Ads on Post', 'owner-author-ad-split' ); ?></option>
							</select>
							</label>
						</p>
					</td>
				</tr>

				<tr valign="top">
					<td>
						<p class="description">
							<?php
								_e( 'This option determines whether the automatic above and below content ads will display on this post', 'owner-author-ad-split' );
							?>
						</p>
					</td>
				</tr>

				<tr valign="top">
					<td>
						<p>
							<?php $this->update_ad_codes(); ?>
						</p>
					</td>
				</tr>

				<?php wp_nonce_field( 'aoas_post_save', 'aoas_post_save_nonce' ); ?>

			</tbody>
		</table>

	<?php
	}

	/**
	 * Save the metabox options
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function save_post( $post_id ) {

		if( !current_user_can( 'edit_posts' ) )
			return;

		// Is the nonce set?
		if( ! isset( $_POST['aoas_post_save_nonce'] ) )
			return;

		// Is it right?
		if( ! wp_verify_nonce( $_POST['aoas_post_save_nonce'], 'aoas_post_save' ) )
			return;

		$hide = $_POST['gb_adsense_hide_content_ads'];

		update_post_meta( $post_id, 'gb_adsense_hide_content_ads', $hide );
	}

	/**
	 * Prompt users that can save their profile ads to include them
	 * if they haven't been added yet
	 *
	 * @since     1.1.0
	 * @access    public
	 */
	public function update_ad_codes() {

		if( ! current_user_can( 'unfiltered_html' ) )
			return;

		$profile_link = get_edit_user_link( get_current_user_id() );

		echo '<a href="' . $profile_link . '#aoas-profile-settings" target="_blank">' . __( 'Update Your Ad Codes', 'owner-author-ad-split') . '</a>';

	}

}