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
                'constraint'     => 50,
                'null'           => FALSE,
            ],
            'password' => [
                'type'           => 'VARCHAR',
                'constraint'     => 36,
                'null'           => FALSE,
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => FALSE,
            ],
            'firstname' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => TRUE,
            ],
            'lastname' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => TRUE,
            ],
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 25,
                'null'           => FALSE,
                'default'        => 'user'
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => TRUE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
            'updated_at DATETIME NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp',
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
