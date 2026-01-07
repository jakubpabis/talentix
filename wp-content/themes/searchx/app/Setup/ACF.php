<?php
declare( strict_types = 1 );
namespace App\Setup;

/**
 * ACF Class
 */
class ACF {

	/**
	 * Add actions and filters for ACF functionality.
	 *
	 * @since 0.7.0
	 */
	public function init() {
		add_action( 'acf/input/admin_footer', [ $this, 'acf_color_picker_options' ] );
	}


	/**
	 * Filter the ACF color picker options.
	 *
	 * @since 0.7.0
	 */
	public function acf_color_picker_options() {
		$theme_json = get_stylesheet_directory() . '/theme.json';
		$theme_json = file_get_contents( $theme_json );
		$theme_json = json_decode( $theme_json );
		$palette = [];
		foreach( $theme_json->settings->color->palette as $color ) {
			$color = $color->color ?? null;
			if( $color ) {
				$palette[] = $color;
			}
		}
		$palette = array_values( array_unique( $palette ) );
	?>
		<script type="text/javascript">
			(function($) {
				// JS here
				acf.add_filter('color_picker_args', function( args, $field ){

					// do something to args
					args.palettes = <?php echo json_encode($palette); ?>;

					// return
					return args;

				});

			})(jQuery);
		</script>
	<?php

	}

}
