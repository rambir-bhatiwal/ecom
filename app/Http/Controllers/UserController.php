<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index(){
        return view('admin.users.index');
    }

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
    public function edit(){
        return view('admin.users.edit');
    }
    public function show(){
        return view('admin.users.show');
    }

    public function destroy(){
        return view('admin.users.destroy');
    }
    public function update(){
        return view('admin.users.update');
    }

    public function store(){
        return view('admin.users.store');
    }
}
