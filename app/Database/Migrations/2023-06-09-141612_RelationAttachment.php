<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Relation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'uploaded_by' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'relation_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'relation_type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => FALSE,
            ],
            'attachment_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('uploaded_by', 'user', 'id', '', '', 'fk_a_c_u_b_u_i');
        $this->forge->addForeignKey('attachment_id', 'attachment', 'id', '', '', 'fk_a_c_a_i_a_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('relation_attachment', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('relation_attachment', TRUE);
    }
}
