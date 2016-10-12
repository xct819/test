<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class Index extends Controller
{
    public function index(){
        $q = str_slug('qqqqq qqqqq');
        dump(User::find(1));
        dump($q);
    }
}
