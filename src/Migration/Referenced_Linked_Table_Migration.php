<?php

/**
 * The base table of a linked example
 */

namespace PinkCrab\Migration_Example\Migration;

use PinkCrab\Table_Builder\Schema;
use PinkCrab\DB_Migration\Database_Migration;

class Referenced_Linked_Table_Migration extends Database_Migration {

	// Define the tables name.
	protected $table_name = 'linked_linked_table';

	// Define the tables schema
	public function schema( Schema $schema_config ): void {
		$schema_config->column( 'id' )->unsigned_int( 12 )->auto_increment();
		$schema_config->index( 'id' )->primary();

		$schema_config->column( 'join_col' )->unsigned_int( 12 )->nullable( false );
		$schema_config->column( 'something_else' )->text()->nullable();

		// Create a foreign key reference with the base table
		$schema_config->foreign_key( 'join_col' )
			->reference_table( 'linked_base_table' )
			->reference_column( 'ref_col' )
			->on_update( 'CASCADE' )
			->on_delete( 'CASCADE' );
	}

	// Add all data to be seeded
	public function seed( array $seeds ): array {
		$seeds[] = array(
			'join_col'       => 12,
			'something_else' => '12-a',
		);

		$seeds[] = array(
			'join_col'       => 12,
			'something_else' => '12-b',
		);

		$seeds[] = array(
			'join_col'       => 24,
			'something_else' => '24-a',
		);

		$seeds[] = array(
			'join_col'       => 24,
			'something_else' => '24-b',
		);

		return $seeds;
	}
}
