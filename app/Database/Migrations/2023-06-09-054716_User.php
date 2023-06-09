<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'INT',
                // 'constraint' => 11,
                'null'           => FALSE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => FALSE,
            ],
            'password' => [
                'type'           => 'VARCHAR',
                'constraint'     => 33,
                'null'           => FALSE,
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => TRUE,
            ],
            'firstname' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => TRUE,
            ],
            'lastname' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => TRUE,
            ],
            'type' => [
                'type'           => 'TINYINT',
                'null'           => FALSE,
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => 15,
                'null'           => TRUE,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
