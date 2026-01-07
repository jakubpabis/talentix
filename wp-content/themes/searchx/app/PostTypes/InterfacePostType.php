<?php
/**
 * Event Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */
declare( strict_types = 1 );
namespace App\PostTypes;

interface InterfacePostType
{


	/**
	 * Add Advanced Custom Field Local Group
	 *
	 * @since 0.7.4
	 *
	 * @return null
	 */
	public function register_taxonomies();


	/**
	 * Add Advanced Custom Field Local Group
	 *
	 * @since 0.7.4
	 *
	 * @return null
	 */
	public function init();


}
