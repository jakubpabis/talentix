<?php
/**
 * The 404 template file.
 */

get_header();

$theme = get_has_theme_option( '404_text_theme', 'dark' );
?>

<main id="main" role="main">

	<section class="component error-404 component--<?php echo $theme; ?>">

		<?php acf_image( 'background_image', 'full', [ 'class' => 'object-fit-cover' ], [ 'background_image' => get_has_theme_option( '404_background_image', '' ) ] ); ?>

		<div class="container">

			<div class="row error-404__row">

				<div class="col error-404__col">

					<h1><?php echo get_has_theme_option( '404_header', "Looks like you're lost" ); ?></h1>

					<?php echo wpautop( get_has_theme_option( '404_subheading', "We can’t seem to find the page that you’re looking for." ) ); ?>

					<?php
					$link = [
						'url' => home_url(),
						'title' => 'Return Home',
						'target' => '_self',
					];
					acf_single_link( $link, [ 'class' => "btn btn-outline-$theme" ] );
					?>

				</div><!-- .col -->

			</div><!-- .row -->

		</div><!-- .container -->

	</section>

</main> <!-- #main -->

<?php get_footer(); ?>
