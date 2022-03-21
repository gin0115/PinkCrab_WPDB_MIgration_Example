<?php

/**
 * Plugin Name: PinkCrab WPDB Migration Example
 * Plugin URI: https://github.com/gin0115/PinkCrab_WPDB_MIgration_Example
 * Description: Example of how to use the WPDB Migrations library.
 * Author: Glynn Quelch
 * Requires at least: 5.4
 * Requires PHP: 7.1
 * Tested up to: 5.9
 * License: GPLv2+
 * Text Domain: gin0115-wpdb-migration-example
 */

require __DIR__ . '/vendor/autoload.php';

define( 'GIN0115_WPDB_MIGRATIONS', 'gin0115-wpdb-migrations' );

// Registers the activation hooks, also contains the uninstall hook.
register_activation_hook( __FILE__, 'PinkCrab\Migration_Example\activation_callback' );

