<?php

/**
 * SEO Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */

declare(strict_types=1);

namespace App\PostTypes;

class SEO extends AbstractPostType
{

	/**
	 * Post Type Plural Title
	 *
	 * @var string
	 */
	protected $singular_title = 'SEO';
	protected $plural_title = 'SEO';

	/**
	 * Post Type Args
	 *
	 * @var array
	 */
	protected $args = [
		'menu_icon'           => 'dashicons-networking',
		'supports'  		  => ['title', 'editor', 'custom-fields', 'thumbnail'],
		'hierarchical'        => false,
		'menu_position'       => 20,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'rewrite' => [
			'slug' => 'seo',
			'with_front' => false,
		],
	];
}
