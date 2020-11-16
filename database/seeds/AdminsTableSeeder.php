<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new App\Admin;
        $admin->name = "Utchas";
        $admin->email = "utchas903@gmail.com";
        $admin->password = Hash::make('LE.882427');
        $admin->job_title = "System Developer";
        $admin->nid = 9876543210;
        $admin->phone = 1521479924;
        $admin->save();
    }
}
