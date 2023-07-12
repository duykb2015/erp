<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TimeTracking extends Migration
{
    public function up()
    {
        // $this->forge->addField([
        //     'id' => [
        //         'type'           => 'INT',
        //         'null'           => FALSE,
        //         'auto_increment' => TRUE
        //     ],
        //     'task_id' => [
        //         'type'           => 'INT',
        //         'null'           => FALSE,
        //     ],
        //     'recorded_time' => [
        //         'type'           => 'INT',
        //         'null'           => TRUE,
        //     ],
        //     'created_at DATETIME NOT NULL DEFAULT current_timestamp',
        //     'updated_at DATETIME NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp'
        // ]);
        // $this->forge->addPrimaryKey('id');
        // $this->forge->addForeignKey('task_id', 'task', 'id', '', '', 'fk_t_t_t_i_t_i');
        // $attributes = [
        //     'ENGINE' => 'InnoDB',
        //     'CHARACTER SET' => 'utf8',
        //     'COLLATE' => 'utf8_general_ci'
        // ];
        // $this->forge->createTable('task', TRUE, $attributes);
    }

    public function down()
    {
        // $this->forge->dropTable('task', TRUE);
    }
}
