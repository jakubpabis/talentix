<?php

/**
 * Job Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */

declare(strict_types=1);

namespace App\PostTypes;

class Jobs extends AbstractPostType
{
	const PRIMARY_TAXONOMY = 'job-category';

	/**
	 * Post Type Plural Title
	 *
	 * @var string
	 */
	protected $plural_title = 'Jobs';

	/**
	 * Post Type Args
	 *
	 * @var array
	 */
	protected $args = [
		'menu_position'       => 1,
		'menu_icon'           => 'dashicons-media-document',
		'supports'            => array('title', 'editor', 'excerpt', 'custom-fields'),
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'hierarchical'        => false,
		'capability_type'     => 'post',
	];

	protected $taxonomies = [
		'job-category' => [],
		'job-type' => [],
		'job-location' => [],
	];

	// public function init()
	// {
	// 	add_filter('manage_job_posts_columns', [__CLASS__, 'job_columns']);
	// 	add_filter('manage_job_posts_custom_column', [__CLASS__, 'job_custom_column']);
	// }


	/**
	 * Add Advanced Custom Field Local Group
	 *
	 * @since 0.7.4
	 *
	 * @return null
	 */
	public function acf_add_local_field_group()
	{
		acf_add_local_field_group(array(
			'key' => 'group_5df3521a1dbd9',
			'title' => 'Jobs',
			'fields' => array(
				array(
					'key' => 'field_5df352248d8f3',
					'label' => 'Salary min',
					'name' => 'salary_min',
					'aria-label' => '',
					'type' => 'number',
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
					'min' => '',
					'max' => '',
					'step' => '',
				),
				array(
					'key' => 'field_5df3525e8d8f4',
					'label' => 'Salary max',
					'name' => 'salary_max',
					'aria-label' => '',
					'type' => 'number',
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
					'min' => '',
					'max' => '',
					'step' => '',
				),
				array(
					'key' => 'field_5df352818d8f5',
					'label' => 'Location',
					'name' => 'location',
					'aria-label' => '',
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


				array(
					'key' => 'field_5df352ac8d8f8',
					'label' => 'Meta title',
					'name' => 'meta_title',
					'aria-label' => '',
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

				array(
					'key' => 'field_5df352c68d8fa',
					'label' => 'Meta description',
					'name' => 'meta_description',
					'aria-label' => '',
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
				array(
					'key' => 'field_5e5869de35ee0',
					'label' => 'Recruiter',
					'name' => 'recruiter_related',
					'aria-label' => '',
					'type' => 'relationship',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'team',
					),
					'taxonomy' => '',
					'filters' => '',
					'elements' => '',
					'min' => '',
					'max' => '',
					'return_format' => 'object',
					'bidirectional_target' => array(),
				),
				array(
					'key' => 'field_5e8129d2480db',
					'label' => 'Job ID',
					'name' => 'job_id',
					'aria-label' => '',
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
						'value' => 'jobs',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
			'show_in_rest' => false,
		));
	}
}
