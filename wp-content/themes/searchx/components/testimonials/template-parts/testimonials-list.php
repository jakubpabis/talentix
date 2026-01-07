<?php while( $the_query->have_posts() ): $the_query->the_post(); ?>

	<?php include component_part_path( 'testimonial' ); ?>

<?php endwhile; ?>
