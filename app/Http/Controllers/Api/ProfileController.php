<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        // $user = auth()->user();
        // $user_class_id = auth()->user()->class_id;
        // if ($user_class_id) {
        //     $user->class = auth()->user()->class;
        // }
        return response(['status' => 'success', 'data' => $user]);
    }
}