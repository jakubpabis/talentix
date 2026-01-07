<?php

use App\Gutenberg\Setup;

$poster = get_has_field('text_media_video_poster', '');
$video = get_has_field('text_media_video', '');
$video_behavior = get_has_field('video_behavior', 'modal');
$video_autoplay = get_has_field('video_autoplay', false);
$attributes = [];
if (0 === Setup::get_block_number()) {
	$attributes['loading'] = 'lazy';
	$attributes['fetchpriority'] = 'low';
}
?>

<?php if ($video_behavior === 'inline') : ?>

	<?php echo wp_oembed_get(get_has_field('embed', '')); ?>

<?php elseif ($video_behavior === 'modal') : ?>

	<a data-fancybox="text-media-<?php echo uniqid(); ?>" data-fancybox-type="iframe" data-src="<?php echo get_has_field('embed', ''); ?>" href="#" class="text-media__video-pause video-pause-btn" tabindex="0">

		<div class="video-btn-wrap">

			<i class="fas fa-play"></i>

		</div>

		<span class="visually-hidden">Pause Video</span>

	</a>

	<?php if ($poster['type'] === 'image') :

		acf_image('text_media_video_poster', 'post-thumbnail', $attributes);

	elseif ($poster['type'] === 'video') : ?>

		<video
			playsinline
			autoplay
			muted
			loop
			src="<?php echo $poster['url']; ?>"
			data-src="<?php echo $poster['url']; ?>"
			class="video-track"
			data-scroll-play="<?php echo $video_autoplay; ?>">

		</video>

	<?php endif; ?>

<?php endif; ?>