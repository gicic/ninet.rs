<?php

use App\Models\SolusPlan;
use App\Models\SolusTemplate;
use Illuminate\Database\Seeder;

class SolusTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            SolusTemplate::create([
                'name' => 'CentOS 7',
                'description' => 'centos 7 x86_64 minimal',
                'filename' => 'centos-7-x86_64-minimal',
            ]);

            SolusTemplate::create([
                'name' => 'CentOS 6',
                'description' => 'centos 6 x86_64 minimal',
                'filename' => 'centos-6-x86_64-minimal',
            ]);

            SolusTemplate::create([
                'name' => 'Ubuntu 15.10',
                'description' => 'ubuntu 15.10 x86_64 minimal',
                'filename' => 'ubuntu-15.10-x86_64-minimal',
            ]);

            SolusTemplate::create([
                'name' => 'Ubuntu 14.04',
                'description' => 'ubuntu 14.04 x86_64 minimal',
                'filename' => 'ubuntu-14.04-x86_64-minimal',
            ]);

            DB::commit();
        } catch (Exception $e) {

            echo $e->getMessage();
            DB::rollBack();
        }
    }
}
