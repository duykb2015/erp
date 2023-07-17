<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'log' => [
                'type'           => 'TEXT',
                'null'           => FALSE,
            ],
            'task_id' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('task_id', 'task', 'id', '', '', 'fk_t_l_t_i_t_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('task_log', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('task_log', TRUE);
    }
}
