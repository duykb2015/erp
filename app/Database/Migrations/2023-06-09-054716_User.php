<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => FALSE,
            ],
            'password' => [
                'type'           => 'VARCHAR',
                'constraint'     => 33,
                'null'           => FALSE,
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => FALSE,
            ],
            'firstname' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => TRUE,
            ],
            'lastname' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => TRUE,
            ],
            'type' => [
                'type'           => 'TINYINT',
                'null'           => FALSE,
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => TRUE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('user', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('user', TRUE);
    }
}
