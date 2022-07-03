<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UsersController extends Controller
{
    public function index() {

        return Inertia::render('Users', [
            "users" => user::orderBy('created_at', 'DESC')->paginate(10)
        ]);
        
    }
}
