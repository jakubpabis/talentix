<?php
/**
 * Template Name: Map Locations
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template( 'template-parts/component-heading.php' ); ?>

</div>

<div <?php component_row(); ?>>

	<div <?php component_col(); ?>>

		<?php

			$google_api_key = get_has_theme_option( 'google_maps_api_key', '' );
			wp_enqueue_script( 'google-maps', "https://maps.googleapis.com/maps/api/js?key=$google_api_key", [], false, true );

			$location_query = component_query();
			$locations = $location_query->posts ?? [];

			$marker_data = [];
			foreach( $locations as $location ) {
				$latLng = get_field( 'latitude_longitude', $location );
				$latLng = preg_split( "/[\s,]+/", $latLng );
				$marker_data[] = [
					'title'   => get_the_title( $location ),
					'content' => get_the_content( null, false, $location ),
					'url'     => get_the_permalink( $location ),
					'lat'     => $latLng[0],
					'lng'     => $latLng[1],
					'phone'   => get_field( 'phone', $location->ID ),
					'address' => get_field( 'address', $location->ID ),
				];
			}
			$id = uniqid();

		?>
		<div id="map-<?php echo $id; ?>" class="locations__map" data-zoom="9" data-id="<?php echo $id; ?>"></div>

		<script type="text/javascript">var map_markers_<?php echo $id; ?> = <?php echo json_encode($marker_data); ?>;</script>

	</div>

</div>
