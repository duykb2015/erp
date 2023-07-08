<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'task_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'created_by' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'text' => [
                'type'           => 'TEXT',
                'null'           => FALSE,
            ],
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => FALSE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('task_id', 'task', 'id', '', '', 'fk_c_t_i_t_i');
        $this->forge->addForeignKey('created_by', 'user', 'id', '', '', 'fk_c_c_b_u_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('comment', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('comment', TRUE);
    }
}
