<?php
declare( strict_types = 1 );
namespace App\Setup;

class Admin
{
	/**
	 * Initialization
	 * This method should be run from functions.php
	 */
	public static function init()
	{
		add_action( 'login_enqueue_scripts', [ __CLASS__, 'admin_login_logo' ] );
		add_filter( 'login_headerurl', [ __CLASS__, 'login_head_url' ] );
	}

	/**
	 * Changes URL of the Login Logo from wordpress.com to our site.
	 */
	public static function login_head_url( $url ) {
		return home_url( '/' );
	}

	/**
	 * Changes out the logo for the WordPress Login screen
	 */
	public static function admin_login_logo() {
		$login_form_width = 320;

		$login_logo = get_has_theme_option( 'login_logo', [] );

		if ( ! empty( $login_logo ) ) {
			$logo_url = get_has_field( 'url', '', $login_logo );
			$logo_id  = get_has_field( 'id', 0, $login_logo );
			$sizes = wp_get_attachment_metadata( $logo_id );
		} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo_url =  wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ) , 'full' );
			$sizes = wp_get_attachment_metadata( get_theme_mod( 'custom_logo' ) );
		} else {
			return;
		}

		// If the chosen image is larger than the login form area, scale it down proportionally to fit
		if( $sizes['width'] > $login_form_width ){
			$ratio = $sizes['width'] / $sizes['height'];
			$new_height = $login_form_width / $ratio;
			$sizes['width'] = $login_form_width;
			$sizes['height'] = $new_height;
		}

		$bg_type = get_has_theme_option( 'login_bg_type', 'none' );
		if( 'color' === $bg_type ) {
			$login_bg_color = get_has_theme_option( 'login_bg_color', '' );
		}
		elseif( 'image' === $bg_type ) {
			$bg_image = get_has_theme_option( 'login_bg_image', [] );
			$login_bg_image = get_has_field( 'url', '', $bg_image );
		}

		ob_start( );
		?>
		<style type="text/css">
			#login h1 a, .login h1 a {
				background-image: url(<?php echo $logo_url; ?>);
				height: <?php echo $sizes['height'] . 'px'; ?>;
				width: <?php echo $sizes['width'] . 'px'; ?>;
				background-size: <?php echo $sizes['width'] . 'px ' . $sizes['height'] . 'px'; ?>;
				background-repeat: no-repeat;
				background-position: center;
			}
			<?php if( isset( $login_bg_color ) || isset( $login_bg_image ) ): ?>
			.login {
				<?php if( isset( $login_bg_color ) ): ?>
				background-color: <?php echo $login_bg_color; ?>;
				<?php elseif( isset( $login_bg_image ) ): ?>
				background-image: url(<?php echo $login_bg_image; ?>);
				background-size: cover;
				background-position: center;
				background-repeat: no-repeat;
				<?php endif; ?>
			}
			<?php endif; ?>
		</style>
		<?php echo ob_get_clean();
	}
}
