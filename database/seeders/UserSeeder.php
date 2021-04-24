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
        $this->user =  new User();

        $this->user->name = 'Admin';
        $this->user->email = 'admin@example.com';
        $this->user->email_verified_at = now();
        $this->user->password = bcrypt(123);
        $this->user->save();

        $user = User::find(1);
        $user->assignRole('Administrator');
    }
}
