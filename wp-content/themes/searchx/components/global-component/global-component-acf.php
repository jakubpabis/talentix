<?php

return array(
	'key' => 'group_global_component_1234',
	'title' => 'Global Component',
	'fields' => array(
		array(
			'key' => 'field_2134t5grtrf2g4',
			'label' => 'Component Picker',
			'name' => 'component_picker',
			'type' => 'relationship',
			'instructions' => 'Manually select a collection of components from the available items.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'globalcomponent',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => array(
				0 => 'title',
			),
			'return_format' => 'id',
		),
	),
);
