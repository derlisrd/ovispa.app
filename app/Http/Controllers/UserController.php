<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{


    public function destroy(Request $r){


        return response()->json([
            'success'=>true,
            'user'=>$r->user
        ]);
    }
}
