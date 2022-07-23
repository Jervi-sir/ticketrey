<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AccountHelperController extends Controller
{
    public function createAccount($role, $name, $email, $password, $details = null) {
        $role_client = Role::where('name', $role)->first();

        $user = new User();
        $user->role_id = $role_client;
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->details = $details;
        $user->save();

        return $user;
    }
}
