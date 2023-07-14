<?php

namespace App\Database\Seeds;

use App\Models\Task as ModelsTask;
use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class Task extends Seeder
{
    public function run()
    {
        $userID = [1, 2, 6, 22, 23, 24];
        $statusID = [9, 10, 11, 12];
        $taskKey = 28;

        $taskModel = new ModelsTask();

        $faker = Faker::create('Asia/Ho_Chi_Minh');

        for ($i = 0; $i < 25; $i++) {
            $taskModel->insert([
                'task_key' => 'DAM2-' . $taskKey++,
                'task_status_id' => $statusID[random_int(0, 3)],
                'assignee' => $userID[random_int(0, 5)],
                'title' => $faker->sentence(5),
                'descriptions' => $faker->text(),
                'priority' => NORMAL,
                'created_by' => 1
            ]);
        }
    }
}
