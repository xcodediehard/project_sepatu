<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Pelanggan::create([
            'nama' => "Guruh Adi",
            'email' => "guruhadi@gmail.com",
            'password' => bcrypt("123456789"),
            'telfon' => "085158456789",
            'alamat' => "melati",
            'haskey' => bcrypt("123456789")
        ]);
    }
}
