<video id="hero__video-media" class="object-fit-cover" <?php component_video_attributes(); ?>>
	<?php if( $src = get_has_field( 'background_video_desktop_mp4', false ) ) : ?>
	<source src="<?php echo $src[ 'url' ]; ?>" type="video/mp4" >
	<?php endif; ?>
	<?php if( $src = get_has_field( 'background_video_desktop_webm', false ) ) : ?>
	<source src="<?php echo $src[ 'url' ]; ?>" type="video/webm" >
	<?php endif; ?>
	<?php acf_image( 'background_video_poster' ); ?>
	Your browser does not support the video tag.
</video>

<a href="#" class="hero__video-pause video-pause-btn">

	<div class="video-btn-wrap">

		<i class="fas fa-pause"></i>

	</div>

	<span class="visually-hidden">Pause Video</span>

</a>
