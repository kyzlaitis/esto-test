<?php

namespace App\Http\Controllers;

use App\User;

class UserTransactionController extends Controller
{
    public function index()
    {
        return User::getLastTen();
    }
}
