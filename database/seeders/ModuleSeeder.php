<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        Module::create([
                        'code' =>'1',
                        'name' => 'Contact',
                        'description' => 'Main module'
                      ]);
        Module::create([
                        'code' =>'1.1',
                        'name' => 'Company',
                        'description' => 'Sub module',
                        'parent_code' => '1'
                      ]);
        Module::create([
                        'code' =>'1.2',
                        'name' => 'People',
                        'description' => 'Sub module',
                        'parent_code' => '1']);

        Module::create([
                          'code' =>'2',
                          'name' => 'Account',
                          'description' => 'Main module'
                      ]);
        Module::create([
                        'code' =>'2.1',
                        'name' => 'Notes',
                        'description' => 'Sub module',
                        'parent_code' => '2'
                      ]);
        Module::create([
                        'code' =>'2.2',
                        'name' => 'Activity Log',
                        'description' => 'Sub module',
                        'parent_code' => '2'
                      ]);
        Module::create([
                        'code' =>'2.3',
                        'name' => 'Meetings',
                        'description' => 'Sub module',
                        'parent_code' => '2'
                      ]);
    }
}
