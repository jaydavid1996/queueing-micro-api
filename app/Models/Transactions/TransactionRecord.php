<?php
namespace App\Models\Transactions;

use App\Models\Transactions\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TransactionRecord extends Transaction
{

    use HasFactory;
    const TYPE = 1;
    const DEFAULT_is_priority = false;

    protected $table = 'transactions';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type',  TransactionRecord::TYPE);
        });

        static::creating(function ($model) {
            if (empty($model->type)) {
                $model->type = TransactionRecord::TYPE;
            }
            if(  (auth()->user() !== null) || $model->barangay_id ){

                if( empty($model->barangay_id) && (auth()->user()->barangay_id == null)  ) {
                    throw new \Exception("No Barangay ID provided Trace#1");
                }

                $barangay_id = $model->barangay_id ?? auth()->user()->barangay_id;
                $model->reference_id =  IdGenerator::generate([
                    'table' => 'transactions', 
                    'length' => 46, 
                    'field' => 'reference_id',
                    'reset_on_prefix_change' => true,
                    'prefix' => $model->barangay_id . '-R' . date('y') . '-'
                ]);

            } else {
                throw new \Exception("No Barangay ID provided Trace#2");
            }
        });
    }
}
