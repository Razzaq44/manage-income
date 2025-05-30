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
    
    public function render()
    {
        $transactions = Transaction::with(['chartOfAccount.category'])->get();

        $grouped = $transactions->groupBy(function ($trx) {
            return Carbon::parse($trx->date)->format('Y-m');
        });

        $categoryTypes = [];
        $incomeCategories = collect();
        $expenseCategories = collect();

        $this->monthlyReport = $grouped->map(function ($transactions, $month) use (&$incomeCategories, &$expenseCategories, &$categoryTypes) {
            $categories = [];
            $totalIncome = 0;
            $totalExpense = 0;

            foreach ($transactions as $trx) {
                $category = $trx->chartOfAccount->category;
                $catName = $category->name;
                $catType = $category->type;
    
                $categoryTypes[$catName] = $catType;
    
                if (!isset($categories[$catName])) {
                    $categories[$catName] = 0;
                }
    
                if ($catType === 'income') {
                    $categories[$catName] += $trx->credit;
                    $totalIncome += $trx->credit;
                    $incomeCategories->push($catName);
                } elseif ($catType === 'expense') {
                    $categories[$catName] += $trx->debit;
                    $totalExpense += $trx->debit;
                    $expenseCategories->push($catName);
                }
            }
    
            $categories['Total Income'] = $totalIncome;
            $categories['Total Expense'] = $totalExpense;
            $categories['Net Income'] = $totalIncome - $totalExpense;
    
            $categoryTypes['Total Income'] = 'total-income';
            $categoryTypes['Total Expense'] = 'total-expense';
            $categoryTypes['Net Income'] = 'net-income';
    
            return $categories;
        });

        $categories = $incomeCategories->unique()
            ->merge(['Total Income'])
            ->merge($expenseCategories->unique())
            ->merge(['Total Expense', 'Net Income']);

        return view('livewire.home', [
            'monthlyReport' => $this->monthlyReport,
            'categories' => $categories,
            'categoryTypes' => $categoryTypes,
        ])->layout('layouts.app');
    }


    public function mount()
    {

    }

    public function export() 
    {
        return Excel::download(new TransactionExport, 'reports.xlsx');
    }
}
