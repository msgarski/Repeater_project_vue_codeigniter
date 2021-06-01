<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOptionsTable extends Migration
{
	public function up()
	{
		$fields = [
                        'id'                    => [
                                'type'          =>'INT',
                                'constraint'    => 7,
                                'unsinged'      => true,
                                'auto_increment'        =>      true
                        ],
		        'user_id'          	=> [
                                'type'           => 'INT',
                                'constraint'     => 7,
                                'unsigned'       => true
			],
                        'overlearning'            =>  [
                                'type'          =>  'BOOLEAN',
                                'null'          =>  false, 
                                'default'       =>  true
                        ],
                        'batch_learning_limit'    =>  [
                                'type'          =>  'TINYINT',
                                'constraint'    =>  3,
                                'null'          =>  false,
                                'unsigned'      =>  true,
                                'default'       =>  0
                        ],
                        'day_learning_limit'      =>  [
                                'type'          =>  'INT',
                                'constraint'    =>  3,
                                'null'          =>  false,
                                'unsigend'      =>  true,
                                'default'       =>  0
                        ],
                        'day_repeat_limit'        =>  [
                                'type'          =>  'INT',
                                'constraint'    =>  3,
                                'null'          =>  false,
                                'unsigned'      =>  true,
                                'default'       =>  0
                        ]
	        ];

        $this->forge->addField($fields);

        $this->forge->addKey('id', true); //????

        //$this->forge->addForeignKey('user_id','user','id');

        $this->forge->createTable('options');
	}

	public function down()
	{
        //$this->forge->dropForeignKey('options','user_id');

		$this->forge->dropTable('options');
		
	}
}
