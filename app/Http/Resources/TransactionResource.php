<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type'       => 'transactions',
                'attributes' => [
                    'user_id'        => $this->user->id,
                    'transaction_id' => $this->id,
                    'type'           => $this->type,
                    'amount'         => $this->amount,
                ],
            ],
        ];
    }
}
