<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $pendingDisposisi = Disposisi::whereIn('status', ['Segera', 'Sangat Segera'])->count();
        $selesaiDiproses = SuratMasuk::where('status', 'ARCHIVED')->count();

        $recentSurat = SuratMasuk::latest()->take(5)->get();
        
        // Real data for chart (Last 6 months)
        $stats = SuratMasuk::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("DATE_FORMAT(tanggal_terima, '%b') as month"),
            DB::raw("MONTH(tanggal_terima) as month_num")
        )
        ->where('tanggal_terima', '>=', now()->subMonths(6))
        ->groupBy('month', 'month_num')
        ->orderBy('month_num')
        ->get();

        $monthlyStats = [
            'labels' => $stats->pluck('month')->toArray(),
            'data' => $stats->pluck('count')->toArray()
        ];

        // Fallback if no data
        if (empty($monthlyStats['labels'])) {
            $monthlyStats = [
                'labels' => ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN'],
                'data' => [0, 0, 0, 0, 0, 0]
            ];
        }

        return view('dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'pendingDisposisi',
            'selesaiDiproses',
            'recentSurat',
            'monthlyStats'
        ));
    }
}
