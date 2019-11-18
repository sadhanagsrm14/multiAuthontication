<?php

use Illuminate\Database\Seeder;
use App\Role;
class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_user = new App\Role;
        $role_author = new App\Role;
        $role_admin = new App\Role;

$role_user->name= "user";
$role_user->save();


$role_author->name= "Author";
$role_author->save();


$role_admin->name= "Admin";
$role_admin->save();
    }
}
