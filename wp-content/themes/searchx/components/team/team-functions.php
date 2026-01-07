<?php
declare( strict_types = 1 );

function team_link_atts( string $modal_id, string $classes = '' ) : void {

	$link_atts = [
		'href' => get_the_permalink(),
		'title' => get_the_title(),
		'class' => $classes,
	];

	if( 'modal' === get_has_field( 'team_show_bio_type', false ) ) {
		$link_atts[ 'role' ] = 'button';
		$link_atts[ 'data-bs-toggle' ] = 'modal';
		$link_atts[ 'data-bs-target' ] = "#$modal_id";
		$link_atts[ 'href' ] = '#';
	}

	html_atts( $link_atts );
}
