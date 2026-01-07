<?php

return array(
	'key' => 'group_blog',
	'title' => 'Blog',
	'fields' => array(
		array(
			'key' => 'field_5cd07fddb9ab4',
			'label' => 'Posts Source',
			'name' => 'posts_source',
			'type' => 'button_group',
			'instructions' => 'Choose where the posts get pulled from, Choosing WordPress will run a normal WordPress Posts Query with your chosen options. Choosing Post Picker will give you an option to manually choose which posts to show.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'wp_query' => 'WordPress',
				'post_picker' => 'Post Picker',
			),
			'allow_null' => 0,
			'default_value' => 'wp_query',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5cc0d90071ce4',
			'label' => 'Post Picker',
			'name' => 'post_picker',
			'type' => 'relationship',
			'instructions' => 'Manually select a collection of blog posts from the available items.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cd07fddb9ab4',
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
				0 => 'post',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
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
