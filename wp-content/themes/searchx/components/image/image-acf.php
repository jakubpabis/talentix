<?php

return array(
	'key' => 'group_image',
	'title' => 'IMAGE',
	'fields' => array(
		array(
			'key' => 'field_52343g5b25f3c07',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'library' => 'all',
			'mime_types' => '.jpg, .jpeg, .webp, .svg, .png, .gif',
		),
		array(
			'key' => 'field_52343gsdfsdf5b25f3c07',
			'label' => 'Image Ratio',
			'name' => 'image_ratio',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				null => 'Default',
				'ratio-1x1' => '1x1',
				'ratio-4x3' => '4x3',
				'ratio-16x9' => '16x9',
				'ratio-21x9' => '21x9',
				'ratio-4x5' => '4x5',
			),
			'default_value' => '',
		),
	),
);
