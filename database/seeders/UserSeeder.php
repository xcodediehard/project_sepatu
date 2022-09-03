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
        //
        User::create([
            'name' => "Guruh Adi",
            'email' => "guruhadi@gmail.com",
            'password' => bcrypt("123456789"),
            'telfon' => "085158456789",
            'alamat' => "melati",
            'haskey' => bcrypt("123456789")
        ]);
    }
}
