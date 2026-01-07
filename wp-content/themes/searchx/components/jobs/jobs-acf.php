<?php

$taxonomy = 'job-category';
$terms = get_terms([
	'taxonomy' => $taxonomy,
	'hide_empty' => false,
]);

$terms_array = array();

foreach ($terms as $term) {
	$terms_array[$term->term_id] = $term->name;
}

return array(
	'key' => 'group_jobs',
	'title' => 'Jobs',
	'fields' => array(
		array(
			'key' => 'field_5cd07fkjkjnddb9ab4',
			'label' => 'Jobs Source',
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
				'post_picker' => 'Jobs Picker',
				'filter_picker' => 'Filters'
			),
			'allow_null' => 0,
			'default_value' => 'wp_query',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5cc0d923r0071ce4',
			'label' => 'Jobs Picker',
			'name' => 'post_picker',
			'type' => 'relationship',
			'instructions' => 'Manually select a collection of jobs posts from the available items.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cd07fkjkjnddb9ab4',
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
				0 => 'jobs'
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
		array(
			'key' => 'field_5b74336y54whtrsdfg1',
			'label' => 'Jobs Search Term',
			'name' => 'jobs_search',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cd07fkjkjnddb9ab4',
						'operator' => '==',
						'value' => 'filter_picker',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_687f6bbea2t5y4whtrbsdfga83',
			'label' => 'Jobs Category',
			'name' => 'jobs_category',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cd07fkjkjnddb9ab4',
						'operator' => '==',
						'value' => 'filter_picker',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'capability' => '',
			'choices' => $terms_array,
			'default_value' => array(),
			'return_format' => 'value',
			'allow_custom' => 0,
			'allow_in_bindings' => 0,
			'layout' => 'horizontal',
			'toggle' => 0,
			'save_custom' => 0,
		),
	),
);
