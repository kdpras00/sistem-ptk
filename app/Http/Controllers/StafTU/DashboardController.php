<?php

namespace App\Http\Controllers\StafTU;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\PTK;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display Staf TU dashboard
     */
    public function index()
    {
        $stats = [
            'total_documents' => Document::where('uploaded_by', auth()->id())->count(),
            'documents_this_month' => Document::where('uploaded_by', auth()->id())
                ->whereMonth('created_at', now()->month)
                ->count(),
            'total_ptk' => PTK::count(),
            'total_categories' => Category::active()->count(),
        ];

        $recentDocuments = Document::with(['ptk', 'category'])
            ->where('uploaded_by', auth()->id())
            ->latest()
            ->limit(5)
            ->get();

        return view('staf-tu.dashboard', compact('stats', 'recentDocuments'));
    }
}
