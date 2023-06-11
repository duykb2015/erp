<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttachmentComment extends Migration
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
            'comment_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'attachment_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('uploaded_by', 'user', 'id', '', '', 'fk_a_c_u_b_u_i');
        $this->forge->addForeignKey('comment_id', 'comment', 'id', '', '', 'fk_a_c_c_i_c_i');
        $this->forge->addForeignKey('attachment_id', 'attachment', 'id', '', '', 'fk_a_c_a_i_a_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('attachment_comment', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('attachment_comment', TRUE);
    }
}
