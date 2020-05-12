<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'permission',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getLastTen()
    {
        $lastTenCreated = DB::table('users')
            ->select(['name', 'id'])
            ->orderBy('created_at', 'desc')
            ->limit(10);

        $lastTenCreatedDebitSum = DB::table('transactions')
            ->select(['latestTenCreated.name'])
            ->selectRaw('SUM(amount) as debitSum')
            ->joinSub($lastTenCreated, 'latestTenCreated', function ($join) {
                $join->on('latestTenCreated.id', '=', 'transactions.user_id');
            })
            ->where('type', 'debit')->groupBy('user_id')->get();

        return $lastTenCreatedDebitSum;
    }

}
