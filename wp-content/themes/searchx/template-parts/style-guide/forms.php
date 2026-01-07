<article id="forms__style">
	<div class="sg-example">
		<?php
			if( function_exists( 'gravity_form' ) ) {
				gravity_form( 1, true, true, true, false, false, 1 );
			}
			else {
				echo '<p>The Gravity Forms plugin is not installed.</p>';
			}
		?>
	</div>
</article>

<article id="forms__search">
	<h4>Search</h4>
	<div class="sg-example">
		<?php blennder_search_form(); ?>
	</div>
</article>
