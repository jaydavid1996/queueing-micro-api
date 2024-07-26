<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
    ];

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'barangay_id', 'id');
    }
}