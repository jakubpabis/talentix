<?php

return array(
	'key' => 'group_testimonials',
	'title' => 'Testimonials',
	'fields' => array(
		array(
			'key' => 'field_5ce58ec1396f2',
			'label' => 'Testimonials Source',
			'name' => 'posts_source',
			'type' => 'button_group',
			'instructions' => 'Choose where the Testimonials get pulled from, Choosing WordPress will run a normal WordPress Query with your chosen options. Choosing Manual Picker will give you an option to manually choose which Testimonials to show. To add a testimonial to the system, visit the Testimonials Section on the menu.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'wp_query' => 'WordPress',
				'post_picker' => 'Manual Picker',
			),
			'allow_null' => 0,
			'default_value' => 'wp_query',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5bce6ecf82b3a',
			'label' => 'Testimonials',
			'name' => 'post_picker',
			'type' => 'relationship',
			'instructions' => 'Choose which testimonials to show.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5ce58ec1396f2',
						'operator' => '==',
						'value' => 'post_picker',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'testimonials',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => array(
				0 => 'featured_image',
			),
			'min' => '',
			'max' => '',
			'return_format' => 'id',
		),
	),
);
