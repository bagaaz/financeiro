<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionInstallment;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear + 5);

        $valorPago = 'R$ 00,00';
        $valorAPagar = 'R$ 00,00';
        $totalGastos = 'R$ 00,00';
        $totalEntradas = 'R$ 00,00';

        return view('pages.dashboard.index', compact('years', 'valorPago', 'valorAPagar', 'totalGastos', 'totalEntradas'));
    }
}
