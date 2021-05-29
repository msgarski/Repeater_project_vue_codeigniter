<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCardLearningBatchTable extends Migration
{
	public function up()
	{
		$fields = [
			'learning_batch_id' => [
				'type'          => 'INT',
				'constraint'    => 9,
				'unsigned'      => true,
			],
            'card_id'          	=> [
				'type'          => 'INT',
				'constraint'    => 9,
				'unsigned'      => true,
			],
			'created_at'		=> [
				'type'     		=> 'DATETIME',
				'null'     		=> true,
				'default'  		=> null
			]
	];

        $this->forge->addField($fields);
		$this->forge->addForeignKey('card_id','card','id');
		$this->forge->addForeignKey('learning_batch_id','learning_batch','id');


        $this->forge->createTable('card_learning_batch');
	}

	public function down()
	{
		$this->forge->dropForeignKey('card_learning_batch','card_learning_batch_card_id_foreign');
		$this->forge->dropForeignKey('card_learning_batch','card_learning_batch_learning_batch_id_foreign');
		$this->forge->dropTable('card_learning_batch');
		
	}
}
