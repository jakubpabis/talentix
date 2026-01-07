<?php

/**
 * Testimonial Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */

declare(strict_types=1);

namespace App\PostTypes;

class Testimonials extends AbstractPostType
{

	/**
	 * Post Type Plural Title
	 *
	 * @var string
	 */
	protected $plural_title = 'Testimonials';

	/**
	 * Post Type Args
	 *
	 * @var string
	 */
	protected $args = [
		'menu_icon'           => 'dashicons-star-filled',
		'supports'            => ['title', 'editor', 'thumbnail', 'custom-fields'],
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
		'testimonial-type' => []
	];

	/**
	 * Init
	 *
	 * @since 0.7.2
	 *
	 * @return void
	 */
	public function init()
	{
		add_filter('manage_testimonial_posts_columns', [$this, 'testimonial_columns']);
		add_action('manage_testimonial_posts_custom_column', [$this, 'testimonial_custom_columns']);
	}


	/**
	 * Add featured, and reviewer columns to testimonial edit page
	 *
	 * @param array $columns
	 *
	 * @since 0.7.2
	 *
	 * @return array
	 */
	public function testimonial_columns(array $columns): array
	{
		$date = $columns['date'] ?? null;
		unset($columns['date']);

		$columns['featured'] = 'Image';
		$columns['reviewer'] = 'Reviewer';

		if ($date) {
			$columns['date'] = $date;
		}
		return $columns;
	}


	/**
	 * Output testimonial custom columns
	 *
	 * @since 0.7.2
	 *
	 * @param string $column
	 */
	public function testimonial_custom_columns(string $column): void
	{
		if ($column === 'featured') {
			the_post_thumbnail([75, 75]);
		} else if ($column === 'reviewer') {
			the_field('testimonial_author');
		}
	}


	/**
	 * Add Advanced Custom Field Local Group
	 *
	 * @since 0.7.4
	 *
	 * @return void
	 */
	public function acf_add_local_field_group()
	{
		acf_add_local_field_group(array(
			'key' => 'group_5bce5b6537c65',
			'title' => 'Testimonial',
			'fields' => array(
				array(
					'key' => 'field_5bce5cc0f5db0',
					'label' => 'Testimonial - Author',
					'name' => 'testimonial_author',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'testimonials',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => array(
				1 => 'author',
			),
			'active' => 1,
			'description' => '',
		));
	}
}
