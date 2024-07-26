<?php
namespace App\Models\Transactions;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends BaseModel
{
    use TransactionObserver;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // add barangay_id here

            if(  (auth()->user() !== null) || $model->barangay_id ){

                if( empty($model->barangay_id) && (auth()->user()->barangay_id == null)  ) {
                    throw new \Exception("No Barangay ID provided Trace#1");
                }

                $model->barangay_id = $model->barangay_id ?? auth()->user()->barangay_id;

            } else {
                throw new \Exception("No Barangay ID provided Trace#2");
            }

            $model->log('created');
        });

        //Fetch only data with barangay id
        static::addGlobalScope('barangay_id', function (Builder $builder) {
            $builder->whereNotNull('barangay_id');

            if( auth()->user() ){

                if( (auth()->user()->barangay_id == null) && !auth()->user()->hasRole('admin')) {
                    throw new \Exception("No Barangay ID provided Trace#3");
                }

                $builder->where('barangay_id', auth()->user()->barangay_id);
            }

        });

        static::updated(function ($model) {
            $model->log('updated');
        });

        static::deleted(function ($model) {
            $model->log('deleted');
        });
    }
    protected $fillable = [
        'resident_id',
        'barangay_id',
        'type',
        'meta',
        'status',
        'is_priority',
        'payment_status',
        'payment_date',
        'reference_id'
    ];

    protected $casts = [
        'meta' => 'array',
        'is_priority' => 'boolean',
        'payment_date' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Type of Transaction
     * # Records = 1
     * # Document = 2
     * # Complaint = 3
     */
    /**
     * Type of Status
     * # onqueue
     * # inprogress
     * # completed
     * # cancelled
     */

    protected function referenceId(): Attribute
    {

        return Attribute::make(
            get: fn (string $value) => explode('-', $value)[count(explode('-', $value)) - 2] . '-' . explode('-', $value)[count(explode('-', $value)) - 1],
            
        );
    }

    public function resident()
    {
        return $this->belongsTo('App\Models\Resident', 'resident_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\Transactions\TransactionLog', 'transaction_id', 'id');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\Barangay', 'barangay_id', 'id');
    }
}
