<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Test extends Controller
{
    public function test(){
        return [
            'result' => true
        ];
    }
}
