<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;

class UserTransactionController extends Controller
{
    public function index()
    {
        return User::getLastTen();
    }
}
