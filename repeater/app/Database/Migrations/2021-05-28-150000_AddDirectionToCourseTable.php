<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDirectionToCourseTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('course', [
                    'direction'                  =>  [
                            'type'          =>  'BOOLEAN',
                            'null'          =>  false, 
                            'default'       =>  true // dla normalnego kierunku uczenia
                    ],
        ]);

    }
    public function down()
    {
        $this->forge->dropColumn('course','direction');
    }


}