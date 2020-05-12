<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['type', 'amount'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}
