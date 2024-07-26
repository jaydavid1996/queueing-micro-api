<?php 
namespace App\Observers;

trait TransactionObserver 
{

    public function log($status)
    {   
        
        $this->logs()->create([
            'transaction_id' => $this->id,
            'meta' => $this->getDirty(),
            'remarks' => $this->status,
            'user_id' => auth()->user()->id ?? 'system',
        ]);
    }

    public function logs()
    {
        return $this->morphMany('App\Models\Transactions\TransactionLog', 'transaction');
    }
}