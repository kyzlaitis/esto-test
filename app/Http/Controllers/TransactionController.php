<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(StoreTransactionRequest $request)
    {
        $data = $request['data']['attributes'];


        try {
            DB::beginTransaction();

            $transaction = new Transaction($data);
            $transaction->user()->associate(auth()->user());
            $transaction->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response()->json(new TransactionResource($transaction), 201);
    }
}
