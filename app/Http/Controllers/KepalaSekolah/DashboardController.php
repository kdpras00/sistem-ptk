<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\PTK;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display Kepala Sekolah dashboard
     */
    public function index(Request $request)
    {
        $stats = [
            'total_ptk' => PTK::count(),
            'total_documents' => Document::active()->count(),
            'total_categories' => Category::active()->count(),
        ];

        // PTK by status kepegawaian
        $ptkByStatus = PTK::selectRaw('status_kepegawaian, count(*) as total')
            ->groupBy('status_kepegawaian')
            ->get();

        // Get PTK list with search and filter
        $query = PTK::with(['user', 'documents']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status kepegawaian
        if ($request->filled('status_kepegawaian')) {
            $query->byStatusKepegawaian($request->status_kepegawaian);
        }

        $ptkList = $query->latest()->paginate(10);

        return view('kepala-sekolah.dashboard', compact('stats', 'ptkByStatus', 'ptkList'));
    }

    /**
     * Display PTK details
     */
    public function showPTK(PTK $ptk)
    {
        $ptk->load(['user', 'documents.category']);
        return view('kepala-sekolah.ptk-detail', compact('ptk'));
    }
}
