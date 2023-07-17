<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProjectUser extends Migration
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
            'user_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'role' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'default'        => 'member',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('project_id', 'project', 'id', '', '', 'fk_p_u_p_i_p_i');
        $this->forge->addForeignKey('user_id', 'user', 'id', '', '', 'fk_p_u_u_i_u_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('project_user', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('project_user', TRUE);
    }
}
