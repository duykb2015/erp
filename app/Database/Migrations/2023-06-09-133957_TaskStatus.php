<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'project_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'position' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'default'        => 11
            ],
            'base_status' => [
                'type'           => 'TINYINT',
                'default'        => 0
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('project_id', 'project', 'id', '', 'delete', 'fk_p_i_p_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('task_status', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('task_status', TRUE);
    }
}
