<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PTK;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display Guru dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $ptk = PTK::with('documents.category')
            ->where('user_id', $user->id)
            ->first();

        if (!$ptk) {
            return view('guru.dashboard')->with('error', 'Data PTK Anda belum tersedia.');
        }

        return view('guru.dashboard', compact('ptk'));
    }
}
