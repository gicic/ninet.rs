<?php

use App\Models\OperatingSystem;
use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class OperatingSystemsTableSeeder extends Seeder
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

            $housingLine = ProductLine::where('code', 'server-housing')->first();
            $linuxLine = ProductLine::where('code', 'linux-servers')->first();
            $windowsLine = ProductLine::where('code', 'windows-servers')->first();

            $system1 = OperatingSystem::create(['name' => 'CentOS 5']);
            $system1->productLines()->attach($housingLine->id);
            $system1->productLines()->attach($linuxLine->id);

            $system2 = OperatingSystem::create(['name' => 'CentOS 6']);
            $system2->productLines()->attach($housingLine->id);
            $system2->productLines()->attach($linuxLine->id);

            $system3 = OperatingSystem::create(['name' => 'CentOS 7']);
            $system3->productLines()->attach($housingLine->id);
            $system3->productLines()->attach($linuxLine->id);

            $system4 = OperatingSystem::create(['name' => 'Ubuntu 10']);
            $system4->productLines()->attach($housingLine->id);
            $system4->productLines()->attach($linuxLine->id);

            $system5 = OperatingSystem::create(['name' => 'Ubuntu 12']);
            $system5->productLines()->attach($housingLine->id);
            $system5->productLines()->attach($linuxLine->id);

            $system6 = OperatingSystem::create(['name' => 'Ubuntu 14']);
            $system6->productLines()->attach($housingLine->id);
            $system6->productLines()->attach($linuxLine->id);

            $system7 = OperatingSystem::create(['name' => 'Windows Server 2012']);
            $system7->productLines()->attach($windowsLine->id);

            $system8 = OperatingSystem::create(['name' => 'Windows Server 2016']);
            $system8->productLines()->attach($windowsLine->id);

            $system9 = OperatingSystem::create(['name' => 'Windows Server 2019']);
            $system9->productLines()->attach($windowsLine->id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }
}
