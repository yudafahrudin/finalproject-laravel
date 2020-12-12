<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        return response(['status' => 'success', 'data' => $user]);
    }
}
