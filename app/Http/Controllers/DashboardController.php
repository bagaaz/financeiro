<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Helpers\Helper;
use App\Models\TransactionInstallment;
use Carbon\Carbon;
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
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        if ($start->diffInDays($end) < 60) {
            $groupBy = "DATE(transactions_installments.transaction_date)";
        } elseif ($start->diffInMonths($end) <= 24) {
            $groupBy = "DATE_FORMAT(transactions_installments.transaction_date, '%Y-%m')";
        } else {
            $groupBy = "YEAR(transactions_installments.transaction_date)";
        }

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

        $incomeByCategory = TransactionInstallment::join('transactions', 'transactions.id', '=', 'transactions_installments.transaction_id')
            ->join('transactions_categories', 'transactions_categories.id', '=', 'transactions.category_id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.transaction_type', TransactionType::Income)
            ->whereBetween('transactions_installments.transaction_date', [
                $request->start,
                $request->end,
            ])
            ->selectRaw('SUM(installment_amount) as total, transactions.category_id, transactions_categories.name as category_name, transactions_categories.color as category_color')
            ->groupBy('transactions.category_id')
            ->get();

        $periodBalance = TransactionInstallment::join('transactions', 'transactions.id', '=', 'transactions_installments.transaction_id')
            ->where('transactions.user_id', $user->id)
            ->whereBetween('transactions_installments.transaction_date', [$request->start, $request->end])
            ->selectRaw("{$groupBy} as period, SUM(CASE WHEN transactions.transaction_type = ? THEN installment_amount * -1 ELSE installment_amount END) as balance", [TransactionType::Expense])
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $annualData = TransactionInstallment::join('transactions', 'transactions.id', '=', 'transactions_installments.transaction_id')
            ->where('transactions.user_id', $user->id)
            ->whereYear('transactions_installments.transaction_date', Carbon::now()->year)
            ->selectRaw(
                "DATE_FORMAT(transactions_installments.transaction_date, '%m') as month,
                 SUM(CASE WHEN transactions.transaction_type = ? THEN installment_amount ELSE 0 END) as income,
                 SUM(CASE WHEN transactions.transaction_type = ? THEN installment_amount * -1 ELSE 0 END) as expense",
                [TransactionType::Income, TransactionType::Expense]
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $incomeData = [];
        $expenseData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthNumber = sprintf("%02d", $i);
            $found = $annualData->firstWhere('month', $monthNumber);
            $income = $found ? $found->income : 0;
            $expense = $found ? $found->expense : 0;
            $incomeData[] = $income;
            $expenseData[] = $expense;
        }

        return response()->json([
            'paidValue' => Helper::floatToReal($paidValue),
            'pendingValue' => Helper::floatToReal($pendingValue),
            'totalExpanse' => Helper::floatToReal($totalExpanse),
            'totalIncome' => Helper::floatToReal($totalIncome),
            'expanseByCategory' => $expanseByCategory->map(function ($item) {
                return [
                    'total' => $item->total,
                    'category' => $item->category_name,
                    'color' => $item->category_color,
                ];
            }),
            'incomeByCategory' => $incomeByCategory->map(function ($item) {
                return [
                    'total' => $item->total,
                    'category' => $item->category_name,
                    'color' => $item->category_color,
                ];
            }),
            'periodBalance' => $periodBalance,
            'annualBalance' => [
                'income' => $incomeData,
                'expense' => $expenseData,
            ],
        ]);
    }
}
