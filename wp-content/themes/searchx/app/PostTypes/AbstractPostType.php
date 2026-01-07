<?php
/**
 * Testimonial Post Type
 *
 * @author  Blennd Ninjas <ninjas@blennd.com>
 * @license All Rights Reserved https://blennd.com/license.html
 */
declare( strict_types = 1 );
namespace App\PostTypes;

abstract class AbstractPostType implements InterfacePostType
{

	const PRIMARY_TAXONOMY = '';

	/**
	 * Post Type Slug
	 *
	 * @var string
	 */
	protected $slug = null;

	/**
	 * Post Type Singular Title
	 *
	 * @var string
	 */
	protected $singular_title = null;

	/**
	 * Post Type Plural Title
	 *
	 * @var string
	 */
	protected $plural_title = null;

	/**
	 * Post Type Taxonomies
	 *
	 * @var array
	 */
	protected $taxonomies = [];

	/**
	 * Default Arguments
	 *
	 * @var array
	 */
	protected $defaults = [
		'public'              => true,
		'show_in_rest'        => true,
		'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ],
		'has_archive'         => true,
	];

	/**
	 * Post Type Arguments
	 *
	 * @var array
	 */
	protected $args = [];


	/**
	 * Constructor
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	public function __construct()
	{
		// Reflection Class stores information about the called class.
		$class_reflection = new \ReflectionClass($this);
		// We use it to get the class name which is used to set defualt slugs & titles
		$class_name = $class_reflection->getShortName();

		if( null === $this->slug ) $this->slug = strtolower($class_name);

		if( null === $this->singular_title ) $this->singular_title = $class_name;

		if( null === $this->plural_title ) $this->plural_title = $class_name . 's';

		// Merge the Defaults with the child class defined args
		$this->args = array_merge( $this->defaults, $this->args );

		// Setup the labels
		if( true === empty( $this->args['labels'] ) ) $this->construct_labels();

		// Register the Post Type
		$this->register();

	}


	/**
	 * Construct the labels from the titles
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	protected function construct_labels()
	{
		$this->args['labels'] = [
			'name'               => $this->plural_title,
			'singular_name'      => $this->singular_title,
			'add_new'            => "Add New",
			'add_new_item'       => "Add New $this->singular_title",
			'edit_item'          => "Edit $this->singular_title",
			'new_item'           => "New $this->singular_title",
			'view_item'          => "View $this->singular_title",
			'search_items'       => "Search $this->plural_title",
			'not_found'          => "No $this->plural_title found",
			'not_found_in_trash' => "No $this->plural_title found in trash",
			'parent_item_colon'  => "",
			'menu_name'          => $this->plural_title,
		];

	}


	/**
	 * Add the hook to register the post type
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	public function register()
	{
		add_action('init', [ $this, 'init' ]);
		add_action('init', [ $this, 'register_post_type' ]);
		return $this;

	}


	/**
	 * Register the post type
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	public function register_post_type()
	{
		register_post_type(
			$this->slug,
			$this->args
		);

		$this->maybe_add_local_field_group();
		$this->register_taxonomies();
	}


	/**
	 * Register the post type taxonomies
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	public function register_taxonomies()
	{

		$posts = get_posts( [ 'post_type' => $this->slug ] );
		$show_in_rest = (bool) count( $posts );

		foreach ($this->taxonomies as $slug => $taxonomy) {

			$tax_defaults = [
				'label'             => ucwords( str_replace( "-", " ", $slug ) ),
				'show_admin_column' => true,
				'show_tagcloud'     => true,
				'show_in_rest'      => $show_in_rest,
				'hierarchical'      => true
			];

			if( is_array( $taxonomy ) && !empty( $taxonomy ) ) {
				if( array_key_exists('args', $taxonomy) && !empty($taxonomy['args']) ){
					$tax_args = array_merge($tax_defaults, $taxonomy['args']);
				}
			}

			register_taxonomy(
				$slug,
				$this->slug,
				$tax_args ?? $tax_defaults
			);
		}
	}


	/**
	 * Register ACF fields if Advanced Custom Fields plugin is enabled
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	private function maybe_add_local_field_group()
	{
		if (false === function_exists('acf_add_local_field_group')) {
			return;
		}

		$this->acf_add_local_field_group();

	}


	/**
	 * Register ACF fields
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	protected function acf_add_local_field_group()
	{

	}


	/**
	 * Init
	 *
	 * @since 0.7.3
	 *
	 * @return null
	 */
	public function init()
	{

	}

	/**
	 * Returns the primary taxonomy.
	 *
	 * @since 2.7.6
	 *
	 * @return string
	 */
	public static function get_primary_taxonomy() : string {
		$c = get_called_class();
		return $c::PRIMARY_TAXONOMY;
	}

}
