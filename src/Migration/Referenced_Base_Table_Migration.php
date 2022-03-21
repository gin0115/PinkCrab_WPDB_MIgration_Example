<?php

/**
 * The base table of a linked example
 */

namespace PinkCrab\Migration_Example\Migration;

use PinkCrab\Table_Builder\Schema;
use PinkCrab\DB_Migration\Database_Migration;

class Referenced_Base_Table_Migration extends Database_Migration {

	// Define the tables name.
	protected $table_name = 'linked_base_table';

	// Define the tables schema
	public function schema( Schema $schema_config ): void {

		// Create the primary index for the table.
		$schema_config->column( 'id' )->unsigned_int( 12 )->auto_increment();
		$schema_config->index( 'id' )->primary();

		$schema_config->column( 'something_else' )->text()->nullable();

		// Ensure this column only has unique values, to be used as reference
		// for a foreign key.
		$schema_config->column( 'ref_col' )->unsigned_int( 12 )->nullable( false );
		$schema_config->index( 'ref_col' )->unique();
	}

	// Add all data to be seeded
	public function seed( array $seeds ): array {
		$seeds[] = array(
			'ref_col'        => 12,
			'something_else' => 'value-a-2',
		);

		$seeds[] = array(
			'ref_col'        => 24,
			'something_else' => 'value-b-2',
		);

		return $seeds;
	}
}
