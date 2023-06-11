<?php

namespace App\Database\Seeds;

use App\Models\User as ModelsUser;
use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => md5('1112'),
            'email' => 'example@gmail.com',
            'photo' => '1686321170.png',
            'type' => 'admin'
        ];
        $user = new ModelsUser();
        $user->insert($data);
    }
}
