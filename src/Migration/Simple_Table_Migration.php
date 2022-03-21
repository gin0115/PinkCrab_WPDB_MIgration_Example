<?php

/**
 * Example of a simple table which is create with a few rows
 */

namespace PinkCrab\Migration_Example\Migration;

use PinkCrab\Table_Builder\Schema;
use PinkCrab\DB_Migration\Database_Migration;

class Simple_Table_Migration extends Database_Migration {

	// Define the tables name.
	protected $table_name = 'simple_table';

	// Define the tables schema
	public function schema( Schema $schema_config ): void {
		$schema_config->column( 'id' )->unsigned_int( 12 )->auto_increment();
		$schema_config->index( 'id' )->primary();

		$schema_config->column( 'column1' )->text()->nullable();
		$schema_config->column( 'column2' )->text()->nullable();
	}

	// Add all data to be seeded
	public function seed( array $seeds ): array {
		$seeds[] = array(
			'column1' => 'value-a-1',
			'column2' => 'value-a-2',
		);

		$seeds[] = array(
			'column1' => 'value-b-1',
			'column2' => 'value-b-2',
		);

		return $seeds;
	}
}
