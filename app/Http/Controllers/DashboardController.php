<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Helpers\Helper;
use App\Models\TransactionInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function data(Request $request)
    {
        $user = Auth::user();

        $paidValue = TransactionInstallment::with('transaction.category')
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('transaction_type', TransactionType::Expense);
            })
            ->whereBetween('transaction_date', [$request->start, $request->end])
            ->where('status', TransactionStatus::Completed)
            ->sum('installment_amount');

        $pendingValue = TransactionInstallment::with('transaction.category')
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('transaction_type', TransactionType::Expense);
            })
            ->whereBetween('transaction_date', [$request->start, $request->end])
            ->where('status', TransactionStatus::Pending)
            ->sum('installment_amount');

        $totalExpanse = TransactionInstallment::with('transaction.category')
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('transaction_type', TransactionType::Expense);
            })
            ->whereBetween('transaction_date', [$request->start, $request->end])
            ->sum('installment_amount');

        $totalIncome = TransactionInstallment::with('transaction.category')
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('transaction_type', TransactionType::Income);
            })
            ->whereBetween('transaction_date', [$request->start, $request->end])
            ->sum('installment_amount');

        $expanseByCategory = TransactionInstallment::join('transactions', 'transactions.id', '=', 'transactions_installments.transaction_id')
            ->join('transactions_categories', 'transactions_categories.id', '=', 'transactions.category_id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.transaction_type', TransactionType::Expense)
            ->whereBetween('transactions_installments.transaction_date', [
                $request->start,
                $request->end,
            ])
            ->selectRaw('SUM(installment_amount) as total, transactions.category_id, transactions_categories.name as category_name, transactions_categories.color as category_color')
            ->groupBy('transactions.category_id')
            ->get();


        return response()->json([
            'paidValue' => Helper::floatToReal($paidValue),
            'pendingValue' => Helper::floatToReal($pendingValue),
            'totalExpanse' => Helper::floatToReal($totalExpanse),
            'totalIncome' => Helper::floatToReal($totalIncome),
            'expanseByCategory' => $expanseByCategory->map(function ($item) {
                return [
                    'total' => Helper::floatToReal($item->total),
                    'category' => $item->category_name,
                    'color' => $item->category_color,
                ];
            }),
        ]);
    }
}
