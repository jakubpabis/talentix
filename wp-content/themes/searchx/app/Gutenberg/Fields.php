<?php
declare( strict_types = 1 );
namespace App\Gutenberg;

/**
 * Fields class.
 *
 * @category Builder
 */
final class Fields extends DefaultFields {


	/**
	 * @var array The array of Advanced Custom Field data.
	 *
	 * @since 0.7.0
	 */
	private $acf = [];

	/**
	 * @var string The component name.
	 *
	 * @since 0.7.0
	 */
	private $name = '';


	/**
	 * Constructor. Sets up the component.
	 *
	 * @since 0.7.0
	 *
	 * @param string $file Fully qualified path to the file to include.
	 */
	public function __construct( string $file ) {

		require_once ABSPATH . '/wp-admin/includes/file.php';

		$this->set_name( $file );

		if( file_exists( $file ) ) {
			$this->acf = include $file;
		}
		$this->setup_tabs();

		$blennder_components_acf[ $this->name ] = $this->acf[ 'fields' ];

	}


	/**
	 * Get the ACF Fields array.
	 *
	 * @since 2.7.6
	 *
	 * @return array The ACF fields.
	 */
	public function get_fields() : array {
		return $this->acf[ 'fields' ];
	}


	/**
	 * Get the component name.
	 *
	 * @since 2.7.6
	 *
	 * @return string The component name.
	 */
	public function get_name() : string {
		return $this->name;
	}


	/*
	* Some Components we dont want to use the design tab on
	* This allows us to not include it when registering the component
	* Add this in your {component}-acf.php file after the 'fields' array
	* We can extend this to do more down the road
	*
	* 'config' => array(
	*	'background_tab' => false
	* )
	*
	* @since 0.7.0
	*/
	private function setup_tabs() : void {

		if( isset( $this->acf[ 'config' ][ 'heading' ] ) && false === $this->acf[ 'config' ][ 'heading' ] ) {
			$tab = array_shift( $this->content_tab );
			$this->content_tab = [ $tab ];
		}

		$fields = array_merge( $this->content_tab ?? [], $this->acf[ 'fields' ]  ?? [] );

		// Add addition tabs if wanted
		$tabs = [
			'design'     => $this->design_tab,
			'background' => $this->background_tab,
			'settings'   => $this->settings_tab,
		];

		foreach( $tabs as $key => $tab ) {
			if( $this->config_tab( $key ) ) {
				$prop   = "{$key}_tab";
				$val    = $this->$prop ?? $this->acf['fields'];
				$fields = array_merge( $fields, $val );

				$templates = component_templates( $this->name );

				// Rename the key and name fields to allow dynamic choices
				foreach( $fields as $key => $field ) {
					if( $field[ 'name' ] === 'block_template' ) {
						$hash = md5( $this->name );
						$field[ 'key' ] = str_replace( 'field_', "field_$hash", $field[ 'key' ] );
						$field[ 'name' ] = "{$this->name}_{$field[ 'name' ] }";

						$choices = array_merge( $field[ 'choices' ], $templates );
						$field[ 'choices' ] = $choices;
					}
					$fields[ $key ] = $field;
				}

				if( isset( $this->acf[ $prop ] ) && is_array( $this->acf[ $prop ] ) ) {
					$fields = array_merge( $fields, $this->acf[ $prop ] );
				}
			}
		}
		$this->acf[ 'fields' ] = $fields;
	}


	/**
	 * Return whether the tab should be added to the component.
	 *
	 * @param string $tab The name of the tab to be configured.
	 *
	 * @return bool Whether the tab is shown or not.
	 */
	 private function config_tab( string $tab ) : bool {
		return ! isset( $this->acf[ 'config' ][ "{$tab}_tab" ] ) || false !== $this->acf[ 'config' ][ "{$tab}_tab" ];
	}


	/**
	 * Set the component name from the file path by splitring off the -acf off the name
	 *
	 * @since 0.7.0
	 *
	 * @param string $file - The full file path
	 */
	private function set_name( string $file ) : void {
		$this->name = preg_split( "/(-acf.php)+/", basename( $file ) )[0];
	}

}
