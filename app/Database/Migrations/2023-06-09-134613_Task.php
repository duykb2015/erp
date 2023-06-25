<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Task extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'section_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'assignee' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'descriptions' => [
                'type'           => 'TEXT',
                'null'           => TRUE,
            ],
            'priority' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => TRUE,
            ],
            'status' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => FALSE,
            ],
            'due_at' => [
                'type'           => 'TIMESTAMP',
                'null'           => TRUE,
            ],
            'start_at' => [
                'type'           => 'TIMESTAMP',
                'null'           => TRUE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('section_id', 'section', 'id', '', '', 'fk_t_s_i_s_i');
        $this->forge->addForeignKey('assignee', 'user', 'id', '', '', 'fk_t_a_u_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('task', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('task', TRUE);
    }
}
