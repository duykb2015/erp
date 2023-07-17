<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notification extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => FALSE,
            ],
            'message' => [
                'type'           => 'TEXT',
                'null'           => FALSE,
            ],
            'recipient_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'sender_id' => [
                'type'           => 'INT',
                'null'           => FALSE,
            ],
            'is_read' => [
                'type'           => 'BOOLEAN',
                'null'           => FALSE,
            ],
            'created_at DATETIME NOT NULL DEFAULT current_timestamp',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('recipient_id', 'user', 'id', '', '', 'fk_n_r_i_u_i');
        $this->forge->addForeignKey('sender_id', 'user', 'id', '', '', 'fk_n_s_i_u_i');
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8',
            'COLLATE' => 'utf8_general_ci'
        ];
        $this->forge->createTable('notification', TRUE, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('notification', TRUE);
    }
}
