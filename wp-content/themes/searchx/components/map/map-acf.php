<?php
return array(
	'key' => 'group_6082f45e7d3fe',
	'title' => 'Map',
	'fields' => array(
		array(
			'key' => 'field_5bbd208gse24guhb',
			'label' => 'Map SVG',
			'name' => 'map_svg',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => acf_block_conditional_logic('map', ['map-svg']),
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
		),
		array(
			'key' => 'field_5bbdse3424guhb2',
			'label' => 'Map Card',
			'name' => 'map_card',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => acf_block_conditional_logic('map', ['map-svg']),
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
		),
		array(
			'key' => 'field_5bbdse34gre24guhb2',
			'label' => 'Map Card Position',
			'name' => 'map_card_position',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => acf_block_conditional_logic('map', ['map-svg']),
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'start' => 'Left',
				'end' => 'Right',
				'bottom' => 'Bottom',
			),
			'default_value' => 'end',
		),
	),
);
