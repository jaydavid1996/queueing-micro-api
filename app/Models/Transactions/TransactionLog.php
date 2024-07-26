<?php
namespace App\Models\Transactions;

use App\Models\BaseModel;

class TransactionLog extends BaseModel
{
    protected $fillable = [
        'transaction_id',
        'status',
        'user_id',
        'meta',
        'remarks',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transactions\Transaction', 'transaction_id', 'id');
    }
}