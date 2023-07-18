<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProjectLog extends Migration
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
            'project_id' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('project_id', 'project', 'id', '', '', 'fk_p_l_p_i_p_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('project_log', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('project_log', TRUE);
    }
}
