<?php
/**
 * Location Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */
declare( strict_types = 1 );
namespace App\PostTypes;

class Location extends AbstractPostType {


		/**
		 * Add Advanced Custom Field Local Group
		 *
		 * @since 0.7.4
		 *
		 * @return null
		 */
		public function acf_add_local_field_group()
		{
			acf_add_local_field_group( array(
				'key' => 'group_608307f052c12',
				'title' => 'Location Meta',
				'fields' => array(
					array(
						'key' => 'field_608307f76360e',
						'label' => 'Latitude Longitude',
						'name' => 'latitude_longitude',
						'type' => 'text',
						'instructions' => 'Must be a valid Latitude / Longitude pair separated by a comma or space.',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '39.7722365, -104.9860719',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_6083083e6360f',
						'label' => 'Address',
						'name' => 'address',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
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
						'key' => 'field_6083084a63610',
						'label' => 'Phone',
						'name' => 'phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
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
							'value' => 'location',
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
			));
		}

}
