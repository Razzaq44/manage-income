<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CoaCategory;
use App\Models\ChartOfAccount;
use App\Models\Transaction;
use Carbon\Carbon;

class initSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income'],
            ['name' => 'Other Income', 'type' => 'income'],
            ['name' => 'Family Expense', 'type' => 'expense'],
            ['name' => 'Transport Expense', 'type' => 'expense'],
            ['name' => 'Meal Expense', 'type' => 'expense'],
        ];

        $categoryMap = [];

        foreach ($categories as $cat) {
            $category = CoaCategory::create([
                'name' => $cat['name'],
                'type' => $cat['type'],
            ]);
            $categoryMap[$cat['name']] = $category->id;
        }

        $accounts = [
            ['code' => 401, 'name' => 'Gaji Karyawan', 'category' => 'Salary'],
            ['code' => 402, 'name' => 'Gaji Ketua MPR', 'category' => 'Salary'],
            ['code' => 403, 'name' => 'Profit Trading', 'category' => 'Other Income'],
            ['code' => 601, 'name' => 'Biaya Sekolah', 'category' => 'Family Expense'],
            ['code' => 602, 'name' => 'Bensin', 'category' => 'Transport Expense'],
        ];

        foreach ($accounts as $acc) {
            ChartOfAccount::create([
                'code' => $acc['code'],
                'name' => $acc['name'],
                'category_id' => $categoryMap[$acc['category']],
            ]);
        }

        foreach (ChartOfAccount::all() as $account) {
            for ($i = 0; $i < 3; $i++) {
                Transaction::create([
                    'date' => Carbon::today()->subDays(rand(0, 30))->format('Y-m-d'),
                    'coa_code' => $account->code,
                    'description' => 'Transaksi untuk ' . $account->name,
                    'debit' => rand(0, 1) ? rand(10000, 1000000) : 0,
                    'credit' => rand(0, 1) ? rand(10000, 1000000) : 0,
                ]);
            }
        }
    }

}
