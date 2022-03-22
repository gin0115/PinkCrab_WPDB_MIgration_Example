<?php

/**
 * Helper functions
 *
 * This is needed as the WP Uninstall hook will only accept named functions or classes
 * with the __invoke() method.
 */

namespace PinkCrab\Migration_Example;

use PinkCrab\Table_Builder\Builder;
use PinkCrab\DB_Migration\Migration_Manager;
use PinkCrab\DB_Migration\Database_Migration;
use PinkCrab\Migration_Example\Migration\Simple_Table_Migration;
use PinkCrab\Table_Builder\Engines\WPDB_DB_Delta\DB_Delta_Engine;
use PinkCrab\Migration_Example\Migration\Referenced_Base_Table_Migration;
use PinkCrab\Migration_Example\Migration\Referenced_Linked_Table_Migration;

/**
 * Returns a populated instance of the Migration Manager.
 *
 * @return Migration_Manager
 */
function get_migration_manager(): Migration_Manager {
	global $wpdb;
	$table_builder = new Builder(
		new DB_Delta_Engine( $wpdb )
	);

	return new Migration_Manager(
		$table_builder,
		$wpdb,
		GIN0115_WPDB_MIGRATIONS
	);
}

/**
 * Returns an array of Migration objects.
 *
 * @return Database_Migration[]
 */
function get_migrations(): array {
	return array(
		new Referenced_Base_Table_Migration(),
		new Simple_Table_Migration(),
		new Referenced_Linked_Table_Migration(),
	);
}

/**
 * Activation hook callback.
 *
 * @return void
 */
function activation_callback(): void {
		// Get an instance of the manager
	$manager = get_migration_manager();

	// Push all the current migrations to the manager.
	foreach ( get_migrations() as $migration ) {
		$manager->add_migration( $migration );
	}

	// Create all tables
	// This should be wrapped in a try/catch, so all exceptions
	// can be caught and processed.
	try {
		$manager->create_tables();
		$manager->seed_tables();
	} catch ( \Throwable $th ) {
		// Just show an error.
		add_action(
			'admin_notices',
			function() use ( $th ) {
				?>
				<div class="notice notice-success is-dismissible">
					<p><?php \printf( 'Failed to migrate tables :: (%s)', $th->getMessage() ); ?></p>
				</div>
				<?php
			}
		);
	}

	// Register the uninstall hook.
	register_uninstall_hook( __FILE__, 'PinkCrab\Migration_Example\uninstall_callback' );
}

/**
 * The callback used when the plugin is uninstalled.
 *
 * @return void
 */
function uninstall_callback(): void {

	// Get an instance of the manager
	$manager = get_migration_manager();

	// Push all the current migrations to the manager.
	foreach ( get_migrations() as $migration ) {
		$manager->add_migration( $migration );
	}

	// Remove all the tables.
	// This should be wrapped in a try/catch, to avoid any exceptions
	// from preventing plugin from uninstalling.
	try {
		$manager->drop_tables();
	} catch ( \Throwable $th ) {
		// DO NOTHING HERE AS YOU SHOULD NOT STOP A PLUGIN FROM BEING
		// UNINSTALLED, EVER!
	}
}
