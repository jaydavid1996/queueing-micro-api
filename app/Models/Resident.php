<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Resident extends BaseModel
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // add barangay_id here

            if( (auth()->user() !== null) || $model->barangay_id ){

                if( empty($model->barangay_id) && (auth()->user()->barangay_id == null)  ) {
                    throw new \Exception("No Barangay ID provided Trace#4");
                }

                $model->barangay_id = $model->barangay_id ?? auth()->user()->barangay_id;

            } else {
                throw new \Exception("No Barangay ID provided Trace#5");
            }
        });

        //Fetch only data with barangay id
        static::addGlobalScope('barangay_id', function (Builder $builder) {
            $builder->whereNotNull('barangay_id');

            if (auth()->user()){

                if( (auth()->user()->barangay_id == null) && !auth()->user()->hasRole('admin')) {
                    throw new \Exception("No Barangay ID provided Trace#6");
                }

                // $builder->where('barangay_id', auth()->user()->barangay_id);
            }

        });

    }
    protected $fillable = [
        'barangay_id',
        'first_name',
        'middle_name',
        'last_name',
        'address_1',
        'address_2',
        'email',
        'image_url',
        'occupation',
        'marital_status',
        'government_grant',
        'vaccination_status',
        'foreigner',
        'pet_owner',
        'pet_type',
        'contact_number',
    ];

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'resident_id', 'id');
    }

}
