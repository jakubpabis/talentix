<div class="text-media__video">

	<?php
		$source = get_has_field( 'source', 'media-library' );
		include component_part_path( "text-media-$source" );
	?>

</div>
