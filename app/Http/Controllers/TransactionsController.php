<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\Helper;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use App\Models\TransactionInstallment;
use App\Enums\TransactionStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear + 5);

        $query = TransactionInstallment::with('transaction.category');

        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }

        $query->whereHas('transaction', function ($q) use ($request) {
            if ($request->filled('title')) {
                $q->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->filled('category_id')) {
                $q->where('category_id', $request->category_id);
            }
            if ($request->filled('record_type')) {
                $q->where('transaction_type', $request->record_type);
            }
            if ($request->filled('payment_type')) {
                $q->where('payment_type', $request->payment_type);
            }
        });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->get();

        $categories = TransactionCategory::pluck('name', 'id');

        return view('pages.transactions.index', compact('transactions', 'years', 'categories'));
    }



    public function create()
    {
        $categories = TransactionCategory::pluck('name', 'id')->all();
        return view('pages.transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $dados = $request->all();
        $dados['total_amount'] = Helper::realToFloat($dados['total_amount']);

        $transaction = Transaction::create([
            'user_id'           => $user->id,
            'title'             => $dados['title'],
            'description'       => $dados['description'],
            'total_amount'      => $dados['total_amount'],
            'category_id'       => $dados['category_id'],
            'transaction_date'  => $dados['transaction_date'],
            'transaction_type'  => $dados['transaction_type'],
            'payment_type'      => $dados['payment_type'],
            'installments_count'      => $dados['installments'],
            'status'            => $dados['status'],
        ]);

        if ($transaction) {
            $installments = (int) $dados['installments'];
            if ($installments > 0) {
                $transactionDate = Carbon::parse($dados['transaction_date'])->startOfMonth();

                $installmentAmount = Helper::realToFloat($dados['total_amount']) / $installments;

                for ($i = 0; $i < $installments; $i++) {
                    $installmentDate = $transactionDate->copy()->addMonths($i);
                    TransactionInstallment::create([
                        'transaction_id'   => $transaction->id,
                        'installment_number' => $i + 1,
                        'installment_amount' => $installmentAmount,
                        'transaction_date' => $installmentDate,
                        'status'           => $dados['status'],
                    ]);
                }
            }

            Alert::success(__('messages.all_right_message'));
            return redirect()->back();
        }

        Alert::error(__('messages.error_message'));
        return redirect()->back();
    }

    public function edit(int $id)
    {
        $transaction = Transaction::with(['installments', 'category'])->findOrFail($id);
        $categories = TransactionCategory::pluck('name', 'id')->all();

        return view('pages.transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $transaction = Transaction::with('installments')->findOrFail($id);

        $dados = $request->all();
        $newTotalAmount = Helper::realToFloat($dados['total_amount']);
        $newInstallmentsCount = (int) $dados['installments'];

        $needsRecalculation = false;
        if ($transaction->total_amount != $newTotalAmount) {
            $needsRecalculation = true;
        }
        if ($transaction->installments_count != $newInstallmentsCount) {
            $needsRecalculation = true;
        }
        if ($transaction->payment_type != $dados['payment_type']) {
            $needsRecalculation = true;
        }

        $transaction->title = $dados['title'];
        $transaction->description = $dados['description'];
        $transaction->total_amount = $newTotalAmount;
        $transaction->category_id = $dados['category_id'];
        $transaction->transaction_date = $dados['transaction_date'];
        $transaction->transaction_type = $dados['transaction_type'];
        $transaction->payment_type = $dados['payment_type'];
        $transaction->installments_count = $newInstallmentsCount;
        $transaction->status = $dados['status'];
        $transaction->save();

        if ($needsRecalculation) {
            $transaction->installments()->delete();

            if ($newInstallmentsCount > 0) {
                $transactionDate = Carbon::parse($dados['transaction_date'])->startOfMonth();
                $installmentAmount = $newTotalAmount / $newInstallmentsCount;

                for ($i = 0; $i < $newInstallmentsCount; $i++) {
                    $installmentDate = $transactionDate->copy()->addMonths($i);
                    TransactionInstallment::create([
                        'transaction_id'     => $transaction->id,
                        'installment_number' => $i + 1,
                        'installment_amount' => $installmentAmount,
                        'transaction_date'   => $installmentDate,
                        'status'             => $dados['status'],
                    ]);
                }
            }
        }

        Alert::success(__('messages.all_right_message'));
        return redirect()->back();
    }

    public function destroy(Request $request, int $id)
    {
        $transaction = Transaction::with('installments')->findOrFail($id);

        $transaction->installments()->delete();
        $transaction->delete();

        Alert::success(__('messages.all_right_message'));
        return redirect()->back();
    }


    public function status(int $id)
    {
        $installment = TransactionInstallment::with('transaction')->findOrFail($id);

        if ($installment->status === TransactionStatus::Pending) {
            $installment->status = TransactionStatus::Completed;
        } else {
            $installment->status = TransactionStatus::Pending;
        }
        $installment->save();

        $transaction = $installment->transaction;

        if ($transaction->installments_count > 1) {
            $allInstallments = $transaction->installments()->get();

            $allCompleted = $allInstallments->every(function ($inst) {
                return $inst->status->value === 1;
            });

            $transaction->status = $allCompleted
                ? TransactionStatus::Completed
                : TransactionStatus::Pending;
            $transaction->save();
        } else {
            $transaction->status = $installment->status;
            $transaction->save();
        }

        Alert::success(__('messages.all_right_message'));
        return redirect()->back();
    }

}
