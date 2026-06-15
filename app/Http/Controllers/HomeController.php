<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            return match (Auth::user()->role) {

                'admin'   => redirect()->route('admin.dashboard'),
                'trainer' => redirect()->route('trainer.dashboard'),
                'member'  => redirect()->route('member.dashboard'),
                'staff'   => redirect()->route('staff.dashboard'),

                default   => view('home'),
            };
        }

        return view('home');
    }
}