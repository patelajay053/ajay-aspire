<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $input = [
            'type' => 'Admin',
            'name' => 'Admin',
            'email' => 'admin@localhost.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('Ajay@123'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $user = \App\Models\User::create($input);
        
        $this->command->info('Admin added.');
    }
}
