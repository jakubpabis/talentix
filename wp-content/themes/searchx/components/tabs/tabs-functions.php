<?php
declare( strict_types = 1 );

/*
* echo tabs nav link attributes
*/
function tabs_nav_link_attr( $config ) {
	$tab_slug = sanitize_title( $config[ 'tab' ][ 'tab_label' ] . ' ' . $config[ 'id' ] );
	$attr = [
		'class'          => [ 'tabs__nav-link', 'nav-link' ],
		'data-bs-target' => sprintf( '#%1$s-%2$s', $tab_slug, $config[ 'count' ] ),
		'data-bs-toggle' => 'tab',
	];
	if( 0 === $config[ 'count' ] ) {
		$attr[ 'class' ][] = 'active';
	}
	html_atts($attr);
}

/*
* echo tabs panel attributes
*/
function tabs_panel_attr( $config ) {
	$panel_slug = sanitize_title( $config[ 'panel' ][ 'tab_label' ] . ' ' . $config[ 'id' ] );
	$attr = [
		'class'       => [ 'tab-pane', 'fade' ],
		'id'          => sprintf( '%1$s-%2$s', $panel_slug, $config[ 'count' ] ),
		'role'        => 'tabpanel',
	];
	if( 0 === $config[ 'count' ] ) {
		$attr[ 'class' ][] = 'show active';
	}
	html_atts($attr);
}
