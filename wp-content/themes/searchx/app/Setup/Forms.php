<?php

declare(strict_types=1);

namespace App\Setup;

use DomDocument;
use GF_Field;

class Forms
{
	/**
	 * Initialization
	 * This method should be run from functions.php
	 */
	public static function init()
	{
		// Add hidden option to GF form labels
		add_filter('gform_enable_field_label_visibility_settings', '__return_true');

		// Disable the confirmation anchor functionality that will automatically scroll the page to the confirmation text or validation message
		add_filter('gform_confirmation_anchor', '__return_true');

		/*
		 * Gravity forms v2.5+ introduces a new form builder with new styles.
		 * This allows the basic.css to load for all the grid builder stuff
		 * without adding on GF's opinionated theme.css design styles.
		 */
		add_filter('gform_disable_form_theme_css', '__return_true');

		//add_filter( 'gform_field_content', [ __CLASS__, 'gform_field_content' ], 10, 2 );
	}

	/**
	 * Add Gravity Forms classes
	 *
	 * This method adds classes the Gravity Forms input elements to make styling of  easier.
	 *
	 * @since 2.7.8
	 *
	 * @param string $field_content
	 * @param \GF_Field $field
	 *
	 * @return string
	 */
	// public static function gform_field_content( string $field_content, GF_Field $field ) {
	// 	$dom = new DomDocument();
	// 	$dom->loadHTML( $field_content );

	// 	$inputs = $dom->getElementsByTagName( 'input' );
	// 	foreach( $inputs as $input ) {
	// 		$class = $input->getAttribute( 'class' );
	// 		$class .= ' gfield_input';
	// 		$type = $input->getAttribute( 'type' );
	// 		if( $type ) {
	// 			$class .= "_$type";
	// 		}
	// 		$class = trim( $class );
	// 		$input->setAttribute( 'class', $class );
	// 	}

	// 	$textareas = $dom->getElementsByTagName( 'textarea' );
	// 	foreach( $textareas as $textarea ) {
	// 		$class = $textarea->getAttribute( 'class' );
	// 		$class .= ' gfield_textarea';
	// 		$class = trim( $class );
	// 		$textarea->setAttribute( 'class', $class );
	// 	}

	// 	return $dom->saveHtml();

	// }

}
