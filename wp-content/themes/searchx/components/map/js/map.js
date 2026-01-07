/************
 *
 * Map Module
 *
 ***********/

/* global google */

(($) => {

	$(function() {
		var infowindows = [];
		var activeInfoWindow;

		/**
		 * initMap
		 *
		 * Renders a Google Map onto the selected jQuery element
		 *
		 * @date    22/10/19
		 * @since   5.8.6
		 *
		 * @param   jQuery $el The jQuery element.
		 * @return  object The map instance.
		 */
		function initMap( $el ) {

			// Create generic map.
			var mapArgs = {
				center             : new google.maps.LatLng(39.1065585,-76.9047943),
				zoom               : $el.data('zoom') || 9,
				mapTypeId          : google.maps.MapTypeId.ROADMAP,
				minZoom            : 0,
				maxZoom            : 15,
				scrollwheel        : false,
				zoomControl        : true,
				streetViewControl  : false,
				overviewMapControl : false,
				draggable          : true,
				disableDefaultUI   : true
			};
			var gmap = new google.maps.Map( $el[0], mapArgs );

			// Add markers.
			gmap.markers = [];

			var map_markers;

			let id = $el.attr('data-id' );
			if( null != id ) {
				let name = 'map_markers_' + id;
				map_markers = window[ name ];
			}

			map_markers.forEach(function(item){
				initMarker( item, gmap );
			});

			// Center map based on markers.
			centerMap( gmap );

			google.maps.event.addListener(gmap, 'click', function() {
				infowindows.forEach(function(item){
					item.close();
				});
			});

			// Return map instance.
			return gmap;
		}

		/**
		 * initMarker
		 *
		 * Creates a marker for the given jQuery element and map.
		 *
		 * @date    22/10/19
		 * @since   5.8.6
		 *
		 * @param   jQuery $el The jQuery element.
		 * @param   object The map instance.
		 * @return  object The marker instance.
		 */
		function initMarker( markerData, map ) {

			// Get position from marker.
			var latLng = {
				lat: parseFloat( markerData.lat ),
				lng: parseFloat( markerData.lng )
			};

			// Create marker instance.
			var marker = new google.maps.Marker({
				map: map,
				position : latLng,
				title: markerData.title,
				animation: google.maps.Animation.DROP,
			});

			var contentString = '<div class="px-3 pt-3 pb-2">';

			contentString += '<h5 class="h5">'+markerData.title+'</h5>';
			if( null != markerData.content )
				contentString += '<p>'+markerData.content+'</p>';

			if( null != markerData.address && '' != markerData.address )
				contentString += '<p><i class="fas fa-map-marker-alt me-2 text-primary"></i>'+markerData.address+'</p>';

			if( null != markerData.phone && '' != markerData.phone )
				contentString += '<p><i class="fas fa-phone me-2 text-primary"></i>'+markerData.phone+'</p>';

			if( null != markerData.url )
				contentString += '<a class="btn btn-text" href="'+markerData.url+'">See Details</a>';

			contentString += '</div>';

			var infowindow = new google.maps.InfoWindow({
				content: contentString,
			});

			infowindows.push( infowindow );

			// Append to reference for later use.
			map.markers.push( marker );

			google.maps.event.addListener(marker, 'click', function() {
				if (activeInfoWindow) {
					activeInfoWindow.close();
				}
				infowindow.open(map, marker);
				activeInfoWindow = infowindow;
			});
		}


		/**
		 * centerMap
		 *
		 * Centers the map showing all markers in view.
		 *
		 * @date    22/10/19
		 * @since   5.8.6
		 *
		 * @param   object The map instance.
		 * @return  void
		 */
		function centerMap( map ) {

			// Create map boundaries from all map markers.
			var bounds = new google.maps.LatLngBounds();
			map.markers.forEach(function( marker ){
				bounds.extend({
					lat: marker.position.lat(),
					lng: marker.position.lng()
				});
			});

			// Case: Single marker.
			if( map.markers.length == 1 ){
				map.setCenter( bounds.getCenter() );

			// Case: Multiple markers.
			} else{
				map.fitBounds( bounds );
			}
		}

		// Render maps on page load.
		$('.locations__map').each(function(){
			initMap( $(this) );
		});
	});

})(jQuery);
