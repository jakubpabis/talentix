<?php
/**
 * Template Name: Video Inline
 */
?>
<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<div class="video-player__video">

			<?php
				$source = get_has_field( 'source', 'video' );
				include component_part_path( "video-player-$source" );
			?>

		</div>

	</div>

</div>
