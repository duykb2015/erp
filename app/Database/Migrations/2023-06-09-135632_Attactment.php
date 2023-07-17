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
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'task_id' => [
                'type'           => 'INT',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => FALSE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('task_id', 'task', 'id', '', '', 'fk_a_m_t_i_t_i');
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
