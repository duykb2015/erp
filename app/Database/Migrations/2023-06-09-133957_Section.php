<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Section extends Migration
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
                'constraint'     => 512,
                'null'           => FALSE,
            ],
            'position' => [
                'type'           => 'TINYINT',
                'null'           => FALSE,
                'default'        => 0
            ],
            'base_section' => [
                'type'           => 'TINYINT',
                'default'        => 0
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('project_id', 'section', 'id', '', '', 'fk_s_p_i_p_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('section', TRUE, $attributes);
    }

    public function down()
    {
        //
    }
}
