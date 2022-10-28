<?php

namespace App\Database\Seeds;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrangSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama'      => 'Abud',
        //         'alamat'    => 'Gunung batu no 36',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ],
        //     [
        //         'nama'      => 'galvin',
        //         'alamat'    => 'Gunung batu no 36',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ],
        //     [
        //         'nama'      => 'erik',
        //         'alamat'    => 'Gunung batu no 36',
        //         'created_at' => Time::now(),
        //         'updated_at' => Time::now(),
        //     ]
        // ];
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama'      => $faker->name,
                'alamat'    => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::now(),
            ];
            $this->db->table('member')->insert($data);
        }
        // Simple Queries
        // $this->db->query('INSERT INTO member (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)', $data);

        // Using Query Builder
        //     $this->db->table('member')->insert($data);
        // $this->db->table('member')->insertBatch($data); buat 2 atau lebih data
    }
}
//