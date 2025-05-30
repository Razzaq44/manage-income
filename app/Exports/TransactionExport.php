<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class TransactionExport implements FromView
{
    public function view(): View
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

            return view('exports.report', [
                'monthlyReport' => $this->monthlyReport,
                'categories' => $categories,
                'categoryTypes' => $categoryTypes,
                'getCellClass' => function ($type) {
                    return match ($type) {
                        'income' => 'background-color:#d1fae5; color:#065f46; width: 180px; height: 24px;',
                        'expense' => 'background-color:#fee2e2; color:#991b1b; width: 180px; height: 24px;',
                        'total-income' => 'background-color:#10b981; color:#ffffff; font-weight:bold; width: 180px; height: 24px;',
                        'total-expense' => 'background-color:#ef4444; color:#ffffff; font-weight:bold; width: 180px; height: 24px;',
                        'net-income' => 'background-color:#ffffff; color:#000000; font-weight:bold; width: 180px; height: 24px;',
                        default => '',
                    };
                },
            ]);
    }

    public function export() 
    {
        return Excel::download(new TransactionExport, 'reports.xlsx');
    }
}
