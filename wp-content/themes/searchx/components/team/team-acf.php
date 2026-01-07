<?php

return array(
	'key' => 'group_team',
	'title' => 'Team',
	'fields' => array(
		array(
			'key' => 'field_48u9hirwebgue',
			'label' => 'Teams Source',
			'name' => 'posts_source',
			'type' => 'button_group',
			'instructions' => 'Choose where the Teams get pulled from, Choosing WordPress will run a normal WordPress Query with your chosen options. Choosing Manual Picker will give you an option to manually choose which Teams to show. To add a team to the system, visit the Teams Section on the menu.',
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
			'key' => 'field_3984jeirngue',
			'label' => 'Teams',
			'name' => 'post_picker',
			'type' => 'relationship',
			'instructions' => 'Choose which teams to show.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_48u9hirwebgue',
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
				0 => 'team',
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
	'design_tab' => array(
		array(
			'key' => 'field_6064e3a73c120',
			'label' => 'Show Bio Type',
			'name' => 'team_show_bio_type',
			'type' => 'button_group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'modal' => 'Popup Modal',
				'page' => 'Full Page',
			),
			'allow_null' => 0,
			'default_value' => 'modal',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
	),
);
