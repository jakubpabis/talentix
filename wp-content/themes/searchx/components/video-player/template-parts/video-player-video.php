<?php $poster = get_has_field('video_player_poster', '');
$video_autoplay = get_has_field('video_autoplay', false); ?>

<a href="#" class="video-pause-btn re-position" tabindex="0">

	<div class="video-btn-wrap">

		<i class="fas fa-pause"></i>

	</div>

	<span class="visually-hidden">Pause Video</span>

</a>

<video

	<?php if ($poster['type'] === 'video') : ?>

	class="video-poster video-track"


	<?php elseif ($poster['type'] === 'image') : ?>

	poster="<?php echo get_has_field('url', '', $poster); ?>"

	<?php endif; ?>

	muted
	loop
	playsinline
	preload="auto"
	src="<?php echo get_has_field('video', ''); ?>"
	data-src="<?php echo get_has_field('video', ''); ?>"
	class="video-track"
	data-scroll-play="<?php echo $video_autoplay; ?>">

</video>

<?php if ($poster['type'] === 'video') : ?>

	<video
		playsinline
		style="display: none;"
		data-src="<?php echo get_has_field('video', ''); ?>"
		src="<?php echo get_has_field('video', ''); ?>"
		data-scroll-play="<?php echo $video_autoplay; ?>"
		class="video-track">

	</video>

<?php endif; ?>