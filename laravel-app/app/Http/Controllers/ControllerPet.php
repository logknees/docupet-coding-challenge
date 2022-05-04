<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ControllerPet extends Controller
{

    public function __construct(
     ) {
    }

    public function create(Request $request){
        $params = $request->params;
        echo $params;
    }
}
