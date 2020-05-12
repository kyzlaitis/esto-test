<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;

class TransactionController extends Controller
{
    public function store(StoreTransactionRequest $request)
    {
        $data = $request['data']['attributes'];

        $transaction = new Transaction($data);

        $transaction->user()->associate(auth()->user());
        $transaction->save();

        return response()->json(new TransactionResource($transaction), 201);
    }
}
