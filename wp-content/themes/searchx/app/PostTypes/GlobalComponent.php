<?php

/**
 * Global Components Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */

declare(strict_types=1);

namespace App\PostTypes;

class GlobalComponent extends AbstractPostType
{

	/**
	 * Post Type Args
	 *
	 * @var string
	 */
	protected $args = [
		'menu_icon'           => 'dashicons-welcome-widgets-menus',
		'supports'            => ['title', 'editor', 'custom-fields'],
		'has_archive'         => false,
		'exclude_from_search' => true,
		'rewrite'             => false,
	];

	/**
	 * Post Type Taxonomies
	 *
	 * @var array
	 */
	protected $taxonomies = [
		// 'testimonial-category' => []
	];

	// /**
	//  * Init
	//  *
	//  * @since 0.7.2
	//  *
	//  * @return void
	//  */
	// public function init()
	// {
	// 	add_filter('manage_global_components_posts_columns', [$this, 'global_components_columns']);
	// 	add_action('manage_global_components_posts_custom_column', [$this, 'global_components_custom_columns']);
	// }


	// /**
	//  * Add featured, and reviewer columns to testimonial edit page
	//  *
	//  * @param array $columns
	//  *
	//  * @since 0.7.2
	//  *
	//  * @return array
	//  */
	// public function global_components_columns(array $columns): array
	// {
	// 	$date = $columns['date'] ?? null;
	// 	unset($columns['date']);

	// 	$columns['featured'] = 'Image';
	// 	$columns['reviewer'] = 'Reviewer';

	// 	if ($date) {
	// 		$columns['date'] = $date;
	// 	}
	// 	return $columns;
	// }


	// /**
	//  * Output testimonial custom columns
	//  *
	//  * @since 0.7.2
	//  *
	//  * @param string $column
	//  */
	// public function global_components_custom_columns(string $column): void
	// {
	// 	if ($column === 'featured') {
	// 		the_post_thumbnail([75, 75]);
	// 	} else if ($column === 'reviewer') {
	// 		the_field('global_components_author');
	// 	}
	// }


	// /**
	//  * Add Advanced Custom Field Local Group
	//  *
	//  * @since 0.7.4
	//  *
	//  * @return void
	//  */
	// public function acf_add_local_field_group()
	// {
	// 	acf_add_local_field_group(array(
	// 		'key' => 'group_213456uyrthgefr',
	// 		'title' => 'Global Component',
	// 		'fields' => array(
	// 			array(
	// 				'key' => 'field_324g35tbvfef',
	// 				'label' => 'Testimonial - Author',
	// 				'name' => 'global_components_author',
	// 				'type' => 'text',
	// 				'instructions' => '',
	// 				'required' => 0,
	// 				'conditional_logic' => 0,
	// 				'wrapper' => array(
	// 					'width' => '',
	// 					'class' => '',
	// 					'id' => '',
	// 				),
	// 				'default_value' => '',
	// 				'placeholder' => '',
	// 				'prepend' => '',
	// 				'append' => '',
	// 				'maxlength' => '',
	// 			),
	// 		),
	// 		'location' => array(
	// 			array(
	// 				array(
	// 					'param' => 'post_type',
	// 					'operator' => '==',
	// 					'value' => 'testimonial',
	// 				),
	// 			),
	// 		),
	// 		'menu_order' => 0,
	// 		'position' => 'normal',
	// 		'style' => 'default',
	// 		'label_placement' => 'top',
	// 		'instruction_placement' => 'label',
	// 		'hide_on_screen' => array(
	// 			1 => 'author',
	// 		),
	// 		'active' => 1,
	// 		'description' => '',
	// 	));
	// }
}
