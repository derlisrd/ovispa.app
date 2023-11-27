<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {


        $userId = Auth::id();
        $cat = Category::where('user_id', $userId)
        ->get();
        return response()->json([
            'success'=>true,
            'results'=> $cat
        ]);
    }
}
