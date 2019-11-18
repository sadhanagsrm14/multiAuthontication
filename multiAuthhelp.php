1] create new project using cmd(composer create-project laravel/laravel authProject) 
2] Open cmd as admin go to the project like as cd/xampp/htdocs/ authProject
3] Execute cmd like as php artisan make:auth (this cmd create login and registration in your project)
4] Execute cmd like as php artisan migrate(this cmd create the table into database)
5] Execute cmd like as php artisan make:model Role -m (this cmd create model named Role along with creating table into database)
6] Go to the database >> migrations >> open the role table file >> write these code.
	
	public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('roles');
    }

7] Now create the role_id column in user table using cmd like php artisan make:migration on update_users_table --table users(this command creates the update user table migration file) >> open this file >> write the code like as

public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
            //
        });
    }

8] Now execute the migrate cmd like as php artisan migrate
9] add dummy value using seed first create the seed using cmd like php artisan make:seed UserRolesSeeder (this cmd create a see file located at database >> seed) >> Now open this file and write this code.

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

10] Now Open the DatabaseSeeder.php file and uncomment the code and change the code like this.
	public function run()
    {
         $this->call(UserRolesSeeder::class);
    }

11] Now execute the cmd php artisan db:seed (This cmd insert data into role table).
12] Now open the user model file named User.php >> add new columna like role_id ,traits and role function like this. Role function create the relationship between role and user table. 
 
	use App\Role;
 	
 	protected $fillable = [
        'name', 'email', 'password','role_id'
    ];


    public function role(){
        return $this->belongsTo('App\Role');
    }
13] Now go to the app >> http >> auth >> Open RegisterController.php  file and write code like as
	
	use App\User;

	protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 1
        ]);
    }
14] Now open the Role model named Role.php and write code like as

<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Role extends Model
{
    //

    protected $fillable = [
        'name', 
    ];
    public function users(){
    	return $this->hasMany('App\User');
    }
}

15] Now we create the user by using registration form.
16] Now create the three file like as user.blade.php , admin.blade.php and author.blade.php copy code from home.blade.php.
17] Now open the controller file named HomeController.php >> change the code like this.


use App\User;
use Auth;

public function index()
    {
        return view(Auth::user()->role->name);
    }

    


