<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function balance()
    {
        $user = Auth::user();
        $balance = $user->balance();

        if(!$balance) {
            $balance = $user->makeBalance();
        }

        $operations = $user->getOperations(5);

        return view('pages.balance', [
            'balance' => $balance,
            'operations' => $operations,
        ]);
    }

    public function history()
    {
        $user = Auth::user();
        $operations = $user->getOperations();

        return view('pages.history', [
            'operations' => $operations
        ]);
    }

    public function refreshBalance() {
        $user = Auth::user();
        $balance = $user->balance();

        if(!$balance) {
            $balance = $user->makeBalance();
        }

        $operations = $user->getOperations(5);
        $operations_data = [];
        foreach($operations as $operation) {
            $operations_data[] = $operation->getSerialized();
        }

        return response()->json([
            'success' => true, 
            'balance_amount' => $balance->amount, 
            'operations' => $operations_data
        ]);
    }
}
