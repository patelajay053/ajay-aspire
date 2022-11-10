<?php

namespace Modules\Customers\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CustomersDatabaseSeeder extends Seeder
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
            'name' => 'Ajay Patel',
            'email' => 'patel.ajay053@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('Ajay@123'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $user = \App\Models\User::create($input);
        
        $this->command->info('Customer added.');
    }
}
