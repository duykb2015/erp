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
            'task_key' => [
                'type'           => 'VARCHAR',
                'constraint'     => 25,
                'unique'         => TRUE,
                'null'           => FALSE,
            ],
            'parent_id' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'task_status_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'assignee' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'reporter' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'descriptions' => [
                'type'           => 'LONGTEXT',
                'null'           => TRUE,
            ],
            'priority' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => TRUE,
            ],
            'created_by' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'due_at' => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
            'start_at' => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
            'updated_at DATETIME NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp'
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('task_status_id', 'task_status', 'id', '', 'delete', 'fk_t_s_i_s_i');
        $this->forge->addForeignKey('assignee', 'user', 'id', '', 'delete', 'fk_t_a_u_i');
        $this->forge->addForeignKey('created_by', 'user', 'id', '', 'delete', 'fk_t_c_b_u_i');
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
