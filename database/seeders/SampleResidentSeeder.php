<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleResidentSeeder extends Seeder
{
    public function run(): void
    {
        $barangay = \App\Models\Barangay::first();
        if($barangay == null) {
            $barangay = \App\Models\Barangay::factory(1)->create();
        }
        $resident = \App\Models\Resident::factory(5)->create([
            'barangay_id' => $barangay->first()->id
        ]);
        $complaint = \App\Models\Transactions\TransactionComplaint::factory(5)->create([
            'resident_id' => $resident->first()->id,
            'barangay_id' => $barangay->first()->id
        ]);
    }
}
