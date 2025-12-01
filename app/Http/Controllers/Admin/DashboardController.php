<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PTK;
use App\Models\Document;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_ptk' => PTK::count(),
            'total_documents' => Document::where('status', 'aktif')->count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'recent_activities' => ActivityLog::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];

        // PTK by status kepegawaian
        $ptkByStatus = PTK::selectRaw('status_kepegawaian, count(*) as total')
            ->groupBy('status_kepegawaian')
            ->get();

        // Documents by category
        $documentsByCategory = Document::with('category')
            ->selectRaw('category_id, count(*) as total')
            ->where('status', 'aktif')
            ->groupBy('category_id')
            ->get();

        return view('admin.dashboard', compact('stats', 'ptkByStatus', 'documentsByCategory'));
    }
}
