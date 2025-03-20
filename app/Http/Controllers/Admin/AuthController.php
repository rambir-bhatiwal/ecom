<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Auth;
class AuthController extends Controller
{
    public function create(){
        // return view('admin.users.create');
        $user = new User();
        $user->name = "Admin1";
        $user->email = "admin11@admin.com";
        $user->password = bcrypt('admin');
        $user->save();

        // Role::where('slug', 'Admin' )->users()->attach($user);
        $customer = Role::where('slug','admin')->first();
 
        $user->roles()->attach($customer);

    }
}
