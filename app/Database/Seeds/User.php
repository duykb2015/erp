<?php

namespace App\Database\Seeds;

use App\Models\User as ModelsUser;
use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class User extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => md5('1112'),
            'email' => 'example@gmail.com',
            'photo' => $this->makeImage(strtoUpper('A')),
            'type' => 'admin'
        ];
        $user = new ModelsUser();
        $user->insert($data);

        $faker = Faker::create('Asia/Ho_Chi_Minh');

        for ($i = 0; $i < 20; $i++) {
            $data = [
                'username' => $faker->userName(),
                'password' => md5('1112'),
                'email' => $faker->email(),
                'photo' => $this->makeImage(strtoUpper('A')),
                'firstname' => $faker->firstName(),
                'lastname'  => $faker->lastName(),
                'type' => 'user'
            ];
            $user->insert($data);
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
