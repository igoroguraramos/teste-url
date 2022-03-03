<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::class;
        $user::create([
            'name' => 'Igor Ogura Ramos',
            'email' => 'igoroguraramos@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
