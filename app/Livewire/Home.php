<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\CoaCategory;
use Carbon\Carbon;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;

class Home extends Component
{
    public $monthlyReport = [];
    public $startMonth, $endMonth;
    
    public function render()
    {
        $transactionsQuery = Transaction::with(['chartOfAccount.category']);
        $categoriesFromDb = CoaCategory::all()->groupBy('type');

        $incomeCategories = $categoriesFromDb->get('income', collect())->pluck('name')->toArray();
        $expenseCategories = $categoriesFromDb->get('expense', collect())->pluck('name')->toArray();

        if ($this->startMonth && $this->endMonth) {
            $start = Carbon::parse($this->startMonth)->startOfMonth();
            $end = Carbon::parse($this->endMonth)->endOfMonth();

            $transactionsQuery->whereBetween('date', [$start, $end]);
        }

        $transactions = $transactionsQuery->get();

        $grouped = $transactions->sortBy('date')->groupBy(function ($trx) {
            return Carbon::parse($trx->date)->format('Y-m');
        });

        $categories = array_merge($incomeCategories, $expenseCategories);

        $this->monthlyReport = $grouped->map(function ($trxInMonth) use ($incomeCategories, $expenseCategories, $categories) {
            $groupedByCategory = $trxInMonth->groupBy(function ($trx) {
                return $trx->chartOfAccount->category->name;
            });

            $report = [];

            foreach ($categories as $categoryName) {
                $transactionsInCategory = $groupedByCategory->get($categoryName, collect());

                $total = $transactionsInCategory->reduce(function ($sum, $trx) {
                    $amount = $trx->debit > 0 ? $trx->debit : $trx->credit;
                    return $sum + $amount;
                }, 0);

                $report[$categoryName] = $total;


                if (in_array($categoryName, $incomeCategories)) {
                    $index = array_search($categoryName, $incomeCategories);
                    if ($index === count($incomeCategories) - 1) {
                        $total_income = collect($report)->only($incomeCategories)->sum();
                        $report['total_income'] = $total_income;
                    }
                }
            }

            $total_expense = collect($report)->only($expenseCategories)->sum();
            $report['total_expense'] = $total_expense;
            $report['net_income'] = $report['total_income'] - $total_expense;

            return $report;
        });

        // dd($this->monthlyReport);

        return view('livewire.home', [
            'monthlyReport' => $this->monthlyReport,
            'categories' => $categories,
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ])->layout('layouts.app');
    }


    public function mount()
    {

    }

    public function export() 
    {
        $filename = $this->startMonth && $this->endMonth ? "reports_{$this->startMonth}-{$this->endMonth}.xlsx" : "reports.xlsx";

        return Excel::download(new TransactionExport($this->startMonth, $this->endMonth), $filename);
    }
}
