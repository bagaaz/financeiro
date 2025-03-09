<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\Helper;
use App\Models\TransactionInstallment;
use Illuminate\Http\Request;

class TransactionsInstallmentsController extends Controller
{
    public function update(Request $request, int $transactionId)
    {
        $installment = TransactionInstallment::findOrFail($transactionId);

        if (empty($installment)) {
            Alert::error(__('messages.error_message'));
            return redirect()->back();
        }

        $installment->transaction_date = $request->get('transaction_date');
        $installment->installment_amount = Helper::realToFloat($request->get('installment_amount'));

        $installment->save();

        Alert::success(__('messages.all_right_message'));
        return redirect()->back();
    }
}
