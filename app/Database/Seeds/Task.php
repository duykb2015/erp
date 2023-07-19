<?php

namespace App\Database\Seeds;

use App\Models\Project;
use App\Models\ProjectLog;
use App\Models\ProjectUser;
use App\Models\Task as ModelsTask;
use App\Models\TaskLog;
use App\Models\TaskStatus;
use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class Task extends Seeder
{
    public function run()
    {
        $userID = [OWNER => 1, LEADER => 2, MEMBER => 3, MEMBER => 4, MEMBER => 5, MEMBER => 6];
        $faker = Faker::create('Asia/Ho_Chi_Minh');

        $projectModel = new Project();
        $pid = $projectModel->insert([
            'name' => 'Dự án khởi đầu',
            'prefix' => 'DAKD',
            'descriptions' => $faker->sentence(10),
            'owner' => 1,
            'photo' => $this->makeImage('D'),
            'start_at' => '2023-07-10 00:00:00',
            'due_at' => '2024-07-10 00:00:00',
            'status' => INITIALIZE
        ]);

        $projectLog = new ProjectLog();
        $projectLog->insert([
            'project_id' => $pid,
            'log' => '<b>Lãng Duy</b> đã khởi tạo dự án'
        ]);

        $projectUserModel = new ProjectUser();
        foreach ($userID as $key => $id) {
            $projectUserModel->insert([
                'project_id' => $pid,
                'user_id' => $id,
                'role' => $key
            ]);
        }

        $data = collect([
            [
                'id' => 1, 
                'project_id' => $pid,
                'title' => 'Khởi tạo',
                'position' => 0,
                'base_status' => 1
            ],
            [
                'id' => 2,
                'project_id' => $pid,
                'title' => 'Đang thực hiện',
                'position' => 1,
                'base_status' => 2
            ],
            [
                'id' => 3,
                'project_id' => $pid,
                'title' => 'Sẵn sàng xem xét',
                'position' => 2,
                'base_status' => 3
            ],
            [
                'id' => 4,
                'project_id' => $pid,
                'title' => 'Hoàn thành',
                'position' => 2,
                'base_status' => 4
            ],
        ]);

        $taskStatusModel = new TaskStatus();
        $data->each(function ($item) use ($taskStatusModel) {
            $taskStatusModel->insert($item);
        });
        $statusID = [1, 2, 3, 4];
        $taskKey = 1;

        $taskModel = new ModelsTask();
        $taskLogModel = new TaskLog();

        for ($i = 0; $i < 10; $i++) {
            $tid = $taskModel->insert([
                'task_key' => 'DAM2-' . $taskKey++,
                'task_status_id' => $statusID[random_int(0, 3)],
                'assignee' => $userID[array_rand($userID)],
                'title' => $faker->sentence(5),
                'descriptions' => $faker->text(),
                'priority' => NORMAL,
                'created_by' => 1
            ]);

            $taskLogModel->insert([
                'task_id' => $tid,
                'log' => '<b>Lãng Duy</b> đã khởi tạo công việc'
            ]);
        }
    }

    public function makeImage($character)
    {
        $img_name = time() . ".png";
        $path     = dirname(__DIR__, 3) . '/public/imgs/' . $img_name;

        $file = fopen($path, 'w');
        fclose($file);

        $image = imagecreate(200, 200);

        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        imagecolorallocate($image, $r, $g, $b);

        $textcolor = imagecolorallocate($image, 255, 255, 255);
        $font = dirname(__DIR__, 3) . '/public/font/arial.ttf';
        imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
        imagepng($image, $path);
        imagedestroy($image);
        return $img_name;
    }
}
