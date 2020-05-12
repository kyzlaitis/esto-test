<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
                'type'       => 'users',
                'user_id'    => $this->id,
                'attributes' => [
                    'name'       => $this->name,
                    'email'      => $this->email,
                    'permission' => $this->permission,
                ],
            ],
        ];
    }
}
