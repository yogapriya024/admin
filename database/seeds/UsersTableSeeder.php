<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('users');

        $table->insert([
            'name' => 'System',
            'email' => 'admin@email.com',
            'password' => Hash::make('Admin@123'),

        ]);

        
    }
}
