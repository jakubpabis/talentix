<?php

/**
 * Template Name: Video Modal
 */
?>

<?php
$video_autoplay = get_has_field('video_autoplay', false);
if (!empty(get_has_field('embed', ''))) {

	$video_type = get_has_field('embed', '');
} elseif (!empty(get_has_field('video', ''))) {

	$video_type = get_has_field('video', '');
}
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<div class="video-player__video">

			<a data-fancybox="video-player-<?php echo uniqid(); ?>" data-fancybox-type="iframe" data-src="<?php echo $video_type; ?>" href="#" class="video-pause-btn" tabindex="0">

				<div class="video-btn-wrap">

					<i class="fas fa-play"></i>

				</div>

				<span class="visually-hidden">Pause Video</span>

			</a>

			<?php

			$poster = get_has_field('video_player_poster', []);

			if (isset($poster['type']) && 'video' === $poster['type']) : ?>

				<video
					playsinline
					autoplay
					muted
					preload
					loop
					width="100%"
					src="<?php echo $poster['url']; ?>">

				</video>

			<?php

			elseif (isset($poster['type']) && 'image' === $poster['type']) :

				acf_image('video_player_poster', 'full');

			endif;

			?>

		</div>

	</div>

</div>