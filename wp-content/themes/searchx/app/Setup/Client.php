<?php
declare( strict_types = 1 );
namespace App\Setup;

class Client {

	public static $option_name = 'client_role_version';

	public static $version = 1;

	public static $role = [
		'slug' => 'client',
		'name' => 'Client',
	];

	public static function init() {
		add_filter( 'acf/prepare_field', [ __CLASS__, 'prepare_field' ] );
		add_action( 'after_switch_theme', [ __CLASS__, 'activation' ] );
		add_action( 'switch_theme', [ __CLASS__, 'deactivation' ] );
		add_action ( 'acf/render_field_settings', [ __CLASS__, 'acf_render_field_settings' ] );
	}


	/**
	 * Adds on optional capability field to all ACF fields.
	 *
	 * When this value is set, the `current_user_can( {capability} )` will
	 * determine whether a user can modify this field.
	 */
	public static function acf_render_field_settings( $field ) {
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Capability', 'acf' ),
				'instructions' => 'WordPress capability required to modify this field.',
				'type'         => 'text',
				'name'         => 'capability',
				'class'        => 'field-type',
			),
			true
		);
	}

	/**
	 * Filter fields based on their capabilities.
	 *
	 * The acf/prepare_field filter allows us to modify fields prior to them
	 * displaying on the backend. This method looks for a non-standard ACF
	 * subfield called 'capability' and compares that to whether the
	 * current user can do that capability. If a field should only be displayed
	 * to administrators, developers can add the following to that field:
	 *
	 * 'capability' => 'update_core'
	 *
	 * Note: A user without permissions to edit the field cannot overwrite
	 * changes by a user that can write to a particular field.
	 */
	public static function prepare_field( $field ) {
		return ( ! empty( $field[ 'capability' ] ) && ! current_user_can( $field[ 'capability' ] ) ) ? false : $field;
	}

	/**
	 * Add the Client role.
	 *
	 * This method should only be run from the theme activation hook.
	 */
	public static function activation() {
		if( self::$version == get_option( self::$option_name ) ) {
			return;
		}

		$editor = get_role( 'administrator' );
		$caps = $editor->capabilities;

		unset( $caps[ 'level_10' ] );
		unset( $caps[ 'level_9' ] );
		unset( $caps[ 'level_8' ] );
		unset( $caps[ 'level_7' ] );
		unset( $caps[ 'level_6' ] );
		unset( $caps[ 'level_5' ] );
		unset( $caps[ 'level_4' ] );
		unset( $caps[ 'level_3' ] );
		unset( $caps[ 'level_2' ] );
		unset( $caps[ 'level_1' ] );
		unset( $caps[ 'level_0' ] );
		unset( $caps[ 'install_themes' ] );
		unset( $caps[ 'update_themes' ] );
		unset( $caps[ 'switch_themes' ] );
		unset( $caps[ 'delete_themes' ] );
		unset( $caps[ 'edit_themes' ] );
		unset( $caps[ 'install_plugins' ] );
		unset( $caps[ 'update_plugins' ] );
		unset( $caps[ 'activate_plugins' ] );
		unset( $caps[ 'edit_plugins' ] );
		unset( $caps[ 'delete_plugins' ] );
		unset( $caps[ 'update_core' ] );
		unset( $caps[ 'edit_files' ] );
		unset( $caps[ 'unfiltered_upload' ] );
		unset( $caps[ 'unfiltered_html' ] );

		update_option( self::$option_name, self::$version );
		add_role( self::$role[ 'slug' ], self::$role[ 'name' ], $caps );
	}

	/**
	 * Remove the Client role and covert all clients to administrators.
	 *
	 * This method should only be run after the theme has been deactivated.
	 */
	public static function deactivation() {
		$args = [
			'role' => self::$role[ 'slug' ],
		];
		$users = get_users( $args );

		foreach( $users as $user ) {
			$user->remove_role( self::$role[ 'slug' ]  );
			$user->add_role( 'administrator' );
		}
		remove_role( self::$role[ 'slug' ] );
		delete_option( self::$option_name );
	}
}
