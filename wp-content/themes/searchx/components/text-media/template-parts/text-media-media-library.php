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

	<a href="#" class="video-pause-btn" tabindex="0">

		<div class="video-btn-wrap">

			<i class="fas fa-play"></i>

		</div>

		<span class="visually-hidden">Pause Video</span>

	</a>

	<video

		<?php if ($poster['type'] === 'video') : ?>

		class="video-poster video-track"
		playsinline
		muted
		loop
		data-scroll-play="<?php echo $video_autoplay; ?>"

		<?php elseif ($poster['type'] === 'image') : ?>

		poster="<?php echo get_has_field('url', '', $poster); ?>"

		<?php endif; ?>

		src="<?php echo get_has_field('url', '', $video); ?>"
		data-src="<?php echo get_has_field('url', '', $video); ?>"
		class="video-track"
		data-scroll-play="<?php echo $video_autoplay; ?>">

	</video>

	<?php if ($poster['type'] === 'video') : ?>

		<video
			playsinline
			style="display: none;"
			src="<?php echo get_has_field('url', '', $video); ?>"
			data-src="<?php echo get_has_field('url', '', $video); ?>"
			data-scroll-play="<?php echo $video_autoplay; ?>"
			class="video-track">

		</video>

	<?php endif; ?>

<?php elseif ($video_behavior === 'modal') : ?>

	<a data-fancybox="text-media-<?php echo uniqid(); ?>" data-src="<?php echo get_has_field('url', '', $video); ?>" href="#" class="video-pause-btn" tabindex="0">

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
			muted
			loop
			src="<?php echo $poster['url']; ?>"
			data-src="<?php echo $poster['url']; ?>"
			data-scroll-play="<?php echo $video_autoplay; ?>"
			class="video-track">

		</video>

	<?php endif; ?>

<?php endif; ?>