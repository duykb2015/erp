<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Attactment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => FALSE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('attachment', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('attachment', TRUE);
    }
}
