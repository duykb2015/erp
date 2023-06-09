<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Project extends Migration
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
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'prefix' => [
                'type'           => 'VARCHAR',
                'constraint'     => 30,
                'null'           => FALSE,
            ],
            'descriptions' => [
                'type'           => 'VARCHAR',
                'constraint'     => 512,
                'null'           => FALSE,
            ],
            'owner' => [
                'type'           => 'VARCHAR',
                'constraint'     => 33,
                'null'           => FALSE,
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => TRUE,
            ],
            'due_at' => [
                'type'           => 'TIMESTAMP',
                'null'           => TRUE,
            ],
            'start_at' => [
                'type'           => 'TIMESTAMP',
                'null'           => TRUE,
            ],
            'status' => [
                'type'           => 'VARCHAR',
                'constraint'     => 25,
                'null'           => TRUE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
            'updated_at DATETIME NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp',
            'deleted_at TIMESTAMP NULL',
        ]);
        $this->forge->addPrimaryKey('id');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('project', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('project', TRUE);
    }
}
